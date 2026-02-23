@extends('layouts.app')

@section('content')
<div class="login-shell">
    <div class="login-panel">
        <section class="login-hero">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Siperlatin">
            <h1>Siperlatin</h1>
            <p>Sistem Perawatan Inventaris untuk monitoring kondisi, transaksi perawatan, dan laporan berbasis data.</p>
            <ul>
                <li><i class="fa fa-check-circle"></i> Dashboard transaksi terpusat</li>
                <li><i class="fa fa-check-circle"></i> Riwayat perawatan tiap item</li>
                <li><i class="fa fa-check-circle"></i> Cetak laporan dan QR code</li>
            </ul>
        </section>

        <section class="login-form-wrap">
            <h2>Masuk ke akun</h2>
            <p class="login-subtitle">Gunakan username dan password untuk melanjutkan.</p>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrap">
                        <i class="fa fa-user-o"></i>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                    </div>
                    @error('username')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="fa fa-lock"></i>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">Lupa password?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-sign-in"></i> Login
                </button>
            </form>
        </section>
    </div>
</div>
@endsection

@push('styles')
<style type="text/css">
    .login-shell {
        width: 100%;
        max-width: 980px;
    }

    .login-panel {
        display: grid;
        grid-template-columns: 1.05fr 1fr;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #d8e2f0;
        box-shadow: 0 16px 36px rgba(27, 42, 74, 0.14);
        background: #fff;
    }

    .login-hero {
        padding: 42px 36px;
        background:
            radial-gradient(circle at 20% 20%, rgba(255,255,255,0.14) 0, transparent 35%),
            linear-gradient(145deg, #203a66 0%, #1b2d4f 100%);
        color: #f2f7ff;
    }

    .login-hero img {
        width: 54px;
        height: 54px;
        margin-bottom: 16px;
    }

    .login-hero h1 {
        font-family: "DM Serif Display", serif;
        font-size: 2rem;
        margin-bottom: 8px;
        color: #fff;
    }

    .login-hero p {
        font-size: 14px;
        line-height: 1.7;
        color: rgba(242, 247, 255, 0.92);
        margin-bottom: 22px;
    }

    .login-hero ul {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .login-hero li {
        font-size: 14px;
        margin-bottom: 10px;
        color: #fff;
    }

    .login-hero li i {
        color: #7ce4b4;
        margin-right: 6px;
    }

    .login-form-wrap {
        padding: 38px 34px;
        background: #fff;
    }

    .login-form-wrap h2 {
        margin: 0;
        color: #1b2a4a;
        font-size: 1.5rem;
        font-weight: 800;
    }

    .login-subtitle {
        margin-top: 6px;
        margin-bottom: 26px;
        color: #5a6a87;
        font-size: 13px;
    }

    .login-form-wrap label {
        font-weight: 700;
        font-size: 13px;
        color: #304262;
        margin-bottom: 6px;
    }

    .input-wrap {
        position: relative;
    }

    .input-wrap i {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: #6884b3;
    }

    .input-wrap .form-control {
        border-radius: 12px;
        border: 1px solid #c8d5ea;
        padding-left: 38px;
        min-height: 44px;
    }

    .input-wrap .form-control:focus {
        border-color: #2f5ca8;
        box-shadow: 0 0 0 0.2rem rgba(47, 92, 168, 0.18);
    }

    .forgot-link {
        color: #2f5ca8;
        font-size: 12px;
        font-weight: 700;
    }

    .forgot-link:hover {
        text-decoration: none;
        color: #223f77;
    }

    .btn.btn-primary.btn-block {
        min-height: 44px;
        border-radius: 12px;
    }

    @media (max-width: 992px) {
        .login-shell {
            max-width: 560px;
        }

        .login-panel {
            grid-template-columns: 1fr;
        }

        .login-hero {
            padding: 26px 24px;
        }

        .login-form-wrap {
            padding: 24px 20px;
        }
    }
</style>
@endpush
