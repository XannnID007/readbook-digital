@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="card">
                    <div class="card-body py-5">
                        <div class="mb-4">
                            <i class="fas fa-book-dead fa-4x text-muted"></i>
                        </div>
                        <h1 class="display-1 fw-bold text-primary">404</h1>
                        <h3 class="mb-4">Halaman Tidak Ditemukan</h3>
                        <p class="text-muted mb-4">
                            Maaf, halaman yang Anda cari tidak dapat ditemukan.
                            Mungkin halaman telah dipindahkan atau tidak pernah ada.
                        </p>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-home"></i> Kembali ke Beranda
                            </a>
                            <button onclick="history.back()" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```

## 25. Error 403 Page
**resources/views/errors/403.blade.php:**
```blade
@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="card">
                    <div class="card-body py-5">
                        <div class="mb-4">
                            <i class="fas fa-lock fa-4x text-danger"></i>
                        </div>
                        <h1 class="display-1 fw-bold text-danger">403</h1>
                        <h3 class="mb-4">Akses Ditolak</h3>
                        <p class="text-muted mb-4">
                            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
                            Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
                        </p>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-home"></i> Kembali ke Beranda
                            </a>
                            @auth
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                                    </a>
                                @else
                                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-user"></i> Dashboard Saya
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
