@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengguna</h3>
                    <div class="card-actions">
                        <form class="d-flex" method="GET">
                            <input type="search" class="form-control me-2" name="search" placeholder="Cari user..."
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
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Buku Dibaca</th>
                                    <th>Bookmark</th>
                                    <th>Bergabung</th>
                                    <th class="w-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-sm me-2 rounded">
                                                    {{ substr($user->name, 0, 2) }}
                                                </span>
                                                <div>
                                                    <strong>{{ $user->name }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted">{{ $user->email }}</td>
                                        <td>
                                            @if ($user->role === 'admin')
                                                <span class="badge bg-danger">Admin</span>
                                            @else
                                                <span class="badge bg-primary">User</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $user->reading_histories_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{ $user->bookmarks_count }}</span>
                                        </td>
                                        <td class="text-muted">{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.users.show', $user) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                    class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if ($user->id !== auth()->id())
                                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Apakah Anda yakin?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-users fa-2x mb-2"></i>
                                            <div>Belum ada pengguna</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($users->hasPages())
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-muted">
                            Menampilkan <span>{{ $users->firstItem() }}</span> hingga
                            <span>{{ $users->lastItem() }}</span> dari <span>{{ $users->total() }}</span> pengguna
                        </p>
                        <ul class="pagination m-0 ms-auto">
                            {{ $users->appends(request()->query())->links() }}
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
