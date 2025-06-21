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

        .book-detail-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.9));
            min-height: calc(100vh - 150px);
            border-radius: 20px;
            padding: 2.5rem;
            margin: 1rem 0;
            box-shadow: 0 10px 40px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .breadcrumb-elegant {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            padding: 1rem 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.2);
        }

        .breadcrumb-elegant .breadcrumb {
            margin: 0;
        }

        .breadcrumb-elegant .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.2rem;
        }

        .breadcrumb-elegant a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .breadcrumb-elegant a:hover {
            color: rgba(255, 255, 255, 0.8);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .book-cover-card {
            background: var(--warm-white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(255, 107, 53, 0.15);
            border: 1px solid rgba(255, 107, 53, 0.1);
            transition: all 0.4s ease;
            position: relative;
        }

        .book-cover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(255, 107, 53, 0.2);
        }

        .book-cover-wrapper {
            position: relative;
            overflow: hidden;
        }

        .book-cover-wrapper img {
            transition: transform 0.4s ease;
        }

        .book-cover-card:hover .book-cover-wrapper img {
            transform: scale(1.02);
        }

        .floating-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: var(--text-dark);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
            z-index: 3;
        }

        .bookmark-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid var(--primary-orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-orange);
            font-size: 1.2rem;
            transition: all 0.3s ease;
            z-index: 3;
            backdrop-filter: blur(10px);
        }

        .bookmark-btn:hover {
            background: var(--primary-orange);
            color: white;
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
        }

        .bookmark-btn.active {
            background: var(--primary-orange);
            color: white;
        }

        .progress-section {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 140, 66, 0.05));
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 107, 53, 0.2);
        }

        .progress-bar-elegant {
            height: 8px;
            border-radius: 4px;
            background: rgba(255, 107, 53, 0.2);
            overflow: hidden;
        }

        .progress-fill-elegant {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-orange), var(--secondary-orange));
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .action-btn-primary {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border: none;
            border-radius: 15px;
            padding: 1rem 2rem;
            font-weight: 600;
            color: white;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.3);
            position: relative;
            overflow: hidden;
        }

        .action-btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.3s;
        }

        .action-btn-primary:hover::before {
            left: 100%;
        }

        .action-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.4);
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: rgba(255, 107, 53, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 107, 53, 0.1);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-2px);
            background: rgba(255, 107, 53, 0.1);
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.1);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-orange);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .info-card {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
            height: 100%;
        }

        .category-badge {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.2);
        }

        .rating-stars {
            color: #ffd700;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .book-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .book-author {
            font-size: 1.2rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(255, 107, 53, 0.1);
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .description-text {
            color: var(--text-muted);
            line-height: 1.8;
            font-size: 1rem;
            text-align: justify;
        }

        .detail-table {
            background: var(--soft-gray);
            border-radius: 12px;
            padding: 1.5rem;
            border: none;
        }

        .detail-table .table {
            margin: 0;
        }

        .detail-table .table td {
            border: none;
            padding: 0.75rem 0;
        }

        .detail-table .table td:first-child {
            color: var(--text-muted);
            font-weight: 500;
        }

        .detail-table .table td:last-child {
            color: var(--text-dark);
            font-weight: 600;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-read-now {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 12px;
            padding: 1rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-read-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .btn-bookmark {
            background: transparent;
            border: 2px solid var(--primary-orange);
            border-radius: 12px;
            padding: 1rem;
            color: var(--primary-orange);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-bookmark:hover {
            background: var(--primary-orange);
            color: white;
            transform: translateY(-2px);
        }

        .btn-bookmark.active {
            background: var(--primary-orange);
            color: white;
        }

        .related-books-section {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 2px solid rgba(255, 107, 53, 0.1);
        }

        .related-book-card {
            background: var(--warm-white);
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid rgba(255, 107, 53, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.08);
        }

        .related-book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(255, 107, 53, 0.15);
        }

        .related-book-image {
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .related-book-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .related-book-card:hover .related-book-image img {
            transform: scale(1.05);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-available {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .status-unavailable {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .book-detail-container {
                padding: 1.5rem;
            }

            .book-title {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .action-buttons {
                grid-template-columns: 1fr;
            }

            .breadcrumb-elegant {
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .book-title {
                font-size: 1.75rem;
            }

            .book-author {
                font-size: 1rem;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="book-detail-container">
            <!-- Breadcrumb -->
            <nav class="breadcrumb-elegant" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><span style="color: rgba(255,255,255,0.7);">{{ $book->category->name }}</span>
                    </li>
                    <li class="breadcrumb-item active" style="color: white;">{{ Str::limit($book->title, 30) }}</li>
                </ol>
            </nav>

            <div class="row g-4">
                <!-- Book Cover & Actions -->
                <div class="col-lg-4">
                    <div class="book-cover-card">
                        <div class="book-cover-wrapper">
                            @if ($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}" class="w-100" alt="{{ $book->title }}"
                                    style="height: 500px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 500px;">
                                    <i class="fas fa-book fa-5x text-muted"></i>
                                </div>
                            @endif

                            @if ($book->is_featured)
                                <div class="floating-badge">
                                    <i class="fas fa-star me-1"></i>Unggulan
                                </div>
                            @endif

                            @auth
                                <button class="bookmark-btn {{ $book->isBookmarkedBy(auth()->id()) ? 'active' : '' }}"
                                    onclick="toggleBookmark({{ $book->id }})"
                                    title="{{ $book->isBookmarkedBy(auth()->id()) ? 'Hapus dari bookmark' : 'Tambah ke bookmark' }}">
                                    <i class="fas fa-bookmark" id="bookmark-icon"></i>
                                </button>
                            @endauth
                        </div>

                        <div class="p-3">
                            <!-- Reading Progress -->
                            @auth
                                @php
                                    $userProgress = $book
                                        ->readingHistories()
                                        ->where('user_id', auth()->id())
                                        ->first();
                                @endphp
                                @if ($userProgress)
                                    <div class="progress-section">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted fw-medium">Progress Bacaan Anda</small>
                                            <small class="fw-bold" style="color: var(--primary-orange);">
                                                {{ round(($userProgress->last_page / $book->pages) * 100) }}%
                                            </small>
                                        </div>
                                        <div class="progress-bar-elegant mb-2">
                                            <div class="progress-fill-elegant"
                                                style="width: {{ ($userProgress->last_page / $book->pages) * 100 }}%"></div>
                                        </div>
                                        <small class="text-muted">
                                            Halaman {{ $userProgress->last_page }} dari {{ $book->pages }}
                                            • {{ $userProgress->last_read_at->diffForHumans() }}
                                        </small>
                                    </div>
                                @endif
                            @endauth

                            <!-- Primary Action Button -->
                            @auth
                                <a href="{{ route('books.read', $book->slug) }}"
                                    class="action-btn-primary w-100 d-block text-center text-decoration-none mb-3">
                                    <i class="fas fa-book-open me-2"></i>
                                    @if (isset($userProgress))
                                        Lanjut Membaca
                                    @else
                                        Mulai Membaca
                                    @endif
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="action-btn-primary w-100 d-block text-center text-decoration-none mb-3">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login untuk Membaca
                                </a>
                            @endauth

                            <!-- Book Stats -->
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <div class="stat-value">{{ number_format($book->pages) }}</div>
                                    <div class="stat-label">Halaman</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">{{ number_format($book->views) }}</div>
                                    <div class="stat-label">Pembaca</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">{{ $book->rating }}</div>
                                    <div class="stat-label">Rating</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book Information -->
                <div class="col-lg-8">
                    <div class="info-card">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <span class="category-badge">{{ $book->category->name }}</span>
                                <div class="text-muted small">Diterbitkan {{ $book->publication_year }}</div>
                            </div>
                            <div class="text-end">
                                <div class="rating-stars mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $book->rating ? '' : '-o' }}"></i>
                                    @endfor
                                </div>
                                <small class="text-muted fw-medium">{{ $book->rating }}/5.0</small>
                            </div>
                        </div>

                        <!-- Title & Author -->
                        <h1 class="book-title">{{ $book->title }}</h1>
                        <p class="book-author">
                            <i class="fas fa-pen-nib"></i>
                            <span>oleh {{ $book->author }}</span>
                        </p>

                        <!-- Description -->
                        <div class="mb-4">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-align-left"></i>
                                </div>
                                <h5 class="section-title">Deskripsi</h5>
                            </div>
                            <p class="description-text">{{ $book->description }}</p>
                        </div>

                        <!-- Book Details -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <h6 class="section-title">Detail Buku</h6>
                                </div>
                                <div class="detail-table">
                                    <table class="table table-borderless table-sm">
                                        @if ($book->isbn)
                                            <tr>
                                                <td style="width: 40%;">ISBN:</td>
                                                <td>{{ $book->isbn }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>Halaman:</td>
                                            <td>{{ number_format($book->pages) }} halaman</td>
                                        </tr>
                                        <tr>
                                            <td>Kategori:</td>
                                            <td><span class="category-badge py-1 px-2"
                                                    style="font-size: 0.75rem;">{{ $book->category->name }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Tahun Terbit:</td>
                                            <td>{{ $book->publication_year }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <h6 class="section-title">Statistik</h6>
                                </div>
                                <div class="detail-table">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td style="width: 40%;">Total Pembaca:</td>
                                            <td>{{ number_format($book->views) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Rating:</td>
                                            <td>{{ $book->rating }}/5.0</td>
                                        </tr>
                                        <tr>
                                            <td>Ditambahkan:</td>
                                            <td>{{ $book->created_at->format('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status:</td>
                                            <td>
                                                @if ($book->is_active)
                                                    <span class="status-badge status-available">Tersedia</span>
                                                @else
                                                    <span class="status-badge status-unavailable">Tidak Tersedia</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            @auth
                                <a href="{{ route('books.read', $book->slug) }}" class="btn btn-read-now text-decoration-none">
                                    <i class="fas fa-play me-2"></i>Baca Sekarang
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-read-now text-decoration-none">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login untuk Membaca
                                </a>
                            @endauth

                            @auth
                                <button class="btn btn-bookmark {{ $book->isBookmarkedBy(auth()->id()) ? 'active' : '' }}"
                                    onclick="toggleBookmark({{ $book->id }})">
                                    <i class="fas fa-bookmark me-2"></i>
                                    <span id="bookmark-text">
                                        {{ $book->isBookmarkedBy(auth()->id()) ? 'Hapus Bookmark' : 'Tambah Bookmark' }}
                                    </span>
                                </button>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-bookmark text-decoration-none">
                                    <i class="fas fa-user-plus me-2"></i>Daftar Gratis
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Books -->
            @if ($relatedBooks->count() > 0)
                <div class="related-books-section">
                    <div class="section-header mb-4">
                        <div class="section-icon">
                            <i class="fas fa-books"></i>
                        </div>
                        <h3 class="section-title">Buku Serupa</h3>
                    </div>

                    <div class="row g-4">
                        @foreach ($relatedBooks as $relatedBook)
                            <div class="col-lg-3 col-md-6">
                                <div class="related-book-card">
                                    <div class="related-book-image">
                                        @if ($relatedBook->cover_image)
                                            <img src="{{ Storage::url($relatedBook->cover_image) }}"
                                                alt="{{ $relatedBook->title }}">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                                <i class="fas fa-book fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="category-badge py-1 px-2"
                                                style="font-size: 0.7rem;">{{ $relatedBook->category->name }}</span>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <h6 class="fw-bold mb-2" style="color: var(--text-dark);">
                                            {{ Str::limit($relatedBook->title, 50) }}</h6>
                                        <p class="text-muted small mb-2">{{ $relatedBook->author }}</p>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="text-warning small">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fas fa-star{{ $i <= $relatedBook->rating ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                            <small class="text-muted">
                                                <i class="fas fa-eye"></i> {{ $relatedBook->views }}
                                            </small>
                                        </div>

                                        <a href="{{ route('books.show', $relatedBook->slug) }}"
                                            class="btn btn-bookmark w-100 text-decoration-none text-center">
                                            <i class="fas fa-eye me-1"></i>Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleBookmark(bookId) {
            @auth
            $.post('{{ route('bookmark.toggle', ':id') }}'.replace(':id', bookId), {
                    _token: '{{ csrf_token() }}'
                })
                .done(function(response) {
                    const icon = document.getElementById('bookmark-icon');
                    const text = document.getElementById('bookmark-text');
                    const floatingBtn = document.querySelector('.bookmark-btn');
                    const actionBtn = document.querySelector('.btn-bookmark');

                    if (response.status === 'added') {
                        if (floatingBtn) floatingBtn.classList.add('active');
                        if (actionBtn) actionBtn.classList.add('active');
                        if (text) text.textContent = 'Hapus Bookmark';
                    } else {
                        if (floatingBtn) floatingBtn.classList.remove('active');
                        if (actionBtn) actionBtn.classList.remove('active');
                        if (text) text.textContent = 'Tambah Bookmark';
                    }

                    showToast(response.message, response.status === 'added' ? 'success' : 'info');
                })
                .fail(function() {
                    showToast('Gagal mengubah bookmark', 'error');
                });
        @else
            showToast('Silakan login terlebih dahulu', 'warning');
        @endauth
        }

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

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Smooth scroll to sections
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading states untuk buttons
            document.querySelectorAll('.action-btn-primary, .btn-read-now').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (!this.getAttribute('href').startsWith('#')) {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';

                        setTimeout(() => {
                            this.innerHTML = originalText;
                        }, 2000);
                    }
                });
            });

            // Intersection Observer for animations
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

                // Observe related book cards
                document.querySelectorAll('.related-book-card').forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition =
                        `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                    observer.observe(card);
                });

                // Observe main cards
                document.querySelectorAll('.book-cover-card, .info-card').forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition =
                        `opacity 0.8s ease ${index * 0.2}s, transform 0.8s ease ${index * 0.2}s`;
                    observer.observe(card);
                });
            }

            // Enhanced bookmark interaction
            const bookmarkBtns = document.querySelectorAll('.bookmark-btn, .btn-bookmark');
            bookmarkBtns.forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });

                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Book cover hover effect (simple scale only)
            const bookCover = document.querySelector('.book-cover-card');
            if (bookCover) {
                bookCover.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });

                bookCover.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            }

            // Copy ISBN to clipboard
            const isbnCell = document.querySelector('table td:contains("ISBN")');
            if (isbnCell) {
                const isbnValue = isbnCell.nextElementSibling;
                if (isbnValue) {
                    isbnValue.style.cursor = 'pointer';
                    isbnValue.title = 'Klik untuk copy ISBN';
                    isbnValue.addEventListener('click', function() {
                        navigator.clipboard.writeText(this.textContent).then(() => {
                            showToast('ISBN berhasil disalin', 'success');
                        });
                    });
                }
            }

            // Reading progress animation
            const progressBar = document.querySelector('.progress-fill-elegant');
            if (progressBar) {
                const targetWidth = progressBar.style.width;
                progressBar.style.width = '0%';

                setTimeout(() => {
                    progressBar.style.width = targetWidth;
                }, 500);
            }

            // Smooth scrolling for related books
            const relatedBooksSection = document.querySelector('.related-books-section');
            if (relatedBooksSection) {
                const relatedTitle = relatedBooksSection.querySelector('.section-title');
                if (relatedTitle) {
                    relatedTitle.addEventListener('click', function() {
                        relatedBooksSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    });
                }
            }

            // Stats animation
            const statValues = document.querySelectorAll('.stat-value');
            statValues.forEach(stat => {
                const finalValue = stat.textContent;
                const numericValue = parseInt(finalValue.replace(/[^\d]/g, ''));

                if (!isNaN(numericValue) && numericValue > 0) {
                    let currentValue = 0;
                    const increment = Math.ceil(numericValue / 50);
                    const timer = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= numericValue) {
                            currentValue = numericValue;
                            clearInterval(timer);
                        }
                        stat.textContent = currentValue.toLocaleString();
                    }, 30);
                }
            });

            // Enhanced hover effects for related books
            document.querySelectorAll('.related-book-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.borderColor = 'var(--primary-orange)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.borderColor = 'rgba(255, 107, 53, 0.1)';
                });
            });

            // Keyboard accessibility
            document.addEventListener('keydown', function(e) {
                // Press 'B' to bookmark
                if (e.key.toLowerCase() === 'b' && e.ctrlKey) {
                    e.preventDefault();
                    const bookmarkBtn = document.querySelector('.bookmark-btn, .btn-bookmark');
                    if (bookmarkBtn) {
                        bookmarkBtn.click();
                    }
                }

                // Press 'R' to read
                if (e.key.toLowerCase() === 'r' && e.ctrlKey) {
                    e.preventDefault();
                    const readBtn = document.querySelector('.action-btn-primary, .btn-read-now');
                    if (readBtn) {
                        readBtn.click();
                    }
                }
            });

            // Add focus styles for better accessibility
            const focusStyle = document.createElement('style');
            focusStyle.textContent = `
        .bookmark-btn:focus,
        .action-btn-primary:focus,
        .btn-read-now:focus,
        .btn-bookmark:focus {
            outline: 3px solid var(--primary-orange);
            outline-offset: 2px;
        }
        
        .related-book-card:focus-within {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(255, 107, 53, 0.15);
        }
    `;
            document.head.appendChild(focusStyle);

            // Lazy loading for related book images
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                                imageObserver.unobserve(img);
                            }
                        }
                    });
                });

                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }

            // Performance optimization
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    // Recalculate layouts on resize
                    const cards = document.querySelectorAll(
                        '.book-cover-card, .info-card, .related-book-card');
                    cards.forEach(card => {
                        card.style.transition = 'none';
                        setTimeout(() => {
                            card.style.transition = '';
                        }, 100);
                    });
                }, 250);
            });
        });
    </script>
@endpush
