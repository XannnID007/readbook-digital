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

        .my-books-container {
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
            color: var(--primary-orange);
            font-size: 1.2rem;
        }

        .filter-controls {
            display: flex;
            gap: 1rem;
        }

        .elegant-select {
            background: var(--soft-gray);
            border: 2px solid rgba(255, 107, 53, 0.2);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.3s ease;
            min-width: 160px;
        }

        .elegant-select:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
            outline: none;
            background: white;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
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

        .progress-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 3;
            color: white;
        }

        .progress-completed {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .progress-high {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
        }

        .progress-low {
            background: linear-gradient(135deg, #17a2b8, #007bff);
        }

        .progress-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: white;
        }

        .progress-bar-elegant {
            height: 8px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.3);
            overflow: hidden;
            margin-bottom: 0.75rem;
        }

        .progress-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .progress-fill.completed {
            background: linear-gradient(90deg, #28a745, #20c997);
        }

        .progress-fill.high {
            background: linear-gradient(90deg, #ffc107, #fd7e14);
        }

        .progress-fill.low {
            background: linear-gradient(90deg, #17a2b8, #007bff);
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            font-weight: 500;
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
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .reading-stats {
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
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-value.pages {
            color: var(--primary-orange);
        }

        .stat-value.progress {
            color: #28a745;
        }

        .stat-value.rating {
            color: #ffc107;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .last-read-info {
            background: rgba(255, 107, 53, 0.05);
            border: 1px solid rgba(255, 107, 53, 0.1);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .last-read-info small {
            display: block;
            color: var(--text-muted);
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .action-buttons {
            display: grid;
            gap: 0.75rem;
        }

        .btn-continue {
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

        .btn-continue:hover {
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

        .btn-bookmark {
            background: transparent;
            border: 2px solid #ffc107;
            border-radius: 12px;
            padding: 0.75rem;
            color: #ffc107;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 50px;
        }

        .btn-bookmark:hover {
            background: #ffc107;
            color: white;
            transform: translateY(-2px);
        }

        .btn-bookmark.bookmarked {
            background: #ffc107;
            color: white;
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
            .my-books-container {
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

            .books-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }

            .reading-stats {
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
            .books-grid {
                grid-template-columns: 1fr;
            }

            .btn-header {
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="my-books-container">
            <!-- Header -->
            <div class="page-header d-flex justify-content-between align-items-center">
                <div class="header-content">
                    <h2 class="header-title">Buku Saya</h2>
                    <p class="header-subtitle">Riwayat bacaan dan progress Anda</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('user.dashboard') }}" class="btn-header">
                        <i class="fas fa-arrow-left me-1"></i>Dashboard
                    </a>
                    <a href="{{ route('recommendations') }}" class="btn-header btn-header-primary">
                        <i class="fas fa-plus me-1"></i>Cari Buku Baru
                    </a>
                </div>
            </div>

            @if ($readingHistory->count() > 0)
                <!-- Filter & Sort -->
                <div class="filter-card">
                    <div class="filter-header">
                        <div class="filter-info">
                            <i class="fas fa-book-open"></i>
                            <span>{{ $readingHistory->total() }} buku dalam riwayat</span>
                        </div>
                        <div class="filter-controls">
                            <select class="elegant-select" onchange="filterBooks(this.value)">
                                <option value="all">Semua Status</option>
                                <option value="reading">Sedang Dibaca</option>
                                <option value="completed">Selesai</option>
                                <option value="started">Baru Dimulai</option>
                            </select>
                            <select class="elegant-select" onchange="sortBooks(this.value)">
                                <option value="recent">Terbaru Dibaca</option>
                                <option value="progress">Progress Tertinggi</option>
                                <option value="title">Judul A-Z</option>
                                <option value="author">Penulis A-Z</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Books Grid -->
                <div class="books-grid" id="booksContainer">
                    @foreach ($readingHistory as $history)
                        @php
                            $progressPercent = round(($history->last_page / $history->book->pages) * 100);
                            $progressClass =
                                $progressPercent == 100 ? 'completed' : ($progressPercent > 50 ? 'high' : 'low');
                        @endphp
                        <div class="book-card book-item" data-progress="{{ $progressPercent }}"
                            data-title="{{ $history->book->title }}" data-author="{{ $history->book->author }}"
                            data-date="{{ $history->last_read_at->timestamp }}">

                            <div class="book-image-container">
                                @if ($history->book->cover_image)
                                    <img src="{{ Storage::url($history->book->cover_image) }}"
                                        alt="{{ $history->book->title }}">
                                @else
                                    <div class="book-placeholder">
                                        <i class="fas fa-book fa-4x"></i>
                                    </div>
                                @endif

                                <!-- Badges -->
                                <div class="category-badge">{{ $history->book->category->name }}</div>
                                <div class="progress-badge progress-{{ $progressClass }}">
                                    @if ($progressPercent == 100)
                                        <i class="fas fa-check me-1"></i>Selesai
                                    @elseif($progressPercent > 50)
                                        <i class="fas fa-clock me-1"></i>{{ $progressPercent }}%
                                    @else
                                        <i class="fas fa-play me-1"></i>{{ $progressPercent }}%
                                    @endif
                                </div>

                                <!-- Progress Overlay -->
                                <div class="progress-overlay">
                                    <div class="progress-bar-elegant">
                                        <div class="progress-fill {{ $progressClass }}"
                                            style="width: {{ $progressPercent }}%"></div>
                                    </div>
                                    <div class="progress-info">
                                        <span>{{ $progressPercent }}% selesai</span>
                                        <span>{{ $history->book->pages - $history->last_page }} hal tersisa</span>
                                    </div>
                                </div>
                            </div>

                            <div class="book-content">
                                <h6 class="book-title">{{ $history->book->title }}</h6>
                                <p class="book-author">oleh {{ $history->book->author }}</p>

                                <!-- Reading Stats -->
                                <div class="reading-stats">
                                    <div class="stat-item">
                                        <div class="stat-value pages">{{ $history->last_page }}</div>
                                        <div class="stat-label">Halaman</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value progress">{{ $progressPercent }}%</div>
                                        <div class="stat-label">Progress</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value rating">{{ $history->book->rating }}</div>
                                        <div class="stat-label">Rating</div>
                                    </div>
                                </div>

                                <!-- Last Read Info -->
                                <div class="last-read-info">
                                    <small>
                                        <i class="fas fa-clock me-1"></i>
                                        Terakhir dibaca: {{ $history->last_read_at->format('d M Y, H:i') }}
                                    </small>
                                    <small>
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $history->last_read_at->diffForHumans() }}
                                    </small>
                                </div>

                                <!-- Action Buttons -->
                                <div class="action-buttons">
                                    <a href="{{ route('books.read', $history->book->slug) }}" class="btn-continue">
                                        <i class="fas fa-{{ $progressPercent == 100 ? 'redo' : 'play' }} me-1"></i>
                                        {{ $progressPercent == 100 ? 'Baca Ulang' : 'Lanjut Baca' }}
                                    </a>
                                    <div class="secondary-actions">
                                        <a href="{{ route('books.show', $history->book->slug) }}" class="btn-secondary">
                                            <i class="fas fa-info-circle me-1"></i>Detail
                                        </a>
                                        <button
                                            class="btn-bookmark {{ $history->book->isBookmarkedBy(auth()->id()) ? 'bookmarked' : '' }}"
                                            onclick="toggleBookmark({{ $history->book->id }})"
                                            title="{{ $history->book->isBookmarkedBy(auth()->id()) ? 'Hapus bookmark' : 'Tambah bookmark' }}">
                                            <i class="fas fa-bookmark"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $readingHistory->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h4 class="empty-title">Belum Ada Buku yang Dibaca</h4>
                    <p class="empty-description">
                        Mulai petualangan membaca Anda dan temukan dunia pengetahuan yang menakjubkan.
                        Ribuan buku berkualitas menanti untuk dijelajahi.
                    </p>
                    <div class="empty-actions">
                        <a href="{{ route('recommendations') }}" class="btn-continue" style="padding: 1rem 2rem;">
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

        // Filter and sort functionality
        function filterBooks(status) {
            const items = document.querySelectorAll('.book-item');
            const container = document.getElementById('booksContainer');

            // Add loading effect
            container.style.opacity = '0.5';

            setTimeout(() => {
                items.forEach(item => {
                    const progress = parseFloat(item.dataset.progress);
                    let show = true;

                    switch (status) {
                        case 'completed':
                            show = progress >= 100;
                            break;
                        case 'reading':
                            show = progress > 10 && progress < 100;
                            break;
                        case 'started':
                            show = progress <= 10;
                            break;
                        case 'all':
                        default:
                            show = true;
                            break;
                    }

                    if (show) {
                        item.style.display = 'block';
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(20px)';

                        setTimeout(() => {
                            item.style.transition = 'all 0.3s ease';
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        item.style.display = 'none';
                    }
                });

                container.style.opacity = '1';
            }, 200);
        }

        function sortBooks(sortBy) {
            const container = document.getElementById('booksContainer');
            const items = Array.from(container.children);

            // Add loading effect
            container.style.opacity = '0.5';

            setTimeout(() => {
                items.sort((a, b) => {
                    let aVal, bVal;

                    switch (sortBy) {
                        case 'progress':
                            aVal = parseFloat(a.dataset.progress);
                            bVal = parseFloat(b.dataset.progress);
                            return bVal - aVal; // Descending
                        case 'title':
                            aVal = a.dataset.title.toLowerCase();
                            bVal = b.dataset.title.toLowerCase();
                            return aVal.localeCompare(bVal); // Ascending
                        case 'author':
                            aVal = a.dataset.author.toLowerCase();
                            bVal = b.dataset.author.toLowerCase();
                            return aVal.localeCompare(bVal); // Ascending
                        case 'recent':
                        default:
                            aVal = parseInt(a.dataset.date);
                            bVal = parseInt(b.dataset.date);
                            return bVal - aVal; // Descending
                    }
                });

                // Re-append sorted items with animation
                items.forEach((item, index) => {
                    setTimeout(() => {
                        container.appendChild(item);
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

        // Enhanced bookmark functionality
        function toggleBookmark(bookId) {
            const bookmarkBtn = document.querySelector(`[onclick="toggleBookmark(${bookId})"]`);
            const originalClass = bookmarkBtn.className;

            // Add loading state
            bookmarkBtn.style.transform = 'scale(0.8)';
            bookmarkBtn.style.opacity = '0.6';

            $.post('{{ route('bookmark.toggle', ':id') }}'.replace(':id', bookId), {
                    _token: '{{ csrf_token() }}'
                })
                .done(function(response) {
                    const icon = bookmarkBtn.querySelector('i');

                    if (response.status === 'added') {
                        bookmarkBtn.classList.add('bookmarked');
                        bookmarkBtn.title = 'Hapus bookmark';
                    } else {
                        bookmarkBtn.classList.remove('bookmarked');
                        bookmarkBtn.title = 'Tambah bookmark';
                    }

                    // Restore button with success animation
                    bookmarkBtn.style.transform = 'scale(1.1)';
                    bookmarkBtn.style.opacity = '1';

                    setTimeout(() => {
                        bookmarkBtn.style.transform = 'scale(1)';
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

        // Enhanced button interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add ripple effect to buttons
            document.querySelectorAll('.btn-continue, .btn-secondary, .btn-bookmark').forEach(btn => {
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
        
        .book-card {
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

            // Progress bar animation on load
            document.querySelectorAll('.progress-fill').forEach(bar => {
                const targetWidth = bar.style.width;
                bar.style.width = '0%';

                setTimeout(() => {
                    bar.style.transition = 'width 1s ease';
                    bar.style.width = targetWidth;
                }, 500);
            });

            // Enhanced hover effects
            document.querySelectorAll('.book-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.borderColor = 'var(--primary-orange)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.borderColor = 'rgba(255, 107, 53, 0.1)';
                });
            });

            // Smooth scrolling for pagination
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Add loading overlay during pagination
                    const container = document.getElementById('booksContainer');
                    if (container) {
                        container.style.opacity = '0.5';
                        container.style.pointerEvents = 'none';
                    }
                });
            });

            // Add loading states for action buttons
            document.querySelectorAll('.btn-continue, .btn-secondary').forEach(btn => {
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
                // Press 'F' to focus on filter
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

            // Auto-refresh reading statistics (optional feature)
            setInterval(function() {
                // Check if any book cards are visible and update their "last read" time
                const timeElements = document.querySelectorAll('.last-read-info small:last-child');
                timeElements.forEach(element => {
                    const text = element.textContent;
                    if (text.includes('menit yang lalu') || text.includes('detik yang lalu')) {
                        // Could implement real-time updates here
                    }
                });
            }, 60000); // Update every minute

            // Performance optimization
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    // Recalculate layouts on resize
                    const cards = document.querySelectorAll('.book-card');
                    cards.forEach(card => {
                        card.style.transition = 'none';
                        setTimeout(() => {
                            card.style.transition = '';
                        }, 100);
                    });
                }, 250);
            });

            // Enhanced accessibility
            document.querySelectorAll('.book-card').forEach((card, index) => {
                card.setAttribute('tabindex', '0');
                card.setAttribute('role', 'article');
                card.setAttribute('aria-label', `Buku ${card.querySelector('.book-title').textContent}`);

                // Keyboard navigation
                card.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const continueBtn = this.querySelector('.btn-continue');
                        if (continueBtn) {
                            continueBtn.click();
                        }
                    }
                });
            });

            // Add focus styles for accessibility
            const focusStyle = document.createElement('style');
            focusStyle.textContent = `
        .book-card:focus {
            outline: 3px solid var(--primary-orange);
            outline-offset: 2px;
        }
        
        .elegant-select:focus {
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
        }
        
        .btn-continue:focus,
        .btn-secondary:focus,
        .btn-bookmark:focus {
            outline: 2px solid var(--primary-orange);
            outline-offset: 2px;
        }
    `;
            document.head.appendChild(focusStyle);
        });
    </script>
@endpush
