@extends('layouts.app')

@push('styles')
    <style>
        /* Orange & White Elegant Dashboard */
        :root {
            --primary-orange: #ff6b35;
            --secondary-orange: #ff8c42;
            --light-orange: #ffa366;
            --dark-orange: #e55a2b;
            --warm-white: #ffffff;
            --soft-gray: #f8f9fa;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
        }

        .dashboard-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.9));
            min-height: calc(100vh - 150px);
            border-radius: 20px;
            padding: 2.5rem;
            margin: 1rem 0;
            box-shadow: 0 10px 40px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .welcome-card {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border: none;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            margin-bottom: 3rem;
            box-shadow: 0 15px 35px rgba(255, 107, 53, 0.3);
        }

        .welcome-card::before {
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
                transform: translateY(-20px) rotate(5deg);
            }
        }

        .user-avatar {
            width: 90px;
            height: 90px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 2;
        }

        .user-avatar i {
            color: var(--text-dark);
            font-size: 2.2rem;
        }

        /* Welcome Card Button Styles */
        .btn-welcome-primary {
            background: var(--text-dark);
            color: white;
            box-shadow: 0 4px 15px rgba(44, 62, 80, 0.3);
        }

        .btn-welcome-primary:hover {
            background: #34495e;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(44, 62, 80, 0.4);
            color: white;
        }

        .btn-welcome-outline {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid var(--text-dark);
            color: var(--text-dark);
        }

        .btn-welcome-outline:hover {
            background: white;
            color: var(--text-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .stat-card {
            background: var(--warm-white);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            text-align: center;
            border: 1px solid rgba(255, 107, 53, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(255, 107, 53, 0.08);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.05), transparent);
            transition: left 0.6s ease;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(255, 107, 53, 0.15);
            border-color: var(--primary-orange);
        }

        .stat-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2rem;
            color: white;
            position: relative;
            z-index: 2;
        }

        .stat-icon.books {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
        }

        .stat-icon.bookmarks {
            background: linear-gradient(135deg, var(--secondary-orange), var(--light-orange));
            box-shadow: 0 8px 25px rgba(255, 140, 66, 0.3);
        }

        .stat-icon.time {
            background: linear-gradient(135deg, var(--light-orange), #ffb366);
            box-shadow: 0 8px 25px rgba(255, 163, 102, 0.3);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-orange);
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stat-label {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
        }

        .stat-description {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            padding: 2rem;
            background: var(--warm-white);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(255, 107, 53, 0.08);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .section-title i {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .book-card {
            background: var(--warm-white);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 107, 53, 0.1);
            transition: all 0.3s ease;
            position: relative;
            box-shadow: 0 4px 20px rgba(255, 107, 53, 0.08);
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(255, 107, 53, 0.15);
            border-color: var(--primary-orange);
        }

        .book-image {
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .book-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .book-card:hover .book-image img {
            transform: scale(1.05);
        }

        .book-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 3;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .badge-category {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            color: white;
        }

        .badge-bookmark {
            background: linear-gradient(135deg, var(--secondary-orange), var(--light-orange));
            color: white;
        }

        .progress-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            color: white;
        }

        .progress-bar-elegant {
            height: 4px;
            border-radius: 2px;
            background: rgba(255, 255, 255, 0.3);
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-orange), var(--secondary-orange));
            border-radius: 2px;
            transition: width 0.3s ease;
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
        }

        .book-author {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .book-meta {
            margin-bottom: 1.5rem;
        }

        .book-meta small {
            display: block;
            color: var(--text-muted);
            margin-bottom: 0.25rem;
        }

        .book-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-elegant {
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-elegant::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.3s;
        }

        .btn-elegant:hover::before {
            left: 100%;
        }

        .btn-primary-elegant {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }

        .btn-primary-elegant:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
            color: white;
        }

        .btn-success-elegant {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-success-elegant:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .btn-outline-elegant {
            background: transparent;
            border: 2px solid var(--primary-orange);
            color: var(--primary-orange);
        }

        .btn-outline-elegant:hover {
            background: var(--primary-orange);
            color: white;
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--warm-white);
            border-radius: 16px;
            border: 2px dashed rgba(255, 107, 53, 0.2);
            box-shadow: 0 4px 20px rgba(255, 107, 53, 0.05);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--primary-orange);
            margin-bottom: 1.5rem;
            opacity: 0.7;
        }

        .empty-state h5 {
            color: var(--text-dark);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .empty-state p {
            color: var(--text-muted);
            margin-bottom: 2rem;
        }

        .floating-action {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            text-decoration: none;
            box-shadow: 0 8px 30px rgba(255, 107, 53, 0.4);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .floating-action:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.5);
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="dashboard-container">
            <!-- Welcome Header -->
            <div class="welcome-card">
                <div class="card-body text-center py-5">
                    <div class="user-avatar">
                        <i class="fas fa-user fa-2x text-white"></i>
                    </div>
                    <h2 class="fw-bold mb-3" style="color: #2c3e50; text-shadow: 0 2px 4px rgba(255,255,255,0.3);">Selamat
                        datang kembali, {{ auth()->user()->name }}!</h2>
                    <p class="mb-4 fs-5" style="color: #34495e; opacity: 0.9;">Lanjutkan perjalanan membaca Anda dan jelajahi
                        dunia pengetahuan</p>

                    @if ($stats['books_read'] == 0)
                        <a href="{{ route('recommendations') }}" class="btn btn-elegant btn-welcome-primary btn-lg">
                            <i class="fas fa-magic me-2"></i>Mulai Membaca Sekarang
                        </a>
                    @else
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('recommendations') }}" class="btn btn-elegant btn-welcome-outline">
                                <i class="fas fa-magic me-2"></i>Lihat Rekomendasi
                            </a>
                            <a href="{{ route('user.books') }}" class="btn btn-elegant btn-welcome-primary">
                                <i class="fas fa-book me-2"></i>Lanjut Membaca
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon books">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stat-number">{{ $stats['books_read'] }}</div>
                    <div class="stat-label">Buku Dibaca</div>
                    <div class="stat-description">Total buku yang sudah Anda baca</div>
                    <a href="{{ route('user.books') }}" class="btn btn-elegant btn-outline-elegant btn-sm">
                        <i class="fas fa-eye me-1"></i>Lihat Semua
                    </a>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bookmarks">
                        <i class="fas fa-bookmark"></i>
                    </div>
                    <div class="stat-number">{{ $stats['bookmarks'] }}</div>
                    <div class="stat-label">Bookmark</div>
                    <div class="stat-description">Buku yang disimpan untuk dibaca nanti</div>
                    <a href="{{ route('user.bookmarks') }}" class="btn btn-elegant btn-outline-elegant btn-sm">
                        <i class="fas fa-eye me-1"></i>Lihat Bookmark
                    </a>
                </div>

                <div class="stat-card">
                    <div class="stat-icon time">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number">{{ $stats['reading_time'] }}</div>
                    <div class="stat-label">Menit</div>
                    <div class="stat-description">Estimasi waktu membaca</div>
                    <a href="{{ route('user.history') }}" class="btn btn-elegant btn-outline-elegant btn-sm">
                        <i class="fas fa-history me-1"></i>Lihat Riwayat
                    </a>
                </div>
            </div>

            <!-- Recently Read Section -->
            <div class="section-header">
                <h4 class="section-title">
                    <i class="fas fa-history"></i>Terakhir Dibaca
                </h4>
                @if ($recentlyRead->count() > 0)
                    <a href="{{ route('user.books') }}" class="btn btn-elegant btn-outline-elegant btn-sm">
                        <i class="fas fa-arrow-right me-1"></i>Lihat Semua
                    </a>
                @endif
            </div>

            @if ($recentlyRead->count() > 0)
                <div class="books-grid">
                    @foreach ($recentlyRead as $history)
                        <div class="book-card">
                            <div class="book-image">
                                @if ($history->book->cover_image)
                                    <img src="{{ Storage::url($history->book->cover_image) }}"
                                        alt="{{ $history->book->title }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                        <i class="fas fa-book fa-3x text-muted"></i>
                                    </div>
                                @endif

                                <span class="book-badge badge-category">{{ $history->book->category->name }}</span>

                                <div class="progress-overlay">
                                    <div class="progress-bar-elegant">
                                        <div class="progress-fill"
                                            style="width: {{ ($history->last_page / $history->book->pages) * 100 }}%">
                                        </div>
                                    </div>
                                    <small>{{ round(($history->last_page / $history->book->pages) * 100) }}%
                                        selesai</small>
                                </div>
                            </div>

                            <div class="book-content">
                                <h6 class="book-title">{{ Str::limit($history->book->title, 40) }}</h6>
                                <p class="book-author">oleh {{ $history->book->author }}</p>

                                <div class="book-meta">
                                    <small>
                                        <i class="fas fa-clock me-1"></i>
                                        Terakhir dibaca {{ $history->last_read_at->diffForHumans() }}
                                    </small>
                                    <small>
                                        <i class="fas fa-bookmark me-1"></i>
                                        Halaman {{ $history->last_page }} dari {{ $history->book->pages }}
                                    </small>
                                </div>

                                <div class="book-actions">
                                    <a href="{{ route('books.read', $history->book->slug) }}"
                                        class="btn btn-elegant btn-success-elegant flex-fill">
                                        <i class="fas fa-play me-1"></i>Lanjut Baca
                                    </a>
                                    <a href="{{ route('books.show', $history->book->slug) }}"
                                        class="btn btn-elegant btn-outline-elegant">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-book-open"></i>
                    <h5>Belum ada buku yang dibaca</h5>
                    <p>Mulai petualangan membaca Anda sekarang!</p>
                    <a href="{{ route('recommendations') }}" class="btn btn-elegant btn-primary-elegant">
                        <i class="fas fa-magic me-2"></i>Lihat Rekomendasi
                    </a>
                </div>
            @endif

            <!-- Bookmarks Section -->
            <div class="section-header">
                <h4 class="section-title">
                    <i class="fas fa-bookmark"></i>Bookmark Terbaru
                </h4>
                @if ($bookmarks->count() > 0)
                    <a href="{{ route('user.bookmarks') }}" class="btn btn-elegant btn-outline-elegant btn-sm">
                        <i class="fas fa-arrow-right me-1"></i>Lihat Semua
                    </a>
                @endif
            </div>

            @if ($bookmarks->count() > 0)
                <div class="books-grid">
                    @foreach ($bookmarks as $bookmark)
                        <div class="book-card">
                            <div class="book-image">
                                @if ($bookmark->book->cover_image)
                                    <img src="{{ Storage::url($bookmark->book->cover_image) }}"
                                        alt="{{ $bookmark->book->title }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                        <i class="fas fa-book fa-3x text-muted"></i>
                                    </div>
                                @endif

                                <span class="book-badge badge-bookmark">
                                    <i class="fas fa-bookmark"></i> Tersimpan
                                </span>
                                <span class="book-badge badge-category"
                                    style="top: 3.5rem;">{{ $bookmark->book->category->name }}</span>
                            </div>

                            <div class="book-content">
                                <h6 class="book-title">{{ Str::limit($bookmark->book->title, 40) }}</h6>
                                <p class="book-author">oleh {{ $bookmark->book->author }}</p>
                                <p class="text-muted small mb-3">{{ Str::limit($bookmark->book->description, 80) }}</p>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $bookmark->book->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-eye"></i> {{ number_format($bookmark->book->views) }}
                                    </small>
                                </div>

                                <div class="book-actions">
                                    <a href="{{ route('books.read', $bookmark->book->slug) }}"
                                        class="btn btn-elegant btn-success-elegant flex-fill">
                                        <i class="fas fa-book-open me-1"></i>Baca
                                    </a>
                                    <a href="{{ route('books.show', $bookmark->book->slug) }}"
                                        class="btn btn-elegant btn-outline-elegant">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <button class="btn btn-elegant btn-outline-elegant text-danger"
                                        onclick="removeBookmark({{ $bookmark->book->id }})" title="Hapus bookmark">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-bookmark"></i>
                    <h5>Belum ada bookmark</h5>
                    <p>Simpan buku favorit Anda dengan menekan ikon bookmark</p>
                    <a href="{{ route('home') }}" class="btn btn-elegant btn-primary-elegant">
                        <i class="fas fa-search me-2"></i>Cari Buku
                    </a>
                </div>
            @endif
        </div>

        <!-- Floating Action Button -->
        <a href="{{ route('recommendations') }}" class="floating-action" title="Lihat Rekomendasi">
            <i class="fas fa-plus"></i>
        </a>
    </div>
@endsection

@push('scripts')
    <script>
        function removeBookmark(bookId) {
            if (confirm('Apakah Anda yakin ingin menghapus bookmark ini?')) {
                $.post('{{ route('bookmark.toggle', ':id') }}'.replace(':id', bookId), {
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        showToast(response.message, 'success');
                        setTimeout(() => location.reload(), 1000);
                    })
                    .fail(function() {
                        showToast('Gagal menghapus bookmark', 'error');
                    });
            }
        }

        function showToast(message, type = 'info') {
            const toastClass = {
                success: 'bg-success',
                error: 'bg-danger',
                warning: 'bg-warning',
                info: 'bg-info'
            };

            const toast = `
        <div class="toast show position-fixed top-0 end-0 m-3 ${toastClass[type]} text-white" role="alert" style="z-index: 9999; border-radius: 15px; backdrop-filter: blur(10px);">
            <div class="toast-body">
                <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'}-circle me-2"></i>
                ${message}
            </div>
        </div>
    `;

            document.body.insertAdjacentHTML('beforeend', toast);

            setTimeout(() => {
                const toastElement = document.querySelector('.toast');
                if (toastElement) {
                    toastElement.remove();
                }
            }, 3000);
        }

        // Smooth scroll untuk floating action
        document.querySelector('.floating-action').addEventListener('click', function(e) {
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }
        });

        // Add loading states untuk tombol
        document.querySelectorAll('.btn-elegant').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.classList.contains('no-loading')) {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Loading...';
                    this.disabled = true;

                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }, 1000);
                }
            });
        });
    </script>
@endpush
