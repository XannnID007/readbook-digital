<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Admin Dashboard</title>

    <!-- Tabler CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .sidebar-brand {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stats-card .card-body {
            padding: 1.5rem;
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="page">
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <h1 class="navbar-brand sidebar-brand">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-book-reader"></i>
                        Digital Library
                    </a>
                </h1>

                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fas fa-tachometer-alt"></i>
                                </span>
                                <span class="nav-link-title">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="#books-menu" data-bs-toggle="dropdown"
                                role="button">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fas fa-book"></i>
                                </span>
                                <span class="nav-link-title">Kelola Buku</span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.books.index') }}">
                                    Daftar Buku
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.books.create') }}">
                                    Tambah Buku
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="#categories-menu" data-bs-toggle="dropdown"
                                role="button">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fas fa-tags"></i>
                                </span>
                                <span class="nav-link-title">Kelola Kategori</span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.categories.index') }}">
                                    Daftar Kategori
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.categories.create') }}">
                                    Tambah Kategori
                                </a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                                href="{{ route('admin.users.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fas fa-users"></i>
                                </span>
                                <span class="nav-link-title">Kelola User</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fas fa-external-link-alt"></i>
                                </span>
                                <span class="nav-link-title">Lihat Website</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Header -->
        <header class="navbar navbar-expand-md navbar-light d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                            <span class="avatar avatar-sm">
                                <i class="fas fa-user-circle fa-lg"></i>
                            </span>
                            <div class="d-none d-xl-block ps-2">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="mt-1 small text-muted">Administrator</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{{ route('user.dashboard') }}" class="dropdown-item">
                                <i class="fas fa-user"></i> User Dashboard
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="page-wrapper">
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">@yield('title')</h2>
                            @hasSection('breadcrumb')
                                <div class="page-subtitle">@yield('breadcrumb')</div>
                            @endif
                        </div>
                        @hasSection('actions')
                            <div class="col-auto ms-auto">
                                @yield('actions')
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="page-body">
                <div class="container-xl">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Tabler JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('scripts')
</body>

</html>
