@extends('layouts.app')

@section('content')
    <!-- Hero Section with Auto Image Slider -->
    <div class="hero-slider-section">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="hero-slide" style="background: linear-gradient(135deg, #050703 0%, #ec6d1e 100%);">
                        <div class="hero-overlay"></div>
                        <div class="container">
                            <div class="row align-items-center min-vh-75">
                                <div class="col-lg-6">
                                    <div class="hero-content">
                                        <h1 class="hero-title">
                                            Selamat Datang di <span class="text-warning">Digital Library</span>
                                        </h1>
                                        <p class="hero-subtitle">
                                            Jelajahi buku digital gratis sesuai minat Anda.
                                            Mulai perjalanan membaca yang tak terbatas hari ini!
                                        </p>
                                        @guest
                                            <div class="hero-buttons">
                                                <a href="{{ route('register') }}" class="btn btn-warning btn-lg me-3">
                                                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                                                </a>
                                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                                </a>
                                            </div>
                                        @else
                                            <a href="{{ route('user.dashboard') }}" class="btn btn-warning btn-lg">
                                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard Saya
                                            </a>
                                        @endguest
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="hero-image">
                                        <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                            alt="Digital Library" class="img-fluid rounded-3 shadow-lg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="hero-slide" style="background: linear-gradient(135deg, #a9a9c9 0%, #1127a5 100%);">
                        <div class="hero-overlay"></div>
                        <div class="container">
                            <div class="row align-items-center min-vh-75">
                                <div class="col-lg-6">
                                    <div class="hero-content">
                                        <h1 class="hero-title">
                                            Baca <span class="text-warning">Kapanpun</span> & <span
                                                class="text-warning">Dimanapun</span>
                                        </h1>
                                        <p class="hero-subtitle">
                                            Akses koleksi buku digital kami dari berbagai perangkat.
                                            Pengalaman membaca yang nyaman dan menyenangkan.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="hero-image">
                                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                            alt="Community" class="img-fluid rounded-3 shadow-lg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="hero-slide" style="background: linear-gradient(135deg, #3d2525 0%, #df1616 100%);">
                        <div class="hero-overlay"></div>
                        <div class="container">
                            <div class="row align-items-center min-vh-75">
                                <div class="col-lg-6">
                                    <div class="hero-content">
                                        <h1 class="hero-title">
                                            Bergabung dengan <span class="text-warning">Komunitas Pembaca</span>
                                        </h1>
                                        <p class="hero-subtitle">
                                            Temukan teman sepemikiran, berbagi ulasan buku,
                                            dan dapatkan rekomendasi personal dari komunitas kami.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="hero-image">
                                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                            alt="Community" class="img-fluid rounded-3 shadow-lg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pilih Preferensi Kategori - Grid Static -->
    <section class="category-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Pilih Kategori Favorit Anda</h2>
                    <p class="section-subtitle">Dapatkan rekomendasi buku yang sesuai dengan minat Anda</p>
                </div>
            </div>

            <form action="{{ route('preferences.set') }}" method="POST" id="preferencesForm">
                @csrf

                <!-- Category Grid -->
                <div class="categories-grid">
                    <div class="row g-4">
                        @foreach ($categories as $category)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <div class="category-card" onclick="toggleCategory({{ $category->id }})">
                                    <div class="category-icon">
                                        <i class="fas fa-{{ $category->icon ?? 'book' }}"></i>
                                    </div>
                                    <h5 class="category-title">{{ $category->name }}</h5>
                                    <p class="category-description">{{ $category->description }}</p>
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        class="d-none category-checkbox">
                                    <div class="category-check">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary btn-lg px-5" id="submitPreferences" disabled>
                        <i class="fas fa-arrow-right me-2"></i>Lihat Rekomendasi
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Buku Unggulan -->
    @if ($featuredBooks->count() > 0)
        <section class="featured-books-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-5">
                        <h2 class="section-title">Buku Unggulan</h2>
                        <p class="section-subtitle">Koleksi terbaik pilihan editor</p>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach ($featuredBooks as $book)
                        <div class="col-lg-4 col-md-6">
                            <div class="book-card featured">
                                <div class="book-image">
                                    @if ($book->cover_image)
                                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}">
                                    @else
                                        <div class="book-placeholder">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                    <div class="book-badge">
                                        <i class="fas fa-star me-1"></i>Unggulan
                                    </div>
                                </div>
                                <div class="book-content">
                                    <div class="book-meta">
                                        <span class="book-category">{{ $book->category->name }}</span>
                                        <span class="book-views">
                                            <i class="fas fa-eye me-1"></i>{{ $book->views }}
                                        </span>
                                    </div>
                                    <h5 class="book-title">{{ $book->title }}</h5>
                                    <p class="book-author">oleh {{ $book->author }}</p>
                                    <p class="book-description">{{ Str::limit($book->description, 100) }}</p>
                                    <div class="book-footer">
                                        <div class="book-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $book->rating ? '' : '-o' }}"></i>
                                            @endfor
                                            <span class="rating-text">({{ $book->rating }})</span>
                                        </div>
                                        <a href="{{ route('books.show', $book->slug) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Buku Populer - Carousel -->
    @if ($popularBooks->count() > 0)
        <section class="popular-books-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-5">
                        <h2 class="section-title">Buku Populer</h2>
                        <p class="section-subtitle">Paling banyak dibaca minggu ini</p>
                    </div>
                </div>

                <!-- Popular Books Carousel -->
                <div id="popularBooksCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-inner">
                        @php
                            $chunkedBooks = $popularBooks->chunk(4); // 4 books per slide
                        @endphp

                        @foreach ($chunkedBooks as $index => $bookChunk)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="row g-3">
                                    @foreach ($bookChunk as $book)
                                        <div class="col-xl-3 col-lg-6 col-md-6">
                                            <div class="book-card compact">
                                                <div class="book-image">
                                                    @if ($book->cover_image)
                                                        <img src="{{ Storage::url($book->cover_image) }}"
                                                            alt="{{ $book->title }}">
                                                    @else
                                                        <div class="book-placeholder">
                                                            <i class="fas fa-book"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="book-content">
                                                    <span class="book-category">{{ $book->category->name }}</span>
                                                    <h6 class="book-title">{{ Str::limit($book->title, 50) }}</h6>
                                                    <p class="book-author">{{ $book->author }}</p>
                                                    <div class="book-footer">
                                                        <span class="book-views">
                                                            <i class="fas fa-eye me-1"></i>{{ $book->views }}
                                                        </span>
                                                        <a href="{{ route('books.show', $book->slug) }}"
                                                            class="btn btn-outline-primary btn-sm">
                                                            Lihat
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('styles')
    <style>
        /* Orange Theme Variables */
        :root {
            --primary-orange: #ff6b35;
            --secondary-orange: #ff8c42;
            --light-orange: #ffa366;
            --warning-orange: #ffb366;
        }

        main {
            margin-top: 0 !important;
        }

        /* Hero Section Styles */
        .hero-slider-section {
            position: relative;
            overflow: hidden;
        }

        .hero-slide {
            position: relative;
            padding: 120px 0 80px 0;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .hero-slide .container {
            position: relative;
            z-index: 2;
        }

        .min-vh-75 {
            min-height: 75vh;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .hero-buttons .btn {
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .hero-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .hero-image img {
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .hero-stats .stat-item h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .hero-stats .stat-item p {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 0;
        }

        .hero-features .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            color: white;
            font-size: 1.1rem;
        }

        .carousel-indicators {
            bottom: 20px;
        }

        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 6px;
            background-color: rgba(255, 255, 255, 0.5);
            border: 2px solid white;
            transition: all 0.3s ease;
        }

        .carousel-indicators button.active {
            background-color: var(--warning-orange);
            transform: scale(1.2);
        }

        /* Category Section */
        .category-section {
            background: #f8f9fa;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        .categories-grid {
            max-width: 1200px;
            margin: 0 auto;
        }

        .category-card {
            background: white;
            border-radius: 15px;
            padding: 2rem 1.5rem;
            text-align: center;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            height: 100%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-orange);
        }

        .category-card.selected {
            border-color: var(--primary-orange);
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(255, 107, 53, 0.3);
        }

        .category-icon {
            font-size: 3rem;
            color: var(--primary-orange);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .category-card.selected .category-icon {
            color: white;
            transform: scale(1.1);
        }

        .category-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #2c3e50;
            transition: color 0.3s ease;
        }

        .category-card.selected .category-title {
            color: white;
        }

        .category-description {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0;
            line-height: 1.5;
            transition: color 0.3s ease;
        }

        .category-card.selected .category-description {
            color: rgba(255, 255, 255, 0.9);
        }

        .category-check {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #28a745;
            display: none;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8rem;
            animation: checkPulse 0.3s ease;
        }

        @keyframes checkPulse {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .category-card.selected .category-check {
            display: flex;
        }

        /* Submit Button Styling */
        #submitPreferences {
            background: var(--primary-orange);
            border: none;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        #submitPreferences:hover:not(:disabled) {
            background: var(--secondary-orange);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
        }

        #submitPreferences:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }

        /* Books Section */
        .featured-books-section {
            background: white;
        }

        .popular-books-section {
            background: #f8f9fa;
        }

        .book-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .book-image {
            position: relative;
            overflow: hidden;
        }

        .book-card.featured .book-image {
            height: 250px;
        }

        .book-card.compact .book-image {
            height: 200px;
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

        .book-placeholder {
            height: 100%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #adb5bd;
        }

        .book-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--primary-orange);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .book-content {
            padding: 1.5rem;
        }

        .book-card.compact .book-content {
            padding: 1rem;
        }

        .book-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .book-category {
            background: #fff3e0;
            color: var(--primary-orange);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .book-views {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .book-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .book-card.compact .book-title {
            font-size: 1rem;
        }

        .book-author {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .book-description {
            color: #495057;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .book-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .book-rating {
            color: #ffc107;
        }

        .rating-text {
            color: #6c757d;
            font-size: 0.9rem;
            margin-left: 0.5rem;
        }

        .btn-primary {
            background: var(--primary-orange);
            border-color: var(--primary-orange);
        }

        .btn-primary:hover {
            background: var(--secondary-orange);
            border-color: var(--secondary-orange);
        }

        .btn-outline-primary {
            color: var(--primary-orange);
            border-color: var(--primary-orange);
        }

        .btn-outline-primary:hover {
            background: var(--primary-orange);
            border-color: var(--primary-orange);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .hero-buttons .btn {
                display: block;
                width: 100%;
                margin-bottom: 1rem;
            }

            .hero-buttons .btn:last-child {
                margin-bottom: 0;
            }

            .hero-stats .stat-item h3 {
                font-size: 2rem;
            }

            .category-card {
                padding: 1.5rem 1rem;
            }

            .category-icon {
                font-size: 2.5rem;
            }

            .categories-grid .col-xl-3,
            .categories-grid .col-lg-4 {
                flex: 0 0 auto;
                width: 50%;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }

            .category-title {
                font-size: 1.1rem;
            }

            .book-card .book-content {
                padding: 1rem;
            }

            .categories-grid .col-xl-3,
            .categories-grid .col-lg-4,
            .categories-grid .col-md-6 {
                flex: 0 0 auto;
                width: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function toggleCategory(categoryId) {
            const card = event.currentTarget;
            const checkbox = card.querySelector('.category-checkbox');

            card.classList.toggle('selected');
            checkbox.checked = !checkbox.checked;

            updateSubmitButton();
        }

        function updateSubmitButton() {
            const checkedBoxes = document.querySelectorAll('.category-checkbox:checked');
            const submitBtn = document.getElementById('submitPreferences');

            if (checkedBoxes.length > 0) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-arrow-right me-2"></i>Lihat Rekomendasi (' + checkedBoxes.length +
                    ')';
                submitBtn.classList.remove('btn-secondary');
                submitBtn.classList.add('btn-primary');
            } else {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-arrow-right me-2"></i>Lihat Rekomendasi';
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-secondary');
            }
        }

        // Initialize on document ready
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-initialize Hero Carousel (no controls)
            const heroCarousel = document.getElementById('heroCarousel');
            if (heroCarousel) {
                new bootstrap.Carousel(heroCarousel, {
                    interval: 4000,
                    wrap: true,
                    pause: false, // Never pause
                    ride: 'carousel'
                });
            }

            // Initialize popular books carousel with auto-play
            const popularBooksCarousel = document.getElementById('popularBooksCarousel');
            if (popularBooksCarousel) {
                new bootstrap.Carousel(popularBooksCarousel, {
                    interval: 4000,
                    wrap: true,
                    pause: 'hover'
                });
            }

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Enhanced category selection with animation
            window.toggleCategory = function(categoryId) {
                const card = event.currentTarget;
                const checkbox = card.querySelector('.category-checkbox');

                // Add ripple effect
                createRippleEffect(card, event);

                card.classList.toggle('selected');
                checkbox.checked = !checkbox.checked;

                updateSubmitButton();
            };

            // Create ripple effect on category click
            function createRippleEffect(element, event) {
                const ripple = document.createElement('div');
                const rect = element.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = event.clientX - rect.left - size / 2;
                const y = event.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    background: rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    left: ${x}px;
                    top: ${y}px;
                    pointer-events: none;
                `;

                element.style.position = 'relative';
                element.style.overflow = 'hidden';
                element.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            }

            // Add ripple animation to CSS
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);

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

                // Observe category cards
                document.querySelectorAll('.category-card').forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition =
                        `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                    observer.observe(card);
                });

                // Observe book cards
                document.querySelectorAll('.book-card').forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition =
                        `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                    observer.observe(card);
                });
            }

            // Form validation and submission
            document.getElementById('preferencesForm').addEventListener('submit', function(e) {
                const checkedBoxes = document.querySelectorAll('.category-checkbox:checked');

                if (checkedBoxes.length === 0) {
                    e.preventDefault();
                    showToast('Pilih minimal satu kategori untuk mendapatkan rekomendasi', 'warning');
                    return;
                }

                // Add loading state to submit button
                const submitBtn = document.getElementById('submitPreferences');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memuat Rekomendasi...';
                submitBtn.disabled = true;

                // Show success message
                showToast(`Berhasil memilih ${checkedBoxes.length} kategori`, 'success');
            });

            // Toast notification function
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

            // Lazy loading for images
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

            // Keyboard navigation for accessibility
            document.addEventListener('keydown', function(e) {
                // Category selection with Enter/Space
                if ((e.key === 'Enter' || e.key === ' ') && e.target.closest('.category-card')) {
                    e.preventDefault();
                    const categoryCard = e.target.closest('.category-card');
                    categoryCard.click();
                }

                // Carousel keyboard navigation
                const activeCarousel = document.querySelector('.carousel:focus-within');
                if (activeCarousel) {
                    const carouselInstance = bootstrap.Carousel.getInstance(activeCarousel);
                    if (e.key === 'ArrowLeft') {
                        e.preventDefault();
                        carouselInstance.prev();
                    } else if (e.key === 'ArrowRight') {
                        e.preventDefault();
                        carouselInstance.next();
                    }
                }
            });

            // Add focus styles for accessibility
            const focusStyle = document.createElement('style');
            focusStyle.textContent = `
                .category-card:focus {
                    outline: 3px solid var(--primary-orange);
                    outline-offset: 2px;
                }
                
                .book-card:focus {
                    outline: 2px solid var(--primary-orange);
                    outline-offset: 2px;
                }
            `;
            document.head.appendChild(focusStyle);

            // Make category cards focusable
            document.querySelectorAll('.category-card').forEach(card => {
                card.setAttribute('tabindex', '0');
                card.setAttribute('role', 'checkbox');
                card.setAttribute('aria-checked', 'false');
            });

            // Update aria-checked when category is selected
            const originalToggleCategory = window.toggleCategory;
            window.toggleCategory = function(categoryId) {
                originalToggleCategory.call(this, categoryId);

                const card = event.currentTarget;
                const isSelected = card.classList.contains('selected');
                card.setAttribute('aria-checked', isSelected);
            };

            // Performance optimization: Debounce scroll events
            let scrollTimer = null;
            window.addEventListener('scroll', function() {
                if (scrollTimer !== null) {
                    clearTimeout(scrollTimer);
                }
                scrollTimer = setTimeout(function() {
                    // Scroll-based animations or effects can go here
                }, 150);
            });

            // Responsive carousel adjustments
            function adjustCarouselForScreenSize() {
                const screenWidth = window.innerWidth;
                const popularCarousel = document.getElementById('popularBooksCarousel');

                if (popularCarousel) {
                    // Adjust carousel behavior based on screen size
                    const carouselInstance = bootstrap.Carousel.getInstance(popularCarousel);
                    if (carouselInstance) {
                        if (screenWidth < 768) {
                            // Slower interval on mobile
                            carouselInstance.dispose();
                            new bootstrap.Carousel(popularCarousel, {
                                interval: 5000,
                                wrap: true,
                                pause: 'hover'
                            });
                        }
                    }
                }
            }

            // Initial adjustment and on resize
            adjustCarouselForScreenSize();
            window.addEventListener('resize', debounce(adjustCarouselForScreenSize, 250));

            // Utility function for debouncing
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }
        });
    </script>
@endpush
