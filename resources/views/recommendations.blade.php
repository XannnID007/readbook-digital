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

        .recommendations-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.9));
            min-height: calc(100vh - 150px);
            border-radius: 20px;
            padding: 2.5rem;
            margin: 1rem 0;
            box-shadow: 0 10px 40px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem;
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border-radius: 20px;
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

        .page-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0;
            position: relative;
            z-index: 2;
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

        .filter-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .filter-title i {
            color: var(--primary-orange);
            font-size: 1.2rem;
        }

        .sort-buttons {
            display: flex;
            background: var(--soft-gray);
            border-radius: 15px;
            padding: 0.5rem;
            gap: 0.25rem;
        }

        .sort-button {
            background: transparent;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-muted);
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sort-button.active {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            transform: translateY(-1px);
        }

        .sort-button:hover:not(.active) {
            background: rgba(255, 107, 53, 0.1);
            color: var(--primary-orange);
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .book-card {
            background: var(--warm-white);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 107, 53, 0.1);
            transition: all 0.4s ease;
            position: relative;
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.08);
            height: 100%;
        }

        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(255, 107, 53, 0.15);
            border-color: var(--primary-orange);
        }

        .book-image-container {
            position: relative;
            height: 280px;
            overflow: hidden;
        }

        .book-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .book-card:hover .book-image-container img {
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

        .recommendation-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
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
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid var(--primary-orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-orange);
            font-size: 1.1rem;
            transition: all 0.3s ease;
            z-index: 3;
            backdrop-filter: blur(10px);
            cursor: pointer;
        }

        .bookmark-btn:hover {
            background: var(--primary-orange);
            color: white;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.3);
        }

        .bookmark-btn.bookmarked {
            background: var(--primary-orange);
            color: white;
        }

        .book-content {
            padding: 1.5rem;
        }

        .book-title {
            font-size: 1.2rem;
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

        .book-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: var(--soft-gray);
            border-radius: 12px;
        }

        .rating-display {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stars {
            color: #ffd700;
            font-size: 0.9rem;
        }

        .rating-text {
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 600;
        }

        .views-display {
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .btn-detail {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border: none;
            border-radius: 12px;
            padding: 0.75rem;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }

        .btn-detail:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
            color: white;
        }

        .btn-read {
            background: transparent;
            border: 2px solid #28a745;
            border-radius: 12px;
            padding: 0.75rem;
            color: #28a745;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
        }

        .btn-read:hover {
            background: #28a745;
            color: white;
            transform: translateY(-2px);
        }

        .cta-card {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
            margin-top: 3rem;
        }

        .cta-title {
            color: var(--primary-orange);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta-description {
            color: var(--text-muted);
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .cta-button {
            background: transparent;
            border: 2px solid var(--primary-orange);
            border-radius: 25px;
            padding: 1rem 2rem;
            color: var(--primary-orange);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cta-button:hover {
            background: var(--primary-orange);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--warm-white);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--primary-orange);
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
            .recommendations-container {
                padding: 1.5rem;
            }

            .page-header {
                padding: 1.5rem;
            }

            .page-header h2 {
                font-size: 2rem;
            }

            .filter-card {
                padding: 1.5rem;
            }

            .filter-header {
                flex-direction: column;
                align-items: stretch;
            }

            .sort-buttons {
                justify-content: center;
            }

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
            }

            .action-buttons {
                grid-template-columns: 1fr;
            }

            .empty-actions {
                flex-direction: column;
                align-items: center;
            }

            .cta-card {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .books-grid {
                grid-template-columns: 1fr;
            }

            .sort-buttons {
                flex-direction: column;
            }

            .sort-button {
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="recommendations-container">
            <!-- Page Header -->
            <div class="page-header">
                <h2>Rekomendasi Buku Untuk Anda</h2>
                <p>Berdasarkan preferensi dan algoritma K-Means clustering</p>
            </div>

            @if ($recommendedBooks->count() > 0)
                <!-- Filter Card -->
                <div class="filter-card">
                    <div class="filter-header">
                        <h5 class="filter-title">
                            <i class="fas fa-magic"></i>
                            {{ $recommendedBooks->count() }} Buku Direkomendasikan
                        </h5>
                        <div class="sort-buttons">
                            <button class="sort-button active" data-sort="rating">
                                <i class="fas fa-star"></i>
                                <span>Rating</span>
                            </button>
                            <button class="sort-button" data-sort="popular">
                                <i class="fas fa-fire"></i>
                                <span>Populer</span>
                            </button>
                            <button class="sort-button" data-sort="newest">
                                <i class="fas fa-clock"></i>
                                <span>Terbaru</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Books Grid -->
                <div class="books-grid" id="booksContainer">
                    @foreach ($recommendedBooks as $book)
                        <div class="book-card book-item" data-rating="{{ $book->rating }}" data-views="{{ $book->views }}"
                            data-date="{{ $book->created_at->timestamp }}">

                            <div class="book-image-container">
                                @if ($book->cover_image)
                                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}">
                                @else
                                    <div class="book-placeholder">
                                        <i class="fas fa-book fa-3x"></i>
                                    </div>
                                @endif

                                <!-- Badges -->
                                <div class="recommendation-badge">
                                    <i class="fas fa-magic"></i> Recommended
                                </div>
                                <div class="category-badge">
                                    {{ $book->category->name }}
                                </div>

                                @auth
                                    <button class="bookmark-btn {{ $book->isBookmarkedBy(auth()->id()) ? 'bookmarked' : '' }}"
                                        onclick="toggleBookmark({{ $book->id }})"
                                        title="{{ $book->isBookmarkedBy(auth()->id()) ? 'Hapus bookmark' : 'Tambah bookmark' }}">
                                        <i class="fas fa-bookmark" id="bookmark-{{ $book->id }}"></i>
                                    </button>
                                @endauth
                            </div>

                            <div class="book-content">
                                <h5 class="book-title">{{ $book->title }}</h5>
                                <p class="book-author">oleh {{ $book->author }}</p>
                                <p class="book-description">{{ $book->description }}</p>

                                <!-- Rating dan Views -->
                                <div class="book-meta">
                                    <div class="rating-display">
                                        <div class="stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $book->rating ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="rating-text">({{ $book->rating }})</span>
                                    </div>
                                    <div class="views-display">
                                        <i class="fas fa-eye"></i>
                                        <span>{{ number_format($book->views) }}</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="action-buttons">
                                    <a href="{{ route('books.show', $book->slug) }}" class="btn-detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('books.read', $book->slug) }}" class="btn-read">
                                        <i class="fas fa-book-open"></i> Baca
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Call to Action -->
                <div class="cta-card">
                    <h5 class="cta-title">Tidak menemukan yang Anda cari?</h5>
                    <p class="cta-description">
                        Ubah preferensi kategori untuk mendapatkan rekomendasi yang berbeda dan lebih sesuai dengan minat
                        Anda
                    </p>
                    <a href="{{ route('home') }}" class="cta-button">
                        <i class="fas fa-cog"></i>
                        <span>Ubah Preferensi</span>
                    </a>
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4 class="empty-title">Belum Ada Rekomendasi</h4>
                    <p class="empty-description">
                        Silakan pilih preferensi kategori terlebih dahulu untuk mendapatkan rekomendasi buku
                        yang sesuai dengan minat dan kebutuhan Anda
                    </p>
                    <div class="empty-actions">
                        <a href="{{ route('home') }}" class="btn-detail" style="padding: 1rem 2rem;">
                            <i class="fas fa-arrow-left"></i> Pilih Preferensi
                        </a>
                        <a href="{{ route('home') }}#categories" class="cta-button">
                            <i class="fas fa-tags"></i> Lihat Kategori
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
            // Sort functionality
            const sortButtons = document.querySelectorAll('.sort-button');
            const container = document.getElementById('booksContainer');

            sortButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Update active state
                    sortButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const sortBy = this.dataset.sort;
                    const items = Array.from(container.children);

                    // Add loading effect
                    container.style.opacity = '0.5';
                    container.style.pointerEvents = 'none';

                    setTimeout(() => {
                        items.sort((a, b) => {
                            let aVal, bVal;

                            switch (sortBy) {
                                case 'rating':
                                    aVal = parseFloat(a.dataset.rating);
                                    bVal = parseFloat(b.dataset.rating);
                                    return bVal - aVal; // Descending
                                case 'popular':
                                    aVal = parseInt(a.dataset.views);
                                    bVal = parseInt(b.dataset.views);
                                    return bVal - aVal; // Descending
                                case 'newest':
                                    aVal = parseInt(a.dataset.date);
                                    bVal = parseInt(b.dataset.date);
                                    return bVal - aVal; // Descending
                                default:
                                    return 0;
                            }
                        });

                        // Re-append sorted items with animation
                        items.forEach((item, index) => {
                            setTimeout(() => {
                                container.appendChild(item);
                                item.style.opacity = '0';
                                item.style.transform = 'translateY(20px)';

                                setTimeout(() => {
                                    item.style.transition =
                                        'all 0.3s ease';
                                    item.style.opacity = '1';
                                    item.style.transform =
                                        'translateY(0)';
                                }, 50);
                            }, index * 50);
                        });

                        // Restore container
                        setTimeout(() => {
                            container.style.opacity = '1';
                            container.style.pointerEvents = 'auto';
                        }, 500);
                    }, 200);
                });
            });

            // Book card animations
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

                // Observe book cards
                document.querySelectorAll('.book-card').forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition =
                        `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                    observer.observe(card);
                });
            }
        });

        // Bookmark functionality
        function toggleBookmark(bookId) {
            @auth
            const bookmarkBtn = document.querySelector(`#bookmark-${bookId}`).closest('.bookmark-btn');
            const originalClass = bookmarkBtn.className;

            // Add loading state
            bookmarkBtn.style.transform = 'scale(0.8)';
            bookmarkBtn.style.opacity = '0.6';

            $.post('{{ route('bookmark.toggle', ':id') }}'.replace(':id', bookId), {
                    _token: '{{ csrf_token() }}'
                })
                .done(function(response) {
                    const icon = document.getElementById('bookmark-' + bookId);
                    const btn = icon.closest('.bookmark-btn');

                    if (response.status === 'added') {
                        btn.classList.add('bookmarked');
                        btn.title = 'Hapus bookmark';
                    } else {
                        btn.classList.remove('bookmarked');
                        btn.title = 'Tambah bookmark';
                    }

                    // Restore button with success animation
                    btn.style.transform = 'scale(1.1)';
                    btn.style.opacity = '1';

                    setTimeout(() => {
                        btn.style.transform = 'scale(1)';
                    }, 200);

                    showToast(response.message, response.status === 'added' ? 'success' : 'info');
                })
                .fail(function() {
                    // Restore original state on error
                    bookmarkBtn.className = originalClass;
                    bookmarkBtn.style.transform = 'scale(1)';
                    bookmarkBtn.style.opacity = '1';
                    showToast('Gagal mengubah bookmark', 'error');
                });
        @else
            showToast('Silakan login terlebih dahulu', 'warning');
        @endauth
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
    </script>
@endpush
