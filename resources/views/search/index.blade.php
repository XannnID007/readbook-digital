@extends('layouts.app')

@push('styles')
    <style>
        .search-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.9));
            min-height: calc(100vh - 150px);
            border-radius: 20px;
            padding: 2.5rem;
            margin: 1rem 0;
            box-shadow: 0 10px 40px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .search-header {
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .search-form {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="search-container">
            <!-- Search Header -->
            <div class="search-header">
                <h2 class="mb-3">
                    <i class="fas fa-search me-2"></i>
                    @if ($query)
                        Hasil Pencarian: "{{ $query }}"
                    @else
                        Pencarian Buku
                    @endif
                </h2>
                <p class="mb-0 opacity-90">
                    @if ($books->total() > 0)
                        Ditemukan {{ $books->total() }} buku
                    @else
                        Cari buku berdasarkan judul, penulis, atau kategori
                    @endif
                </p>
            </div>

            <!-- Search Form -->
            <div class="search-form">
                <form method="GET" action="{{ route('search') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Cari Buku</label>
                            <input type="text" class="form-control" name="q" placeholder="Judul, penulis..."
                                value="{{ $query }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" name="category">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $categoryId == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Urutkan</label>
                            <select class="form-select" name="sort">
                                <option value="relevance" {{ $sort == 'relevance' ? 'selected' : '' }}>Relevansi</option>
                                <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>Populer</option>
                                <option value="rating" {{ $sort == 'rating' ? 'selected' : '' }}>Rating</option>
                                <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="title" {{ $sort == 'title' ? 'selected' : '' }}>Judul A-Z</option>
                                <option value="author" {{ $sort == 'author' ? 'selected' : '' }}>Penulis A-Z</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results -->
            @if ($books->count() > 0)
                <div class="row g-4">
                    @foreach ($books as $book)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            @include('components.book-card', ['book' => $book])
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $books->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-4"></i>
                    <h4>Tidak Ada Hasil</h4>
                    <p class="text-muted">Coba gunakan kata kunci yang berbeda atau pilih kategori lain</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
