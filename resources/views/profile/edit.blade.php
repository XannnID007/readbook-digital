@extends('layouts.app')

@push('styles')
    <style>
        .profile-edit-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.9));
            min-height: calc(100vh - 150px);
            border-radius: 20px;
            padding: 2.5rem;
            margin: 1rem 0;
            box-shadow: 0 10px 40px rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .edit-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(255, 107, 53, 0.08);
            border: 1px solid rgba(255, 107, 53, 0.1);
        }

        .section-title {
            color: #ff6b35;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preference-item {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .preference-item:hover {
            border-color: #ff6b35;
            background: rgba(255, 107, 53, 0.05);
        }

        .preference-item.selected {
            border-color: #ff6b35;
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            color: white;
        }

        .preference-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #ff6b35;
        }

        .preference-item.selected .preference-icon {
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="profile-edit-container">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Edit Profile</h2>
                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Profile Information -->
            <div class="edit-section">
                <h4 class="section-title">
                    <i class="fas fa-user"></i>
                    Informasi Profile
                </h4>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="edit-section">
                <h4 class="section-title">
                    <i class="fas fa-lock"></i>
                    Ubah Password
                </h4>

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Password Saat Ini</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Ubah Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Reading Preferences -->
            <div class="edit-section">
                <h4 class="section-title">
                    <i class="fas fa-heart"></i>
                    Preferensi Bacaan
                </h4>

                <form action="{{ route('profile.preferences') }}" method="POST" id="preferencesForm">
                    @csrf
                    @method('PUT')

                    <p class="text-muted mb-4">Pilih kategori buku yang Anda sukai untuk mendapatkan rekomendasi yang lebih
                        baik</p>

                    <div class="row g-3">
                        @foreach (\App\Models\Category::all() as $category)
                            <div class="col-md-4 col-lg-3">
                                <div class="preference-item {{ in_array($category->id, $user->preferences ?? []) ? 'selected' : '' }}"
                                    onclick="togglePreference({{ $category->id }})">
                                    <div class="preference-icon">
                                        <i class="fas fa-{{ $category->icon ?? 'book' }}"></i>
                                    </div>
                                    <h6 class="mb-1">{{ $category->name }}</h6>
                                    <small>{{ $category->books_count ?? 0 }} buku</small>
                                    <input type="checkbox" name="preferences[]" value="{{ $category->id }}" class="d-none"
                                        {{ in_array($category->id, $user->preferences ?? []) ? 'checked' : '' }}>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-magic"></i> Update Preferensi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePreference(categoryId) {
            const item = event.currentTarget;
            const checkbox = item.querySelector('input[type="checkbox"]');

            item.classList.toggle('selected');
            checkbox.checked = !checkbox.checked;
        }

        // Form validation
        document.getElementById('preferencesForm').addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('input[name="preferences[]"]:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu kategori preferensi');
            }
        });
    </script>
@endpush
