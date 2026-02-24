<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Siperlatin</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        :root {
            --deep-blue: #1b2a4a;
            --mid-blue: #27447b;
            --line: #d5e2f1;
            --text: #1a2a46;
            --text-soft: #57698b;
            --panel: #ffffff;
            --accent: #dc6a36;
        }

        html, body {
            min-height: 100%;
        }

        body {
            margin: 0;
            color: var(--text);
            font-family: "Plus Jakarta Sans", sans-serif;
            background:
                radial-gradient(circle at 12% 18%, rgba(214, 230, 255, 0.8), transparent 30%),
                radial-gradient(circle at 90% 12%, rgba(255, 229, 213, 0.75), transparent 24%),
                linear-gradient(135deg, #f0f5fc 0%, #e7effb 55%, #dce8fa 100%);
        }

        .welcome-wrap {
            min-height: 100vh;
            padding: 28px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-panel {
            width: 100%;
            max-width: 1050px;
            border-radius: 24px;
            border: 1px solid var(--line);
            overflow: hidden;
            box-shadow: 0 22px 50px rgba(22, 45, 82, 0.16);
            background: var(--panel);
            display: grid;
            grid-template-columns: 1.1fr 1fr;
        }

        .welcome-brand {
            padding: 44px 40px;
            color: #f5f9ff;
            background:
                radial-gradient(circle at 8% 10%, rgba(255,255,255,0.18), transparent 28%),
                linear-gradient(160deg, var(--mid-blue) 0%, var(--deep-blue) 100%);
        }

        .welcome-eyebrow {
            letter-spacing: 1.6px;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            opacity: 0.84;
            margin-bottom: 14px;
        }

        .welcome-brand h1 {
            margin: 0;
            font-family: "DM Serif Display", serif;
            font-size: 3.1rem;
            font-weight: 400;
            line-height: 1;
            color: #fff;
        }

        .welcome-badge {
            display: inline-block;
            margin-left: 8px;
            font-size: 12px;
            font-weight: 700;
            background: rgba(220, 106, 54, 0.95);
            color: #fff;
            padding: 4px 10px;
            border-radius: 999px;
            vertical-align: top;
            margin-top: 10px;
        }

        .welcome-brand p {
            margin: 18px 0 0;
            font-size: 14px;
            line-height: 1.8;
            color: rgba(245, 249, 255, 0.92);
        }

        .welcome-list {
            list-style: none;
            padding: 0;
            margin: 22px 0 0;
        }

        .welcome-list li {
            margin-bottom: 10px;
            font-size: 14px;
            color: #fff;
        }

        .welcome-list i {
            color: #89f2bf;
            margin-right: 6px;
        }

        .welcome-main {
            padding: 38px 34px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .office-title {
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 26px;
            line-height: 1.45;
            text-align: center;
            color: #21447e;
            font-weight: 800;
            margin-bottom: 22px;
        }

        .office-logo {
            width: 180px;
            max-width: 100%;
            display: block;
            margin: 0 auto 16px;
        }

        .office-subtitle {
            text-align: center;
            font-size: 14px;
            color: var(--text-soft);
            margin-bottom: 22px;
            font-weight: 600;
        }

        .welcome-actions .btn {
            min-height: 46px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            border: 0;
        }

        .welcome-actions .btn-primary {
            background: linear-gradient(135deg, #2f5ca8, #294883);
        }

        .welcome-actions .btn-outline-primary {
            border: 1px solid #2f5ca8;
            color: #2f5ca8;
            background: transparent;
            margin-top: 10px;
        }

        .welcome-foot {
            margin-top: 16px;
            text-align: center;
            font-size: 12px;
            color: #667796;
            line-height: 1.7;
        }

        @media (max-width: 992px) {
            .welcome-panel {
                grid-template-columns: 1fr;
            }

            .welcome-brand {
                padding: 30px 24px;
            }

            .welcome-brand h1 {
                font-size: 2.5rem;
            }

            .welcome-main {
                padding: 26px 20px;
            }

            .office-title {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-wrap">
        <div class="welcome-panel">
            <section class="welcome-brand">
                <div class="welcome-eyebrow">Sistem Informasi</div>
                <h1>
                    Siperlatin
                    <span class="welcome-badge">v2</span>
                </h1>
                <p>Sistem Perawatan Peralatan dan Mesin untuk pencatatan inventaris, histori transaksi, laporan periodik, dan cetak QR code.</p>
                <ul class="welcome-list">
                    <li><i class="fa fa-check-circle"></i> Data barang dan sub-barang terstruktur</li>
                    <li><i class="fa fa-check-circle"></i> Monitoring biaya perawatan transparan</li>
                    <li><i class="fa fa-check-circle"></i> Laporan cepat dan siap cetak</li>
                </ul>
            </section>

            <section class="welcome-main">
                <div class="office-title">Pengadilan Tinggi Agama Papua Barat</div>
                <img
                    class="office-logo"
                    src="{{ asset('public/images/new logo.png') }}"
                    onerror="this.onerror=null;this.src='{{ asset('public/images/new logo.png') }}';"
                    alt="Logo Pengadilan Tinggi Agama Papua Barat">
                <div class="office-subtitle">Masuk ke sistem untuk mengelola data perawatan inventaris.</div>

                <div class="welcome-actions">
                    @auth
                        <a href="{{ route('home') }}" class="btn btn-primary btn-block">
                            <i class="fa fa-home"></i> Ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-block">
                            <i class="fa fa-sign-in"></i> Login
                        </a>
                    @endauth
                </div>

                <div class="welcome-foot">
                    Jl. Brawijaya, Kelurahan Manokwari Timur, Distrik Manokwari, Papua Barat.
                </div>
            </section>
        </div>
    </div>
</body>
</html>
