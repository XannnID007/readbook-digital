@extends('layouts.admin')

@section('title', 'Tambah Buku')

@section('actions')
    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Buku</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Judul Buku</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Penulis</label>
                                    <input type="text" class="form-control @error('author') is-invalid @enderror"
                                        name="author" value="{{ old('author') }}" required>
                                    @error('author')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Kategori</label>
                                            <select class="form-select @error('category_id') is-invalid @enderror"
                                                name="category_id" required>
                                                <option value="">Pilih Kategori</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tahun Terbit</label>
                                            <input type="number"
                                                class="form-control @error('publication_year') is-invalid @enderror"
                                                name="publication_year" value="{{ old('publication_year') }}"
                                                min="1900" max="{{ date('Y') }}" required>
                                            @error('publication_year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jumlah Halaman</label>
                                            <input type="number" class="form-control @error('pages') is-invalid @enderror"
                                                name="pages" value="{{ old('pages') }}" min="1" required>
                                            @error('pages')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">ISBN</label>
                                            <input type="text" class="form-control @error('isbn') is-invalid @enderror"
                                                name="isbn" value="{{ old('isbn') }}">
                                            @error('isbn')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Cover Buku</label>
                                    <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                        name="cover_image" accept="image/*">
                                    @error('cover_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-hint">Format: JPG, PNG. Maksimal 2MB.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">File PDF</label>
                                    <input type="file" class="form-control @error('pdf_file') is-invalid @enderror"
                                        name="pdf_file" accept=".pdf" required>
                                    @error('pdf_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-hint">Format PDF. Maksimal 10MB.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-check">
                                        <input type="checkbox" class="form-check-input" name="is_featured" value="1"
                                            {{ old('is_featured') ? 'checked' : '' }}>
                                        <span class="form-check-label">Buku Unggulan</span>
                                    </label>
                                </div>

                                <div class="mb-3">
                                    <label class="form-check">
                                        <input type="checkbox" class="form-check-input" name="is_active" value="1"
                                            {{ old('is_active', true) ? 'checked' : '' }}>
                                        <span class="form-check-label">Status Aktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Buku
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
