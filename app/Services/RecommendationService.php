<?php

namespace App\Services;

use App\Models\Book;
use App\Models\User;
use App\Models\ReadingHistory;

class RecommendationService
{
     public function getRecommendations($preferredCategories, $limit = 12)
     {
          // Dapatkan buku berdasarkan kategori preferensi
          $books = Book::whereIn('category_id', $preferredCategories)
               ->where('is_active', true)
               ->with('category')
               ->get();

          if (auth()->check()) {
               // Jika user sudah login, gunakan K-Means clustering
               return $this->applyKMeansClustering($books, $limit);
          }

          // Jika guest, return berdasarkan popularitas dan rating
          return $books->sortByDesc(function ($book) {
               return ($book->views * 0.7) + ($book->rating * 0.3);
          })->take($limit);
     }

     private function applyKMeansClustering($books, $limit)
     {
          $user = auth()->user();

          // Dapatkan data untuk clustering
          $userData = $this->getUserData($user);
          $bookData = $this->getBookData($books);

          // Implementasi sederhana K-Means
          $clusters = $this->kMeansClustering($bookData, 3); // 3 cluster

          // Tentukan cluster yang paling cocok dengan user
          $userCluster = $this->findBestClusterForUser($userData, $clusters);

          // Return buku dari cluster terbaik
          $recommendedBookIds = $clusters[$userCluster] ?? [];

          return $books->whereIn('id', $recommendedBookIds)->take($limit);
     }

     private function getUserData($user)
     {
          // Analisis preferensi user berdasarkan history bacaan
          $readingHistory = ReadingHistory::where('user_id', $user->id)
               ->with('book.category')
               ->get();

          $categoryPreferences = [];
          foreach ($readingHistory as $history) {
               $categoryId = $history->book->category_id;
               $categoryPreferences[$categoryId] = ($categoryPreferences[$categoryId] ?? 0) + 1;
          }

          return [
               'category_preferences' => $categoryPreferences,
               'total_books_read' => $readingHistory->count(),
               'preferred_categories' => $user->preferences ?? []
          ];
     }

     private function getBookData($books)
     {
          $bookData = [];

          foreach ($books as $book) {
               $bookData[$book->id] = [
                    'category_id' => $book->category_id,
                    'views' => $book->views,
                    'rating' => $book->rating,
                    'pages' => $book->pages,
                    'publication_year' => $book->publication_year
               ];
          }

          return $bookData;
     }

     private function kMeansClustering($data, $k)
     {
          // Implementasi K-Means sederhana
          $clusters = [];
          $centroids = [];

          // Inisialisasi centroid secara random
          $dataKeys = array_keys($data);
          for ($i = 0; $i < $k; $i++) {
               $randomKey = $dataKeys[array_rand($dataKeys)];
               $centroids[$i] = $data[$randomKey];
               $clusters[$i] = [];
          }

          // Iterasi K-Means
          for ($iteration = 0; $iteration < 10; $iteration++) {
               // Reset clusters
               foreach ($clusters as $clusterIndex => $cluster) {
                    $clusters[$clusterIndex] = [];
               }

               // Assign setiap data point ke cluster terdekat
               foreach ($data as $bookId => $bookFeatures) {
                    $closestCluster = $this->findClosestCluster($bookFeatures, $centroids);
                    $clusters[$closestCluster][] = $bookId;
               }

               // Update centroids
               foreach ($clusters as $clusterIndex => $clusterBooks) {
                    if (!empty($clusterBooks)) {
                         $centroids[$clusterIndex] = $this->calculateCentroid($clusterBooks, $data);
                    }
               }
          }

          return $clusters;
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

          // Normalisasi dan hitung jarak Euclidean
          $distance += pow(($point1['views'] - $point2['views']) / 1000, 2);
          $distance += pow(($point1['rating'] - $point2['rating']) / 5, 2);
          $distance += pow(($point1['pages'] - $point2['pages']) / 500, 2);

          return sqrt($distance);
     }

     private function calculateCentroid($clusterBooks, $data)
     {
          $centroid = [
               'category_id' => 0,
               'views' => 0,
               'rating' => 0,
               'pages' => 0,
               'publication_year' => 0
          ];

          $count = count($clusterBooks);

          foreach ($clusterBooks as $bookId) {
               $bookData = $data[$bookId];
               $centroid['views'] += $bookData['views'];
               $centroid['rating'] += $bookData['rating'];
               $centroid['pages'] += $bookData['pages'];
               $centroid['publication_year'] += $bookData['publication_year'];
          }

          foreach ($centroid as $key => $value) {
               $centroid[$key] = $value / $count;
          }

          return $centroid;
     }

     private function findBestClusterForUser($userData, $clusters)
     {
          // Pilih cluster dengan buku yang paling sesuai dengan preferensi user
          $bestCluster = 0;
          $bestScore = 0;

          foreach ($clusters as $clusterIndex => $clusterBooks) {
               $score = $this->calculateClusterScore($userData, $clusterBooks);
               if ($score > $bestScore) {
                    $bestScore = $score;
                    $bestCluster = $clusterIndex;
               }
          }

          return $bestCluster;
     }

     private function calculateClusterScore($userData, $clusterBooks)
     {
          $score = 0;
          $preferredCategories = $userData['preferred_categories'];

          foreach ($clusterBooks as $bookId) {
               $book = Book::find($bookId);
               if ($book && in_array($book->category_id, $preferredCategories)) {
                    $score += 1;
               }
          }

          return $score;
     }
}
