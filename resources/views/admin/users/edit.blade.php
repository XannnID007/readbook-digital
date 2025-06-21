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
                            <label class="form-label                <div class="h1
                                mb-3">{{ number_format($stats['total_readings']) }}
                        </div>
                        <div class="d-flex mb-2">
                            <div>Riwayat baca pengguna</div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Recent Books -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Buku Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentBooks as $book)
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        @if ($book->cover_image)
                                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                                class="avatar avatar-md rounded">
                                        @else
                                            <span class="avatar avatar-md rounded">
                                                <i class="fas fa-book"></i>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col text-truncate">
                                        <a href="{{ route('admin.books.show', $book) }}"
                                            class="text-reset d-block">{{ $book->title }}</a>
                                        <div class="d-block text-muted text-truncate mt-n1">
                                            {{ $book->author }} • {{ $book->category->name }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <span class="badge bg-success">{{ $book->views }} views</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-center text-muted">
                                Belum ada buku
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Books -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Buku Populer</h3>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($popularBooks as $book)
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        @if ($book->cover_image)
                                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                                class="avatar avatar-md rounded">
                                        @else
                                            <span class="avatar avatar-md rounded">
                                                <i class="fas fa-book"></i>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col text-truncate">
                                        <a href="{{ route('admin.books.show', $book) }}"
                                            class="text-reset d-block">{{ $book->title }}</a>
                                        <div class="d-block text-muted text-truncate mt-n1">
                                            {{ $book->author }} • {{ $book->category->name }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <span class="badge bg-primary">{{ $book->views }} views</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-center text-muted">
                                Belum ada buku
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Recent Users -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pengguna Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-sm me-2 rounded">
                                                    {{ substr($user->name, 0, 2) }}
                                                </span>
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td class="text-muted">{{ $user->email }}</td>
                                        <td class="text-muted">{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge bg-success">Aktif</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $user) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada pengguna</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
