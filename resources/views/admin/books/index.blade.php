@extends('layouts.admin')

@section('title', 'Kelola Buku')

@section('actions')
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Buku
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Buku</h3>
                    <div class="card-actions">
                        <form class="d-flex" method="GET">
                            <input type="search" class="form-control me-2" name="search" placeholder="Cari buku..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>Views</th>
                                    <th>Status</th>
                                    <th class="w-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($books as $book)
                                    <tr>
                                        <td>
                                            @if ($book->cover_image)
                                                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                                    class="avatar avatar-md rounded">
                                            @else
                                                <span class="avatar avatar-md rounded">
                                                    <i class="fas fa-book"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $book->title }}</strong>
                                                @if ($book->is_featured)
                                                    <span class="badge bg-warning ms-1">Unggulan</span>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ Str::limit($book->description, 50) }}</small>
                                        </td>
                                        <td>{{ $book->author }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $book->category->name }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $book->views }}</span>
                                        </td>
                                        <td>
                                            @if ($book->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.books.show', $book) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.books.edit', $book) }}"
                                                    class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.books.destroy', $book) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Apakah Anda yakin?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-book fa-2x mb-2"></i>
                                            <div>Belum ada buku</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($books->hasPages())
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-muted">
                            Menampilkan <span>{{ $books->firstItem() }}</span> hingga
                            <span>{{ $books->lastItem() }}</span> dari <span>{{ $books->total() }}</span> buku
                        </p>
                        <ul class="pagination m-0 ms-auto">
                            {{ $books->appends(request()->query())->links() }}
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
