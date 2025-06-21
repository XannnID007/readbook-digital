@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 mb-4">
                <h2 class="fw-bold text-white">Hasil Pencarian</h2>
                <p class="text-white-50">
                    @if (request('q'))
                        Menampilkan hasil untuk: <strong>"{{ request('q') }}"</strong>
                    @endif
                </p>
            </div>
        </div>

        <!-- Search Form -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('search') }}">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="q"
                                        placeholder="Cari judul buku, penulis..." value="{{ request('q') }}">
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select" name="category">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results -->
        @if (isset($books) && $books->count() > 0)
            <div class="row">
                <div class="col-12 mb-3">
                    <p class="text-white">Ditemukan {{ $books->total() }} buku</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($books as $book)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card book-card h-100">
                            <div class="position-relative">
                                @if ($book->cover_image)
                                    <img src="{{ Storage::url($book->cover_image) }}" class="card-img-top"
                                        alt="{{ $book->title }}" style="height: 250px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                        style="height: 250px;">
                                        <i class="fas fa-book fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-primary">{{ $book->category->name }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">{{ $book->title }}</h6>
                                <p class="text-muted small">oleh {{ $book->author }}</p>
                                <p class="card-text small">{{ Str::limit($book->description, 80) }}</p>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="text-warning small">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $book->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-eye"></i> {{ $book->views }}
                                    </small>
                                </div>

                                <div class="d-grid">
                                    <a href="{{ route('books.show', $book->slug) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $books->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <div class="text-center text-white">
                <i class="fas fa-search fa-4x mb-4"></i>
                <h4>Tidak Ada Hasil</h4>
                <p>Coba gunakan kata kunci yang berbeda atau pilih kategori lain</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        @endif
    </div>
@endsection
