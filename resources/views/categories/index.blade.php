@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12 mb-4">
                <h2 class="fw-bold">Kategori Buku</h2>
                <p class="text-muted">Jelajahi buku berdasarkan kategori</p>
            </div>
        </div>

        <div class="row g-4">
            @foreach ($categories as $category)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card category-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="category-icon mb-3">
                                <i class="fas fa-{{ $category->icon ?? 'book' }} fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text text-muted">{{ $category->description }}</p>
                            <div class="mb-3">
                                <span class="badge bg-primary">{{ $category->books_count }} buku</span>
                            </div>
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-primary">
                                Lihat Buku
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

{{-- resources/views/categories/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12 mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
                        <li class="breadcrumb-item active">{{ $category->name }}</li>
                    </ol>
                </nav>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-2">
                            @if ($category->icon)
                                <i class="fas fa-{{ $category->icon }} me-2"></i>
                            @endif
                            {{ $category->name }}
                        </h2>
                        @if ($category->description)
                            <p class="text-muted">{{ $category->description }}</p>
                        @endif
                        <small class="text-muted">{{ $books->total() }} buku tersedia</small>
                    </div>

                    <div>
                        <select class="form-select" onchange="window.location.href='?sort=' + this.value">
                            <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>Populer</option>
                            <option value="rating" {{ $sort == 'rating' ? 'selected' : '' }}>Rating</option>
                            <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="title" {{ $sort == 'title' ? 'selected' : '' }}>Judul A-Z</option>
                            <option value="author" {{ $sort == 'author' ? 'selected' : '' }}>Penulis A-Z</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        @if ($books->count() > 0)
            <div class="row g-4">
                @foreach ($books as $book)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        @include('components.book-card', ['book' => $book])
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $books->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-book fa-4x text-muted mb-4"></i>
                <h4>Belum Ada Buku</h4>
                <p class="text-muted">Belum ada buku dalam kategori ini</p>
            </div>
        @endif
    </div>
@endsection
