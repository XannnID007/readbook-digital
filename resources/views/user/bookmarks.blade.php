@extends('layouts.app')

@push('styles')
    <style>
        /* Orange Theme Variables */
        :root {
            --primary-orange: #ff6b35;
            --secondary-orange: #ff8c42;
            --light-orange: #ffa366;
            --warm-white: #ffffff;
            --soft-gray: #f8f9fa;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
        }

        .bookmarks-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.9));
            min-height: calc(100vh - 150px);
            border-radius: 20px;
            padding: 2.5rem;
            margin: 1rem 0;
            box-shadow: 0 10px 40px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(2deg);
            }
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .header-title {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .btn-header {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 15px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-header:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-header-primary {
            background: var(--text-dark);
            border-color: var(--text-dark);
        }

        .btn-header-primary:hover {
            background: #34495e;
            border-color: #34495e;
            color: white;
        }

        .filter-card {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
            transition: all 0.3s ease;
        }

        .filter-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(255, 107, 53, 0.15);
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .filter-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .filter-info i {
            color: #ffc107;
            font-size: 1.2rem;
        }

        .filter-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .elegant-select {
            background: var(--soft-gray);
            border: 2px solid rgba(255, 107, 53, 0.2);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.3s ease;
            min-width: 150px;
        }

        .elegant-select:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
            outline: none;
            background: white;
        }

        .btn-clear-all {
            background: linear-gradient(135deg, #dc3545, #c82333);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-clear-all:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
            color: white;
        }

        .bookmarks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .bookmark-card {
            background: var(--warm-white);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 107, 53, 0.1);
            transition: all 0.4s ease;
            position: relative;
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.08);
            height: 100%;
        }

        .bookmark-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(255, 107, 53, 0.15);
            border-color: var(--primary-orange);
        }

        .book-image-container {
            position: relative;
            height: 300px;
            overflow: hidden;
        }

        .book-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .bookmark-card:hover .book-image-container img {
            transform: scale(1.05);
        }

        .book-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
        }

        .featured-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: var(--text-dark);
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
            z-index: 3;
        }

        .category-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            z-index: 3;
        }

        .bookmark-btn {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            z-index: 3;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        }

        .bookmark-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(255, 193, 7, 0.5);
        }

        .book-content {
            padding: 1.5rem;
        }

        .book-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-author {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .book-description {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-stats {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: var(--soft-gray);
            border-radius: 12px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-value.pages {
            color: var(--primary-orange);
        }

        .stat-value.rating {
            color: #ffc107;
        }

        .stat-value.views {
            color: #28a745;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .rating-display {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .stars {
            color: #ffc107;
            font-size: 0.9rem;
        }

        .bookmark-date {
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 500;
        }

        .progress-section {
            background: rgba(40, 167, 69, 0.05);
            border: 1px solid rgba(40, 167, 69, 0.2);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .progress-bar-elegant {
            height: 6px;
            border-radius: 3px;
            background: rgba(40, 167, 69, 0.2);
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #28a745, #20c997);
            border-radius: 3px;
            transition: width 0.3s ease;
        }

        .action-buttons {
            display: grid;
            gap: 0.75rem;
        }

        .btn-read {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border: none;
            border-radius: 12px;
            padding: 1rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }

        .btn-read:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
            color: white;
        }

        .secondary-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid var(--text-muted);
            border-radius: 12px;
            padding: 0.75rem;
            color: var(--text-muted);
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            flex: 1;
        }

        .btn-secondary:hover {
            border-color: var(--primary-orange);
            color: var(--primary-orange);
            transform: translateY(-2px);
        }

        .btn-remove {
            background: transparent;
            border: 2px solid #dc3545;
            border-radius: 12px;
            padding: 0.75rem;
            color: #dc3545;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 50px;
        }

        .btn-remove:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        .empty-state {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .empty-icon {
            font-size: 4rem;
            color: #ffc107;
            margin-bottom: 2rem;
            opacity: 0.7;
        }

        .empty-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .empty-description {
            color: var(--text-muted);
            font-size: 1.1rem;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .empty-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .bookmarks-container {
                padding: 1.5rem;
            }

            .page-header {
                padding: 2rem 1.5rem;
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }

            .header-title {
                font-size: 1.8rem;
            }

            .header-actions {
                justify-content: center;
                flex-wrap: wrap;
            }

            .filter-card {
                padding: 1.5rem;
            }

            .filter-header {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-controls {
                flex-direction: column;
            }

            .bookmarks-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }

            .book-stats {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .secondary-actions {
                flex-direction: column;
            }

            .empty-actions {
                flex-direction: column;
                align-items: center;
            }
        }

        @media (max-width: 576px) {
            .bookmarks-grid {
                grid-template-columns: 1fr;
            }

            .btn-header {
                width: 100%;
                text-align: center;
            }

            .filter-controls {
                gap: 0.75rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="bookmarks-container">
            <!-- Header -->
            <div class="page-header d-flex justify-content-between align-items-center">
                <div class="header-content">
                    <h2 class="header-title">
                        <i class="fas fa-bookmark"></i>
                        <span>Bookmark Saya</span>
                    </h2>
                    <p class="header-subtitle">Koleksi buku yang Anda simpan untuk dibaca nanti</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('user.dashboard') }}" class="btn-header">
                        <i class="fas fa-arrow-left me-1"></i>Dashboard
                    </a>
                    <a href="{{ route('home') }}" class="btn-header btn-header-primary">
                        <i class="fas fa-plus me-1"></i>Tambah Bookmark
                    </a>
                </div>
            </div>

            @if ($bookmarks->count() > 0)
                <!-- Filter & Actions -->
                <div class="filter-card">
                    <div class="filter-header">
                        <div class="filter-info">
                            <i class="fas fa-bookmark"></i>
                            <span>{{ $bookmarks->total() }} buku dalam bookmark</span>
                        </div>
                        <div class="filter-controls">
                            <select class="elegant-select" onchange="filterByCategory(this.value)">
                                <option value="all">Semua Kategori</option>
                                @foreach ($bookmarks->pluck('book.category')->unique('id') as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <select class="elegant-select" onchange="sortBookmarks(this.value)">
                                <option value="recent">Terbaru Disimpan</option>
                                <option value="rating">Rating Tertinggi</option>
                                <option value="popular">Paling Populer</option>
                                <option value="title">Judul A-Z</option>
                            </select>
                            <button class="btn-clear-all" onclick="clearAllBookmarks()">
                                <i class="fas fa-trash me-1"></i>Hapus Semua
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Bookmarks Grid -->
                <div class="bookmarks-grid" id="bookmarksContainer">
                    @foreach ($bookmarks as $bookmark)
                        <div class="bookmark-card bookmark-item" data-category="{{ $bookmark->book->category_id }}"
                            data-rating="{{ $bookmark->book->rating }}" data-views="{{ $bookmark->book->views }}"
                            data-title="{{ $bookmark->book->title }}" data-date="{{ $bookmark->created_at->timestamp }}">

                            <div class="book-image-container">
                                @if ($bookmark->book->cover_image)
                                    <img src="{{ Storage::url($bookmark->book->cover_image) }}"
                                        alt="{{ $bookmark->book->title }}">
                                @else
                                    <div class="book-placeholder">
                                        <i class="fas fa-book fa-4x"></i>
                                    </div>
                                @endif

                                <!-- Badges -->
                                @if ($bookmark->book->is_featured)
                                    <div class="featured-badge">
                                        <i class="fas fa-star me-1"></i>Unggulan
                                    </div>
                                @endif
                                <div class="category-badge">{{ $bookmark->book->category->name }}</div>

                                <!-- Bookmark Remove Button -->
                                <button class="bookmark-btn" onclick="removeBookmark({{ $bookmark->book->id }})"
                                    title="Hapus dari bookmark">
                                    <i class="fas fa-bookmark"></i>
                                </button>
                            </div>

                            <div class="book-content">
                                <h6 class="book-title">{{ $bookmark->book->title }}</h6>
                                <p class="book-author">oleh {{ $bookmark->book->author }}</p>
                                <p class="book-description">{{ $bookmark->book->description }}</p>

                                <!-- Book Stats -->
                                <div class="book-stats">
                                    <div class="stat-item">
                                        <div class="stat-value pages">{{ $bookmark->book->pages }}</div>
                                        <div class="stat-label">Halaman</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value rating">{{ $bookmark->book->rating }}</div>
                                        <div class="stat-label">Rating</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value views">{{ number_format($bookmark->book->views) }}</div>
                                        <div class="stat-label">Views</div>
                                    </div>
                                </div>

                                <!-- Rating Display -->
                                <div class="rating-display">
                                    <div class="stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $bookmark->book->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    <small class="bookmark-date">
                                        Disimpan {{ $bookmark->created_at->diffForHumans() }}
                                    </small>
                                </div>

                                <!-- Progress Info (if user has read this book) -->
                                @php
                                    $userProgress = $bookmark->book
                                        ->readingHistories()
                                        ->where('user_id', auth()->id())
                                        ->first();
                                @endphp
                                @if ($userProgress)
                                    <div class="progress-section">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted fw-medium">Progress Bacaan</small>
                                            <small class="fw-bold text-success">
                                                {{ round(($userProgress->last_page / $bookmark->book->pages) * 100) }}%
                                            </small>
                                        </div>
                                        <div class="progress-bar-elegant">
                                            <div class="progress-fill"
                                                style="width: {{ ($userProgress->last_page / $bookmark->book->pages) * 100 }}%">
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="action-buttons">
                                    <a href="{{ route('books.read', $bookmark->book->slug) }}" class="btn-read">
                                        <i class="fas fa-book-open me-1"></i>
                                        @if ($userProgress)
                                            Lanjut Baca
                                        @else
                                            Mulai Baca
                                        @endif
                                    </a>
                                    <div class="secondary-actions">
                                        <a href="{{ route('books.show', $bookmark->book->slug) }}" class="btn-secondary">
                                            <i class="fas fa-info-circle me-1"></i>Detail
                                        </a>
                                        <button class="btn-remove" onclick="removeBookmark({{ $bookmark->book->id }})"
                                            title="Hapus bookmark">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $bookmarks->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-bookmark"></i>
                    </div>
                    <h4 class="empty-title">Belum Ada Bookmark</h4>
                    <p class="empty-description">
                        Simpan buku favorit Anda dengan menekan ikon bookmark pada detail buku.
                        Bookmark memudahkan Anda untuk mengakses buku yang ingin dibaca nanti.
                    </p>
                    <div class="empty-actions">
                        <a href="{{ route('recommendations') }}" class="btn-read" style="padding: 1rem 2rem;">
                            <i class="fas fa-magic me-2"></i>Lihat Rekomendasi
                        </a>
                        <a href="{{ route('home') }}" class="btn-secondary" style="padding: 1rem 2rem;">
                            <i class="fas fa-search me-2"></i>Jelajahi Buku
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add entrance animations
            if ('IntersectionObserver' in window) {
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                }, observerOptions);

                // Observe bookmark cards
                document.querySelectorAll('.bookmark-card').forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition =
                        `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                    observer.observe(card);
                });
            }

            // Progress bar animation
            document.querySelectorAll('.progress-fill').forEach(bar => {
                const targetWidth = bar.style.width;
                bar.style.width = '0%';

                setTimeout(() => {
                    bar.style.width = targetWidth;
                }, 500);
            });
        });

        // Filter by category
        function filterByCategory(categoryId) {
            const items = document.querySelectorAll('.bookmark-item');
            const container = document.getElementById('bookmarksContainer');

            // Add loading effect
            container.style.opacity = '0.5';

            setTimeout(() => {
                    items.forEach(item => {
                            if (categoryId === 'all' || item.dataset.category === categoryId) {
                                item.style.display = 'block';
                                item.style.opacity = '0';
                                item.style.transform = 'translateY(20px)';

                                setTimeout(() => {
                                    item.style.transition = 'all 0.3s ease';
                                    item.style.opacity = '1';
                                    item.style.transform = 'translateY(0)';
                                }, 50);
                            }, index * 50);
                    });

                container.style.opacity = '1';
            }, 200);
        }

        // Enhanced remove bookmark with animation
        function removeBookmark(bookId) {
            if (confirm('Apakah Anda yakin ingin menghapus bookmark ini?')) {
                const bookmarkCard = document.querySelector(`[onclick*="removeBookmark(${bookId})"]`).closest(
                    '.bookmark-item');

                // Add removing animation
                bookmarkCard.style.transform = 'scale(0.8)';
                bookmarkCard.style.opacity = '0.5';

                $.post('{{ route('bookmark.toggle', ':id') }}'.replace(':id', bookId), {
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        showToast(response.message, 'success');

                        // Animate removal
                        bookmarkCard.style.transform = 'scale(0)';
                        bookmarkCard.style.opacity = '0';

                        setTimeout(() => {
                            bookmarkCard.remove();

                            // Check if no more bookmarks
                            if (document.querySelectorAll('.bookmark-item').length === 0) {
                                setTimeout(() => location.reload(), 1000);
                            }
                        }, 300);
                    })
                    .fail(function() {
                        // Restore card on error
                        bookmarkCard.style.transform = 'scale(1)';
                        bookmarkCard.style.opacity = '1';
                        showToast('Gagal menghapus bookmark', 'error');
                    });
            }
        }

        // Clear all bookmarks with enhanced confirmation
        function clearAllBookmarks() {
            const bookmarkCount = document.querySelectorAll('.bookmark-item').length;

            if (confirm(
                    `Apakah Anda yakin ingin menghapus SEMUA ${bookmarkCount} bookmark? Tindakan ini tidak dapat dibatalkan.`
                )) {
                const bookmarkItems = document.querySelectorAll('.bookmark-item');
                let completed = 0;
                let total = bookmarkItems.length;

                if (total === 0) return;

                // Show progress overlay
                const progressOverlay = document.createElement('div');
                progressOverlay.className =
                    'position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
                progressOverlay.style.cssText = 'background: rgba(0,0,0,0.8); z-index: 9999; color: white;';
                progressOverlay.innerHTML = `
            <div class="text-center">
                <div class="spinner-border mb-3" role="status"></div>
                <div>Menghapus bookmark... <span id="progressCount">0</span>/${total}</div>
            </div>
        `;
                document.body.appendChild(progressOverlay);

                bookmarkItems.forEach((item, index) => {
                    const bookId = item.querySelector('[onclick*="removeBookmark"]').getAttribute('onclick').match(
                        /\d+/)[0];

                    setTimeout(() => {
                        $.post('{{ route('bookmark.toggle', ':id') }}'.replace(':id', bookId), {
                                _token: '{{ csrf_token() }}'
                            })
                            .done(function() {
                                completed++;
                                document.getElementById('progressCount').textContent = completed;

                                // Animate item removal
                                item.style.transform = 'scale(0)';
                                item.style.opacity = '0';

                                if (completed === total) {
                                    setTimeout(() => {
                                        progressOverlay.remove();
                                        showToast('Semua bookmark berhasil dihapus', 'success');
                                        setTimeout(() => location.reload(), 1500);
                                    }, 500);
                                }
                            })
                            .fail(function() {
                                progressOverlay.remove();
                                showToast('Gagal menghapus beberapa bookmark', 'error');
                            });
                    }, index * 200); // Stagger the requests
                });
            }
        }

        // Enhanced toast notification
        function showToast(message, type = 'info') {
            const toastClass = {
                success: 'bg-success',
                error: 'bg-danger',
                warning: 'bg-warning',
                info: 'bg-info'
            };

            const toast = document.createElement('div');
            toast.className = `toast show position-fixed top-0 end-0 m-3 ${toastClass[type]} text-white`;
            toast.style.zIndex = '9999';
            toast.style.borderRadius = '15px';
            toast.style.backdropFilter = 'blur(10px)';
            toast.innerHTML = `
        <div class="toast-body">
            <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : type === 'warning' ? 'exclamation' : 'info'}-circle me-2"></i>
            ${message}
        </div>
    `;

            document.body.appendChild(toast);

            // Entrance animation
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                toast.style.transition = 'transform 0.3s ease';
                toast.style.transform = 'translateX(0)';
            }, 10);

            // Auto remove
            setTimeout(() => {
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Enhanced interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add ripple effect to buttons
            document.querySelectorAll('.btn-read, .btn-secondary, .btn-remove, .bookmark-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    // Create ripple element
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                background: rgba(255, 255, 255, 0.4);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                left: ${x}px;
                top: ${y}px;
                pointer-events: none;
            `;

                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Add CSS for ripple animation
            const style = document.createElement('style');
            style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .bookmark-card {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
            document.head.appendChild(style);

            // Enhanced hover effects
            document.querySelectorAll('.bookmark-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.borderColor = 'var(--primary-orange)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.borderColor = 'rgba(255, 107, 53, 0.1)';
                });
            });

            // Add loading states for action buttons
            document.querySelectorAll('.btn-read, .btn-secondary').forEach(btn => {
                if (btn.tagName === 'A') {
                    btn.addEventListener('click', function() {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Loading...';

                        setTimeout(() => {
                            this.innerHTML = originalText;
                        }, 2000);
                    });
                }
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Press 'Delete' to clear all bookmarks
                if (e.key === 'Delete' && e.ctrlKey) {
                    e.preventDefault();
                    clearAllBookmarks();
                }

                // Press 'F' to focus on category filter
                if (e.key.toLowerCase() === 'f' && e.ctrlKey) {
                    e.preventDefault();
                    const filterSelect = document.querySelector('.elegant-select');
                    if (filterSelect) {
                        filterSelect.focus();
                    }
                }

                // Press 'S' to focus on sort
                if (e.key.toLowerCase() === 's' && e.ctrlKey) {
                    e.preventDefault();
                    const sortSelect = document.querySelectorAll('.elegant-select')[1];
                    if (sortSelect) {
                        sortSelect.focus();
                    }
                }
            });

            // Smooth scrolling for pagination
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Add loading overlay during pagination
                    const container = document.getElementById('bookmarksContainer');
                    if (container) {
                        container.style.opacity = '0.5';
                        container.style.pointerEvents = 'none';
                    }
                });
            });

            // Performance optimization
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    // Recalculate layouts on resize
                    const cards = document.querySelectorAll('.bookmark-card');
                    cards.forEach(card => {
                        card.style.transition = 'none';
                        setTimeout(() => {
                            card.style.transition = '';
                        }, 100);
                    });
                }, 250);
            });

            // Enhanced accessibility
            document.querySelectorAll('.bookmark-card').forEach((card, index) => {
                card.setAttribute('tabindex', '0');
                card.setAttribute('role', 'article');
                card.setAttribute('aria-label',
                    `Bookmark ${card.querySelector('.book-title').textContent}`);

                // Keyboard navigation
                card.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const readBtn = this.querySelector('.btn-read');
                        if (readBtn) {
                            readBtn.click();
                        }
                    }

                    if (e.key === 'Delete') {
                        e.preventDefault();
                        const removeBtn = this.querySelector('.btn-remove');
                        if (removeBtn) {
                            removeBtn.click();
                        }
                    }
                });
            });

            // Add focus styles for accessibility
            const focusStyle = document.createElement('style');
            focusStyle.textContent = `
        .bookmark-card:focus {
            outline: 3px solid var(--primary-orange);
            outline-offset: 2px;
        }
        
        .elegant-select:focus {
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
        }
        
        .btn-read:focus,
        .btn-secondary:focus,
        .btn-remove:focus,
        .bookmark-btn:focus {
            outline: 2px solid var(--primary-orange);
            outline-offset: 2px;
        }
    `;
            document.head.appendChild(focusStyle);

            // Auto-update bookmark count
            const updateBookmarkCount = () => {
                const count = document.querySelectorAll('.bookmark-item').length;
                const countElement = document.querySelector('.filter-info span');
                if (countElement) {
                    countElement.textContent = `${count} buku dalam bookmark`;
                }
            };

            // Call update count after any bookmark removal
            const originalRemoveBookmark = window.removeBookmark;
            window.removeBookmark = function(bookId) {
                originalRemoveBookmark(bookId);
                setTimeout(updateBookmarkCount, 500);
            };
        });
    </script>
@endpush
