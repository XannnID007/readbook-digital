<?php

namespace App\Services;

use App\Models\Book;
use App\Models\User;
use App\Models\ReadingHistory;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class RecommendationService
{
    public function getRecommendations($preferredCategories, $limit = 12)
    {
        try {
            Log::info('🔍 Getting recommendations', [
                'preferred_categories' => $preferredCategories,
                'user_id' => auth()->id(),
                'limit' => $limit
            ]);

            // Validasi input
            if (empty($preferredCategories) || !is_array($preferredCategories)) {
                Log::warning('❌ Invalid preferred categories');
                return collect();
            }

            // Dapatkan buku berdasarkan kategori preferensi
            $books = Book::whereIn('category_id', $preferredCategories)
                ->where('is_active', true)
                ->with(['category', 'readingHistories', 'bookmarks'])
                ->get();

            Log::info('📚 Books found', ['count' => $books->count()]);

            if ($books->isEmpty()) {
                return collect();
            }

            if (auth()->check()) {
                // Jika user sudah login, gunakan K-Means clustering
                return $this->applyKMeansClustering($books, $limit);
            }

            // Jika guest, return berdasarkan popularitas dan rating
            return $books->sortByDesc(function ($book) {
                return ($book->views * 0.7) + ($book->rating * 0.3);
            })->take($limit)->values();

        } catch (\Exception $e) {
            Log::error('❌ Error in getRecommendations', [
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
            
            // Fallback ke rekomendasi simple
            return $this->getFallbackRecommendations($preferredCategories, $limit);
        }
    }

    private function applyKMeansClustering($books, $limit)
    {
        try {
            Log::info('🤖 Applying K-Means clustering');
            
            $user = auth()->user();

            // Dapatkan data untuk clustering
            $userData = $this->getUserData($user);
            $bookData = $this->getBookData($books);

            if (empty($bookData)) {
                Log::warning('⚠️ No book data for clustering');
                return $books->take($limit);
            }

            // Tentukan jumlah cluster optimal (maksimal 5, minimal 2)
            $k = min(max(2, intval(sqrt($books->count()))), 5);
            Log::info('📊 Using K clusters', ['k' => $k]);

            // Implementasi K-Means
            $clusters = $this->kMeansClustering($bookData, $k);

            // Tentukan cluster yang paling cocok dengan user
            $userCluster = $this->findBestClusterForUser($userData, $clusters, $bookData);

            // Return buku dari cluster terbaik
            $recommendedBookIds = $clusters[$userCluster] ?? [];
            
            if (empty($recommendedBookIds)) {
                Log::warning('⚠️ No books in user cluster, using fallback');
                return $this->getFallbackRecommendations($user->preferences ?? [], $limit);
            }

            $result = $books->whereIn('id', $recommendedBookIds)->take($limit);
            
            Log::info('✅ K-Means completed', [
                'user_cluster' => $userCluster,
                'recommended_count' => $result->count()
            ]);

            return $result;

        } catch (\Exception $e) {
            Log::error('❌ Error in K-Means clustering', [
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
            
            return $this->getFallbackRecommendations($user->preferences ?? [], $limit);
        }
    }

    private function getUserData($user)
    {
        try {
            // Analisis preferensi user berdasarkan history bacaan
            $readingHistory = ReadingHistory::where('user_id', $user->id)
                ->with('book.category')
                ->get();

            $categoryPreferences = [];
            $totalReadingTime = 0;
            $avgRatingPreference = 0;
            $pagePreferences = [];

            foreach ($readingHistory as $history) {
                if ($history->book && $history->book->category) {
                    $categoryId = $history->book->category_id;
                    $categoryPreferences[$categoryId] = ($categoryPreferences[$categoryId] ?? 0) + 1;
                    
                    // Hitung preferensi berdasarkan progress
                    $progress = $history->last_page / max($history->book->pages, 1);
                    $categoryPreferences[$categoryId] += $progress; // Bonus untuk buku yang dibaca lebih banyak
                    
                    $totalReadingTime += $history->last_page * 2; // 2 menit per halaman
                    $avgRatingPreference += $history->book->rating;
                    $pagePreferences[] = $history->book->pages;
                }
            }

            $historyCount = $readingHistory->count();
            
            return [
                'category_preferences' => $categoryPreferences,
                'total_books_read' => $historyCount,
                'avg_rating_preference' => $historyCount > 0 ? $avgRatingPreference / $historyCount : 3.5,
                'avg_pages_preference' => !empty($pagePreferences) ? array_sum($pagePreferences) / count($pagePreferences) : 200,
                'total_reading_time' => $totalReadingTime,
                'preferred_categories' => $user->preferences ?? [],
                'diversity_score' => count($categoryPreferences) // Semakin banyak kategori = lebih diverse
            ];
        } catch (\Exception $e) {
            Log::error('❌ Error getting user data', ['error' => $e->getMessage()]);
            
            return [
                'category_preferences' => [],
                'total_books_read' => 0,
                'avg_rating_preference' => 3.5,
                'avg_pages_preference' => 200,
                'total_reading_time' => 0,
                'preferred_categories' => $user->preferences ?? [],
                'diversity_score' => 1
            ];
        }
    }

    private function getBookData($books)
    {
        $bookData = [];

        foreach ($books as $book) {
            // Normalisasi data untuk clustering
            $bookData[$book->id] = [
                'category_id' => $book->category_id,
                'views_normalized' => $this->normalizeValue($book->views, 0, 10000), // 0-1
                'rating_normalized' => $book->rating / 5.0, // 0-1
                'pages_normalized' => $this->normalizeValue($book->pages, 50, 1000), // 0-1
                'publication_year_normalized' => $this->normalizeValue($book->publication_year, 1900, date('Y')), // 0-1
                'popularity_score' => $this->calculatePopularityScore($book),
                'readability_score' => $this->calculateReadabilityScore($book)
            ];
        }

        return $bookData;
    }

    private function normalizeValue($value, $min, $max)
    {
        if ($max - $min == 0) return 0;
        return max(0, min(1, ($value - $min) / ($max - $min)));
    }

    private function calculatePopularityScore($book)
    {
        // Gabungan views, rating, dan bookmark count
        $bookmarkCount = $book->bookmarks->count();
        $readingCount = $book->readingHistories->count();
        
        return ($book->views * 0.4) + ($book->rating * 0.3) + ($bookmarkCount * 0.2) + ($readingCount * 0.1);
    }

    private function calculateReadabilityScore($book)
    {
        // Score berdasarkan panjang buku dan rating
        $pageScore = 1 - $this->normalizeValue($book->pages, 50, 1000); // Buku pendek = skor tinggi
        $ratingScore = $book->rating / 5.0;
        
        return ($pageScore * 0.3) + ($ratingScore * 0.7);
    }

    private function kMeansClustering($data, $k)
    {
        try {
            Log::info('🔄 Starting K-Means with k=' . $k);
            
            if (count($data) < $k) {
                Log::warning('⚠️ Data count less than K, adjusting');
                $k = max(1, count($data));
            }

            $clusters = [];
            $centroids = [];

            // Inisialisasi centroid menggunakan k-means++
            $centroids = $this->initializeCentroidsKMeansPlusPlus($data, $k);

            // Inisialisasi clusters
            for ($i = 0; $i < $k; $i++) {
                $clusters[$i] = [];
            }

            $maxIterations = 20;
            $tolerance = 0.001;
            $prevCentroids = null;

            // Iterasi K-Means
            for ($iteration = 0; $iteration < $maxIterations; $iteration++) {
                Log::info("📈 K-Means iteration " . ($iteration + 1));
                
                // Reset clusters
                for ($i = 0; $i < $k; $i++) {
                    $clusters[$i] = [];
                }

                // Assign setiap data point ke cluster terdekat
                foreach ($data as $bookId => $bookFeatures) {
                    $closestCluster = $this->findClosestCluster($bookFeatures, $centroids);
                    $clusters[$closestCluster][] = $bookId;
                }

                // Simpan centroid sebelumnya untuk pengecekan konvergensi
                $prevCentroids = $centroids;

                // Update centroids
                $centroids = $this->updateCentroids($clusters, $data);

                // Cek konvergensi
                if ($this->hasConverged($prevCentroids, $centroids, $tolerance)) {
                    Log::info("✅ K-Means converged at iteration " . ($iteration + 1));
                    break;
                }
            }

            // Log hasil clustering
            foreach ($clusters as $i => $cluster) {
                Log::info("📊 Cluster $i has " . count($cluster) . " books");
            }

            return $clusters;

        } catch (\Exception $e) {
            Log::error('❌ Error in K-Means clustering', [
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
            
            // Fallback: random assignment
            return $this->randomClusterAssignment($data, $k);
        }
    }

    private function initializeCentroidsKMeansPlusPlus($data, $k)
    {
        $centroids = [];
        $dataKeys = array_keys($data);
        
        if (empty($dataKeys)) {
            return $centroids;
        }

        // Pilih centroid pertama secara random
        $firstKey = $dataKeys[array_rand($dataKeys)];
        $centroids[0] = $data[$firstKey];

        // Pilih centroid berikutnya berdasarkan jarak
        for ($i = 1; $i < $k; $i++) {
            $distances = [];
            
            foreach ($data as $bookId => $bookFeatures) {
                $minDistance = PHP_FLOAT_MAX;
                
                // Cari jarak minimum ke centroid yang sudah ada
                for ($j = 0; $j < $i; $j++) {
                    $distance = $this->calculateDistance($bookFeatures, $centroids[$j]);
                    $minDistance = min($minDistance, $distance);
                }
                
                $distances[$bookId] = $minDistance * $minDistance; // Square distance
            }
            
            // Pilih berdasarkan probabilitas proporsional dengan jarak
            $totalDistance = array_sum($distances);
            if ($totalDistance > 0) {
                $randomValue = mt_rand() / mt_getrandmax() * $totalDistance;
                $cumulativeDistance = 0;
                
                foreach ($distances as $bookId => $distance) {
                    $cumulativeDistance += $distance;
                    if ($cumulativeDistance >= $randomValue) {
                        $centroids[$i] = $data[$bookId];
                        break;
                    }
                }
            } else {
                // Fallback jika semua jarak 0
                $randomKey = $dataKeys[array_rand($dataKeys)];
                $centroids[$i] = $data[$randomKey];
            }
        }

        return $centroids;
    }

    private function findClosestCluster($point, $centroids)
    {
        $minDistance = PHP_FLOAT_MAX;
        $closestCluster = 0;

        foreach ($centroids as $clusterIndex => $centroid) {
            $distance = $this->calculateDistance($point, $centroid);
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $closestCluster = $clusterIndex;
            }
        }

        return $closestCluster;
    }

    private function calculateDistance($point1, $point2)
    {
        $distance = 0;
        $features = ['views_normalized', 'rating_normalized', 'pages_normalized', 'publication_year_normalized', 'popularity_score', 'readability_score'];
        
        foreach ($features as $feature) {
            $val1 = $point1[$feature] ?? 0;
            $val2 = $point2[$feature] ?? 0;
            $distance += pow($val1 - $val2, 2);
        }

        return sqrt($distance);
    }

    private function updateCentroids($clusters, $data)
    {
        $centroids = [];
        
        foreach ($clusters as $clusterIndex => $clusterBooks) {
            if (empty($clusterBooks)) {
                // Jika cluster kosong, gunakan centroid random
                $dataKeys = array_keys($data);
                if (!empty($dataKeys)) {
                    $randomKey = $dataKeys[array_rand($dataKeys)];
                    $centroids[$clusterIndex] = $data[$randomKey];
                }
                continue;
            }

            $centroid = [
                'category_id' => 0,
                'views_normalized' => 0,
                'rating_normalized' => 0,
                'pages_normalized' => 0,
                'publication_year_normalized' => 0,
                'popularity_score' => 0,
                'readability_score' => 0
            ];

            $count = count($clusterBooks);

            foreach ($clusterBooks as $bookId) {
                if (isset($data[$bookId])) {
                    $bookData = $data[$bookId];
                    foreach ($centroid as $key => $value) {
                        $centroid[$key] += $bookData[$key] ?? 0;
                    }
                }
            }

            foreach ($centroid as $key => $value) {
                $centroid[$key] = $count > 0 ? $value / $count : 0;
            }

            $centroids[$clusterIndex] = $centroid;
        }

        return $centroids;
    }

    private function hasConverged($prevCentroids, $centroids, $tolerance)
    {
        if ($prevCentroids === null) {
            return false;
        }

        foreach ($centroids as $i => $centroid) {
            if (!isset($prevCentroids[$i])) {
                return false;
            }
            
            $distance = $this->calculateDistance($centroid, $prevCentroids[$i]);
            if ($distance > $tolerance) {
                return false;
            }
        }

        return true;
    }

    private function findBestClusterForUser($userData, $clusters, $bookData)
    {
        try {
            $bestCluster = 0;
            $bestScore = -1;

            foreach ($clusters as $clusterIndex => $clusterBooks) {
                if (empty($clusterBooks)) {
                    continue;
                }
                
                $score = $this->calculateClusterScore($userData, $clusterBooks, $bookData);
                
                Log::info("🎯 Cluster $clusterIndex score: $score");
                
                if ($score > $bestScore) {
                    $bestScore = $score;
                    $bestCluster = $clusterIndex;
                }
            }

            Log::info("🏆 Best cluster selected: $bestCluster with score: $bestScore");
            return $bestCluster;

        } catch (\Exception $e) {
            Log::error('❌ Error finding best cluster', ['error' => $e->getMessage()]);
            return 0; // Fallback ke cluster pertama
        }
    }

    private function calculateClusterScore($userData, $clusterBooks, $bookData)
    {
        $score = 0;
        $preferredCategories = $userData['preferred_categories'] ?? [];
        $categoryPreferences = $userData['category_preferences'] ?? [];
        $userAvgRating = $userData['avg_rating_preference'] ?? 3.5;
        $userAvgPages = $userData['avg_pages_preference'] ?? 200;

        foreach ($clusterBooks as $bookId) {
            if (!isset($bookData[$bookId])) continue;
            
            $book = $bookData[$bookId];
            $bookScore = 0;

            // 1. Kategori preference score (40%)
            if (in_array($book['category_id'], $preferredCategories)) {
                $bookScore += 40;
                
                // Bonus jika user punya history dengan kategori ini
                if (isset($categoryPreferences[$book['category_id']])) {
                    $bookScore += $categoryPreferences[$book['category_id']] * 5;
                }
            }

            // 2. Rating preference score (25%)
            $ratingDiff = abs(($book['rating_normalized'] * 5) - $userAvgRating);
            $bookScore += max(0, 25 - ($ratingDiff * 5));

            // 3. Popularity score (20%)
            $bookScore += $book['popularity_score'] * 20;

            // 4. Pages preference score (10%)
            $currentPages = $book['pages_normalized'] * 1000; // Denormalize
            $pagesDiff = abs($currentPages - $userAvgPages);
            $bookScore += max(0, 10 - ($pagesDiff / 100));

            // 5. Readability score (5%)
            $bookScore += $book['readability_score'] * 5;

            $score += $bookScore;
        }

        // Rata-rata score per buku di cluster
        return count($clusterBooks) > 0 ? $score / count($clusterBooks) : 0;
    }

    private function randomClusterAssignment($data, $k)
    {
        $clusters = [];
        for ($i = 0; $i < $k; $i++) {
            $clusters[$i] = [];
        }

        foreach (array_keys($data) as $bookId) {
            $randomCluster = rand(0, $k - 1);
            $clusters[$randomCluster][] = $bookId;
        }

        return $clusters;
    }

    private function getFallbackRecommendations($preferredCategories, $limit)
    {
        try {
            Log::info('🔄 Using fallback recommendations');
            
            return Book::whereIn('category_id', $preferredCategories)
                ->where('is_active', true)
                ->orderByRaw('(views * 0.4 + rating * 0.6) DESC')
                ->take($limit)
                ->get();
                
        } catch (\Exception $e) {
            Log::error('❌ Error in fallback recommendations', ['error' => $e->getMessage()]);
            
            return Book::where('is_active', true)
                ->orderBy('views', 'desc')
                ->take($limit)
                ->get();
        }
    }
}