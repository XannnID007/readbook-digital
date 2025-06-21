@extends('layouts.admin')

@section('title', 'Detail User')

@section('actions')
    <div class="btn-group">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <span class="avatar avatar-xl mb-3">
                        {{ substr($user->name, 0, 2) }}
                    </span>
                    <h3>{{ $user->name }}</h3>
                    <p class="text-muted">{{ $user->email }}</p>

                    @if ($user->role === 'admin')
                        <span class="badge bg-danger fs-6">Administrator</span>
                    @else
                        <span class="badge bg-primary fs-6">User</span>
                    @endif

                    <div class="row mt-4">
                        <div class="col-4">
                            <div class="h3">{{ $stats['total_books_read'] }}</div>
                            <small class="text-muted">Buku Dibaca</small>
                        </div>
                        <div class="col-4">
                            <div class="h3">{{ $stats['total_bookmarks'] }}</div>
                            <small class="text-muted">Bookmark</small>
                        </div>
                        <div class="col-4">
                            <div class="h3">{{ $user->created_at->diffInDays() }}</div>
                            <small class="text-muted">Hari</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Informasi Akun</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <strong>Bergabung:</strong>
                        </div>
                        <div class="col-7">
                            {{ $user->created_at->format('d M Y') }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-5">
                            <strong>Kategori Favorit:</strong>
                        </div>
                        <div class="col-7">
                            {{ $stats['favorite_category'] }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-5">
                            <strong>Status:</strong>
                        </div>
                        <div class="col-7">
                            <span class="badge bg-success">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Recent Reading History -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Bacaan Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($user->readingHistories->take(5) as $history)
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        @if ($history->book->cover_image)
                                            <img src="{{ Storage::url($history->book->cover_image) }}"
                                                alt="{{ $history->book->title }}" class="avatar avatar-md rounded">
                                        @else
                                            <span class="avatar avatar-md rounded">
                                                <i class="fas fa-book"></i>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <strong>{{ $history->book->title }}</strong>
                                        <div class="text-muted">{{ $history->book->author }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-end">
                                            <div class="text-muted small">{{ $history->last_read_at->format('d M Y') }}
                                            </div>
                                            <div class="progress mt-1" style="width: 100px;">
                                                <div class="progress-bar"
                                                    style="width: {{ ($history->last_page / $history->book->pages) * 100 }}%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-center text-muted">
                                Belum ada riwayat bacaan
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Bookmarks -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bookmark Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($user->bookmarks->take(5) as $bookmark)
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        @if ($bookmark->book->cover_image)
                                            <img src="{{ Storage::url($bookmark->book->cover_image) }}"
                                                alt="{{ $bookmark->book->title }}" class="avatar avatar-md rounded">
                                        @else
                                            <span class="avatar avatar-md rounded">
                                                <i class="fas fa-book"></i>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <strong>{{ $bookmark->book->title }}</strong>
                                        <div class="text-muted">{{ $bookmark->book->author }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="text-muted small">{{ $bookmark->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-center text-muted">
                                Belum ada bookmark
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
