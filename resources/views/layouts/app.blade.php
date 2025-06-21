<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Digital Library') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
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
            --navbar-height: 80px;
        }

        /* Global Styles */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
            color: var(--text-dark);
        }

        /* Main Content Wrapper */
        main {
            flex: 1;
            margin-top: var(--navbar-height);
            position: relative;
        }

        /* Enhanced Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(255, 107, 53, 0.1);
            border-bottom: 1px solid rgba(255, 107, 53, 0.1);
            height: var(--navbar-height);
            transition: all 0.3s ease;
            z-index: 1030;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 4px 30px rgba(255, 107, 53, 0.15);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark) !important;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand:hover {
            color: var(--primary-orange) !important;
            transform: scale(1.05);
        }

        .navbar-brand i {
            color: var(--primary-orange);
            font-size: 1.3rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover i {
            transform: rotate(10deg);
            color: var(--secondary-orange);
        }

        .navbar-nav .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            padding: 0.75rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            margin: 0 0.25rem;
        }

        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-orange), var(--secondary-orange));
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover::before,
        .navbar-nav .nav-link.active::before {
            width: 80%;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-orange) !important;
            background: rgba(255, 107, 53, 0.05);
        }

        /* Enhanced Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border: none;
            border-radius: 25px;
            padding: 0.65rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.3s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
            background: linear-gradient(135deg, var(--secondary-orange), var(--light-orange));
        }

        /* Dropdown Enhancements */
        .dropdown-menu {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 107, 53, 0.1);
            padding: 0.5rem;
        }

        .dropdown-item {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            color: var(--text-dark);
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 0.25rem;
        }

        .dropdown-item:hover {
            background: rgba(255, 107, 53, 0.1);
            color: var(--primary-orange);
            transform: translateX(5px);
        }

        .dropdown-item i {
            color: var(--primary-orange);
            width: 20px;
            margin-right: 0.5rem;
        }

        .dropdown-divider {
            border-color: rgba(255, 107, 53, 0.2);
            margin: 0.5rem 0;
        }

        /* User Avatar in Dropdown */
        .navbar-nav .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .navbar-nav .dropdown-toggle i {
            font-size: 1.2rem;
            color: var(--primary-orange);
        }

        /* Card Global Styles */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.15);
        }

        /* Enhanced Footer */
        .footer {
            margin-top: auto;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%) !important;
            color: white;
            padding: 3rem 0 2rem;
            position: relative;
            z-index: 999;
            box-shadow: 0 -8px 30px rgba(0, 0, 0, 0.1);
            border-top: 3px solid var(--primary-orange);
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-orange), var(--secondary-orange), var(--light-orange));
        }

        .footer-brand .footer-logo {
            color: var(--primary-orange);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .footer-brand .footer-logo i {
            font-size: 1.5rem;
            color: var(--secondary-orange);
        }

        .footer-description {
            color: #bdc3c7;
            line-height: 1.8;
            margin-bottom: 0;
            max-width: 500px;
            font-size: 1rem;
        }

        .footer-social {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .social-link {
            width: 45px;
            height: 45px;
            background: #34495e;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            font-size: 1.1rem;
        }

        .social-link:hover {
            background: var(--primary-orange);
            color: white;
            transform: translateY(-3px) scale(1.1);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
        }

        .copyright {
            color: #bdc3c7;
            font-size: 0.95rem;
            margin: 0;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 107, 53, 0.2);
        }

        /* Mobile Navbar Toggler */
        .navbar-toggler {
            border: 2px solid var(--primary-orange);
            border-radius: 8px;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }

        .navbar-toggler:hover {
            background: rgba(255, 107, 53, 0.1);
            transform: scale(1.05);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23ff6b35' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Responsive Design */
        @media (max-width: 991.98px) {
            .footer-social {
                justify-content: center;
                margin-bottom: 2rem;
            }

            .navbar-nav .nav-link {
                text-align: center;
                margin: 0.25rem 0;
            }

            .btn-primary {
                width: 100%;
                margin: 0.25rem 0;
            }
        }

        @media (max-width: 768px) {
            :root {
                --navbar-height: 70px;
            }

            .navbar-brand {
                font-size: 1.3rem;
            }

            .footer {
                padding: 2rem 0 1.5rem;
            }

            .footer-social {
                gap: 0.75rem;
            }

            .social-link {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--secondary-orange), var(--light-orange));
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .loading-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 107, 53, 0.2);
            border-left: 4px solid var(--primary-orange);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Notification Styles */
        .toast {
            border-radius: 15px;
            border: none;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(20px);
        }

        /* Focus Styles for Accessibility */
        .btn:focus,
        .nav-link:focus,
        .dropdown-item:focus {
            outline: 2px solid var(--primary-orange);
            outline-offset: 2px;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Enhanced Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-book-reader"></i>
                <span>Digital Library</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('recommendations') ? 'active' : '' }}"
                            href="{{ route('recommendations') }}">
                            <i class="fas fa-star me-1"></i>Rekomendasi
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Daftar
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fas fa-user-circle"></i>
                                <span>{{ Str::limit(Auth::user()->name, 15) }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if (Auth::user()->isAdmin())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tachometer-alt"></i>Admin Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @endif
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                        <i class="fas fa-home"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.books') }}">
                                        <i class="fas fa-book"></i>Buku Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.bookmarks') }}">
                                        <i class="fas fa-bookmark"></i>Bookmark
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Enhanced Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 text-center text-lg-start mb-4 mb-lg-0">
                    <div class="footer-brand">
                        <h4 class="footer-logo">
                            <i class="fas fa-book-open"></i>
                            <span>Digital Library</span>
                        </h4>
                        <p class="footer-description">
                            Platform perpustakaan digital terdepan yang menyediakan akses mudah
                            ke ribuan buku berkualitas untuk meningkatkan literasi dan pengetahuan.
                            Bergabunglah dengan komunitas pembaca kami dan mulai petualangan literasi Anda.
                        </p>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 text-center text-lg-end">
                    <div class="footer-social">
                        <a href="#" class="social-link" title="Facebook" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link" title="Twitter" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link" title="Instagram" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link" title="LinkedIn" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                    <div class="footer-copyright">
                        <p class="copyright">
                            &copy; {{ date('Y') }} Digital Library. All rights reserved.
                            Made with <i class="fas fa-heart" style="color: var(--primary-orange);"></i> for book
                            lovers.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Global JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navbar scroll effect
            const navbar = document.getElementById('mainNavbar');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // Loading overlay
            const loadingOverlay = document.getElementById('loadingOverlay');

            // Hide loading on page load
            window.addEventListener('load', function() {
                setTimeout(() => {
                    loadingOverlay.classList.remove('show');
                }, 500);
            });

            // Show loading on navigation
            document.querySelectorAll('a:not([href^="#"]):not([href^="javascript:"]):not([data-bs-toggle])')
                .forEach(link => {
                    link.addEventListener('click', function(e) {
                        if (this.target !== '_blank') {
                            loadingOverlay.classList.add('show');
                        }
                    });
                });

            // Enhanced dropdown animations
            const dropdowns = document.querySelectorAll('.dropdown-menu');
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('show.bs.dropdown', function() {
                    this.style.transform = 'translateY(-10px)';
                    this.style.opacity = '0';
                    setTimeout(() => {
                        this.style.transform = 'translateY(0)';
                        this.style.opacity = '1';
                        this.style.transition = 'all 0.3s ease';
                    }, 10);
                });
            });

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

            // Auto-hide alerts/toasts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    if (alert.classList.contains('alert-dismissible')) {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 300);
                    }
                });
            }, 5000);

            // Enhanced form submissions
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector(
                        'button[type="submit"], input[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        const originalText = submitBtn.innerHTML || submitBtn.value;
                        submitBtn.disabled = true;

                        if (submitBtn.innerHTML !== undefined) {
                            submitBtn.innerHTML =
                                '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                        } else {
                            submitBtn.value = 'Loading...';
                        }

                        // Re-enable after 5 seconds as fallback
                        setTimeout(() => {
                            submitBtn.disabled = false;
                            if (submitBtn.innerHTML !== undefined) {
                                submitBtn.innerHTML = originalText;
                            } else {
                                submitBtn.value = originalText;
                            }
                        }, 5000);
                    }
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                    // Alt + H for Home
                    if (e.altKey && e.key.toLowerCase() === 'h') {
                        e.preventDefault();
                        window.location.href = '{{ route('home') }}';
                    }

                    // Alt + D for Dashboard (if logged in)
                    @auth
                    if (e.altKey && e.key.toLowerCase() === 'd') {
                        e.preventDefault();
                        window.location.href = '{{ route('user.dashboard') }}';
                    }
                @endauth
            });

        // Performance optimization
        let resizeTimer; window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                // Handle responsive adjustments
                const navbar = document.querySelector('.navbar-collapse');
                if (window.innerWidth > 991.98 && navbar.classList.contains('show')) {
                    navbar.classList.remove('show');
                }
            }, 250);
        });
        });

        // Global toast function
        window.showToast = function(message, type = 'info', duration = 3000) {
            const toastClass = {
                success: 'bg-success',
                error: 'bg-danger',
                warning: 'bg-warning',
                info: 'bg-info'
            };

            const toast = document.createElement('div');
            toast.className = `toast show position-fixed top-0 end-0 m-3 ${toastClass[type]} text-white`;
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : type === 'warning' ? 'exclamation' : 'info'}-circle me-2"></i>
                    ${message}
                </div>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, duration);
        };
    </script>

    @stack('scripts')
</body>

</html>
