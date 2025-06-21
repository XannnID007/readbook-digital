@extends('layouts.app')

@push('styles')
    <style>
        .profile-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.9));
            min-height: calc(100vh - 150px);
            border-radius: 20px;
            padding: 2.5rem;
            margin: 1rem 0;
            box-shadow: 0 10px 40px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .profile-header {
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            color: white;
            text-align: center;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 4px solid rgba(255, 255, 255, 0.3);
            font-size: 3rem;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="profile-container">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h2 class="mb-2">{{ $user->name }}</h2>
                <p class="mb-3 opacity-90">{{ $user->email }}</p>
                <span class="badge bg-dark fs-6">
                    {{ $user->isAdmin() ? 'Administrator' : 'Member' }}
                </span>
            </div>

            <!-- Statistics -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <x-stats-card title="Buku Dibaca" :value="$stats['books_read']" icon="book-open" color="primary" />
                </div>
                <div class="col-md-3">
                    <x-stats-card title="Bookmark" :value="$stats['bookmarks']" icon="bookmark" color="warning" />
                </div>
                <div class="col-md-3">
                    <x-stats-card title="Waktu Baca" :value="$stats['reading_time'] . ' menit'" icon="clock" color="success" />
                </div>
                <div class="col-md-3">
                    <x-stats-card title="Halaman Dibaca" :value="number_format($stats['total_pages_read'])" icon="file-alt" color="info" />
                </div>
            </div>

            <!-- Profile Actions -->
            <div class="text-center">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary me-2">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection
