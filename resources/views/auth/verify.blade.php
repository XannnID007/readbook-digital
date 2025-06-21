@extends('layouts.app')

@section('content')
    <div class="container py-5" style="margin-top: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <i class="fas fa-envelope-open fa-4x text-primary"></i>
                        </div>

                        <h2 class="fw-bold mb-4">Verifikasi Email Anda</h2>

                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle"></i>
                                Link verifikasi baru telah dikirim ke email Anda.
                            </div>
                        @endif

                        <p class="text-muted mb-4">
                            Sebelum melanjutkan, silakan periksa email Anda untuk link verifikasi.
                            Jika Anda tidak menerima email tersebut,
                        </p>

                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Kirim Ulang Email Verifikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
