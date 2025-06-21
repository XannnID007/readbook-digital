@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 mb-4">
                <h2 class="fw-bold text-white">Riwayat Bacaan</h2>
                <p class="text-white-50">Semua buku yang pernah Anda baca</p>
            </div>
        </div>

        @if ($history->count() > 0)
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Cover</th>
                                    <th>Judul Buku</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>Progress</th>
                                    <th>Terakhir Dibaca</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $record)
                                    <tr>
                                        <td>
                                            @if ($record->book->cover_image)
                                                <img src="{{ Storage::url($record->book->cover_image) }}"
                                                    alt="{{ $record->book->title }}" class="rounded"
                                                    style="width: 50px; height: 70px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                    style="width: 50px; height: 70px;">
                                                    <i class="fas fa-book text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $record->book->title }}</strong>
                                            </div>
                                        </td>
                                        <td class="text-muted">{{ $record->book->author }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $record->book->category->name }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 100px;">
                                                    <div class="progress-bar bg-success"
                                                        style="width: {{ ($record->last_page / $record->book->pages) * 100 }}%">
                                                    </div>
                                                </div>
                                                <small class="text-muted">
                                                    {{ $record->last_page }}/{{ $record->book->pages }}
                                                    ({{ round(($record->last_page / $record->book->pages) * 100) }}%)
                                                </small>
                                            </div>
                                        </td>
                                        <td class="text-muted">
                                            {{ $record->last_read_at->format('d M Y, H:i') }}
                                            <br>
                                            <small
                                                class="text-success">{{ $record->last_read_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('books.read', $record->book->slug) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-play"></i> Lanjut
                                                </a>
                                                <a href="{{ route('books.show', $record->book->slug) }}"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-info"></i> Detail
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $history->links() }}
                </div>
            </div>
        @else
            <div class="text-center text-white">
                <i class="fas fa-history fa-4x mb-4"></i>
                <h4>Belum Ada Riwayat Bacaan</h4>
                <p>Mulai membaca buku untuk melihat riwayat di sini</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-search"></i> Cari Buku
                </a>
            </div>
        @endif
    </div>
@endsection
