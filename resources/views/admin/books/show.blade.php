@extends('layouts.admin')

@section('title', 'Detail Buku')

@section('actions')
    <div class="btn-group">
        <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if ($book->cover_image)
                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                            class="img-fluid rounded mb-3" style="max-height: 400px;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded mb-3"
                            style="height: 400px;">
                            <i class="fas fa-book fa-4x text-muted"></i>
                        </div>
                    @endif

                    <div class="row text-center">
                        <div class="col-4">
                            <div class="h4">{{ $book->pages }}</div>
                            <small class="text-muted">Halaman</small>
                        </div>
                        <div class="col-4">
                            <div class="h4">{{ $book->views }}</div>
                            <small class="text-muted">Views</small>
                        </div>
                        <div class="col-4">
                            <div class="h4">{{ $book->rating }}</div>
                            <small class="text-muted">Rating</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Buku</h3>
                    <div class="card-actions">
                        @if ($book->is_featured)
                            <span class="badge bg-warning me-2">Unggulan</span>
                        @endif
                        @if ($book->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Nonaktif</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <strong>Judul:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $book->title }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <strong>Penulis:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $book->author }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <strong>Kategori:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="badge bg-primary">{{ $book->category->name }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <strong>Deskripsi:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $book->description }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <strong>Tahun Terbit:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $book->publication_year }}
                        </div>
                    </div>
                    @if ($book->isbn)
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <strong>ISBN:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $book->isbn }}
                            </div>
                        </div>
                    @endif
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <strong>File PDF:</strong>
                        </div>
                        <div class="col-sm-9">
                            @if ($book->pdf_file)
                                <a href="{{ Storage::url($book->pdf_file) }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-file-pdf"></i> Lihat PDF
                                </a>
                            @else
                                <span class="text-muted">Tidak ada file</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <strong>Ditambahkan:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $book->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <strong>Terakhir Update:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $book->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
