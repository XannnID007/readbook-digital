@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('actions')
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Kategori: {{ $category->name }}</h3>
                </div>
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Icon (Font Awesome)</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon"
                                value="{{ old('icon', $category->icon) }}"
                                placeholder="Contoh: book, laptop, graduation-cap">
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">
                                Gunakan nama icon Font Awesome tanpa prefix "fa-".
                                <a href="https://fontawesome.com/icons" target="_blank">Lihat daftar icon</a>
                            </small>
                            @if ($category->icon)
                                <div class="mt-2">
                                    <span class="text-muted">Icon saat ini: </span>
                                    <i class="fas fa-{{ $category->icon }}"></i>
                                </div>
                            @endif
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Kategori ini memiliki <strong>{{ $category->books()->count() }} buku</strong>.
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
