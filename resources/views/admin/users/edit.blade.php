@extends('layouts.admin')

@section('title', 'Edit User')

@section('actions')
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit User: {{ $user->name }}</h3>
                </div>
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>
                                    User
                                </option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($user->preferences)
                            <div class="mb-3">
                                <label class="form-label">Preferensi Kategori</label>
                                <div class="form-control-plaintext">
                                    @php
                                        $categories = \App\Models\Category::whereIn('id', $user->preferences)->get();
                                    @endphp
                                    @foreach ($categories as $category)
                                        <span class="badge bg-primary me-1">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Statistik User</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="subheader">Buku Dibaca</div>
                                                <div class="ms-auto lh-1">
                                                    <i class="fas fa-book fa-2x opacity-75"></i>
                                                </div>
                                            </div>
                                            <div class="h1 mb-3">{{ $user->readingHistories->count() }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="subheader">Bookmark</div>
                                                <div class="ms-auto lh-1">
                                                    <i class="fas fa-bookmark fa-2x opacity-75"></i>
                                                </div>
                                            </div>
                                            <div class="h1 mb-3">{{ $user->bookmarks->count() }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($user->id === auth()->id())
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Anda sedang mengedit akun Anda sendiri. Berhati-hatilah saat mengubah role.
                            </div>
                        @endif
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
