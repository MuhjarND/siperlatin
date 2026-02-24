<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Siperlatin</title>
    <link rel="icon" href="{{ asset('public/images/new logo.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.standalone.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style type="text/css">
        :root {
            --brand-dark: #1b2a4a;
            --brand-mid: #243a67;
            --brand-soft: #30528f;
            --surface: #f4f7fb;
            --surface-panel: #ffffff;
            --surface-muted: #eaf0f9;
            --text: #17233a;
            --text-soft: #4b5b7a;
            --accent: #e16835;
            --accent-soft: #ffe3d6;
            --line: #d7e0ee;
            --ok: #2f8f62;
            --warning: #d48f18;
            --danger: #c73d3d;
        }

        html, body {
            min-height: 100%;
        }

        body {
            margin: 0;
            color: var(--text);
            font-family: "Plus Jakarta Sans", sans-serif;
            background:
                radial-gradient(circle at 10% 20%, #d8e5ff 0, transparent 25%),
                radial-gradient(circle at 95% 10%, #ffe4d6 0, transparent 22%),
                linear-gradient(135deg, #edf3fb 0%, #f5f8fd 50%, #eef4fc 100%);
        }

        a {
            color: inherit;
        }

        .app-shell {
            min-height: 100vh;
            display: flex;
            position: relative;
        }

        .sidebar {
            width: 272px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--brand-dark) 0%, var(--brand-mid) 100%);
            color: #f2f6ff;
            padding: 24px 16px;
            box-shadow: 8px 0 24px rgba(16, 32, 60, 0.2);
            z-index: 1010;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 8px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.14);
            margin-bottom: 18px;
        }

        .sidebar-brand img {
            width: 34px;
            height: 34px;
        }

        .sidebar-brand strong {
            font-family: "DM Serif Display", serif;
            font-size: 1.25rem;
            letter-spacing: 0.3px;
            font-weight: 400;
        }

        .sidebar-section {
            margin: 14px 0 18px;
        }

        .sidebar-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.6px;
            color: rgba(242, 246, 255, 0.62);
            padding: 0 10px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            color: rgba(242, 246, 255, 0.9);
            text-decoration: none;
            transition: all .18s ease;
            margin-bottom: 4px;
            font-size: 14px;
            font-weight: 600;
        }

        .sidebar-link i {
            width: 16px;
            text-align: center;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(255,255,255,0.2), rgba(255,255,255,0.08));
            text-decoration: none;
            transform: translateX(2px);
        }

        .sidebar-footer {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
        }

        .sidebar-btn {
            width: 100%;
            border: 0;
            border-radius: 12px;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            transition: background .2s ease;
        }

        .sidebar-btn:hover {
            background: rgba(255, 255, 255, 0.24);
        }

        .main-shell {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 900;
            background: rgba(255, 255, 255, 0.84);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-title {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .topbar-title strong {
            font-size: 15px;
            font-weight: 800;
            color: var(--text);
        }

        .topbar-title span {
            font-size: 12px;
            color: var(--text-soft);
        }

        .topbar-user {
            font-size: 13px;
            color: var(--text-soft);
            font-weight: 700;
            background: var(--surface-muted);
            border: 1px solid var(--line);
            padding: 6px 12px;
            border-radius: 999px;
        }

        .sidebar-toggle {
            display: none;
            border: 1px solid var(--line);
            background: var(--surface-panel);
            color: var(--text);
            border-radius: 10px;
            width: 38px;
            height: 38px;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }

        .content-area {
            padding: 22px 24px 28px;
        }

        .app-footer {
            margin-top: auto;
            font-size: 12px;
            color: var(--text-soft);
            border-top: 1px solid var(--line);
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.65);
        }

        .card {
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 10px 24px rgba(32, 56, 97, 0.08);
            overflow: hidden;
        }

        .card-header {
            border-bottom: 1px solid var(--line);
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            color: var(--brand-dark);
            font-weight: 800;
        }

        .btn {
            border-radius: 10px;
            font-weight: 700;
        }

        .btn-primary {
            border: 0;
            background: linear-gradient(135deg, #2f5ca8, #294883);
        }

        .btn-danger {
            border: 0;
            background: linear-gradient(135deg, #d75151, #bb3d3d);
        }

        .btn-success {
            border: 0;
            background: linear-gradient(135deg, #3a9d70, #2f855f);
        }

        .form-control, .custom-select {
            border-radius: 10px;
            border: 1px solid #ccd7e8;
            min-height: 40px;
        }

        table.table thead th {
            border-top: 0;
            background: #f3f7ff;
            color: var(--brand-mid);
        }

        .guest-shell {
            min-height: 100vh;
            padding: 28px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-overlay {
            display: none;
        }

        #tanggal {
            cursor: pointer;
        }

        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                transform: translateX(-100%);
                transition: transform .2s ease;
                width: 260px;
                padding-top: 20px;
            }

            .sidebar-toggle {
                display: inline-flex;
            }

            .content-area {
                padding: 14px 12px 20px;
            }

            .topbar {
                padding: 10px 12px;
            }

            body.sidebar-open .sidebar {
                transform: translateX(0);
            }

            .sidebar-overlay {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(12, 20, 36, 0.52);
                z-index: 1000;
                opacity: 0;
                pointer-events: none;
                transition: opacity .2s ease;
            }

            body.sidebar-open .sidebar-overlay {
                opacity: 1;
                pointer-events: auto;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="app">
        @if(Auth::check())
        <div class="app-shell">
            <div class="sidebar-overlay js-sidebar-overlay"></div>
            <aside class="sidebar">
                <a class="sidebar-brand text-decoration-none" href="{{ url('/home') }}">
                    <img src="{{ asset('public/images/new logo.png') }}" alt="Siperlatin">
                    <strong>Siperlatin</strong>
                </a>

                <div class="sidebar-section">
                    <div class="sidebar-title">Utama</div>
                    <a class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fa fa-home"></i> Dashboard
                    </a>
                </div>

                <div class="sidebar-section">
                    <div class="sidebar-title">Transaksi</div>
                    <a class="sidebar-link {{ request()->routeIs('transaksi_perawatan.*') ? 'active' : '' }}" href="{{ route('transaksi_perawatan.index') }}">
                        <i class="fa fa-exchange"></i> Perawatan
                    </a>
                </div>

                <div class="sidebar-section">
                    <div class="sidebar-title">Master Data</div>
                    <a class="sidebar-link {{ request()->routeIs('barang.*') ? 'active' : '' }}" href="{{ route('barang.index') }}">
                        <i class="fa fa-cubes"></i> Daftar Barang
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('satuan_barang.*') ? 'active' : '' }}" href="{{ route('satuan_barang.index') }}">
                        <i class="fa fa-balance-scale"></i> Satuan Barang
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('kondisi_barang.*') ? 'active' : '' }}" href="{{ route('kondisi_barang.index') }}">
                        <i class="fa fa-heartbeat"></i> Kondisi Barang
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('ruang.*') ? 'active' : '' }}" href="{{ route('ruang.index') }}">
                        <i class="fa fa-building-o"></i> Daftar Ruang
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('brand.*') ? 'active' : '' }}" href="{{ route('brand.index') }}">
                        <i class="fa fa-tags"></i> Daftar Brand / Merk
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('kuasa_pengguna_barang.*') ? 'active' : '' }}" href="{{ route('kuasa_pengguna_barang.index') }}">
                        <i class="fa fa-user-circle-o"></i> Kuasa Pengguna Barang
                    </a>
                </div>

                <div class="sidebar-section">
                    <div class="sidebar-title">Laporan & Cetak</div>
                    <a class="sidebar-link {{ request()->routeIs('laporan.transaksi.*') ? 'active' : '' }}" href="{{ route('laporan.transaksi.index') }}">
                        <i class="fa fa-file-text-o"></i> Laporan Transaksi
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('cetak.qrcode.*') ? 'active' : '' }}" href="{{ route('cetak.qrcode.index') }}">
                        <i class="fa fa-qrcode"></i> Cetak QR Code
                    </a>
                </div>

                <div class="sidebar-footer">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="sidebar-btn" type="submit">
                            <i class="fa fa-sign-out"></i> Logout
                        </button>
                    </form>
                </div>
            </aside>

            <section class="main-shell">
                <header class="topbar">
                    <div class="d-flex align-items-center">
                        <button type="button" class="sidebar-toggle js-sidebar-toggle">
                            <i class="fa fa-bars"></i>
                        </button>
                        <div class="topbar-title">
                            <strong>Sistem Perawatan Inventaris</strong>
                            <span>Pengadilan Tinggi Agama Papua Barat</span>
                        </div>
                    </div>
                    <div class="topbar-user">
                        <i class="fa fa-user-o"></i> {{ Auth::user()->username }}
                    </div>
                </header>

                <main class="content-area">
                    @yield('content')
                </main>

                <footer class="app-footer">
                    Copyright &copy; Siperlatin v2 - Pengadilan Tinggi Agama Papua Barat
                </footer>
            </section>
        </div>
        @else
        <main class="guest-shell">
            @yield('content')
        </main>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.25/api/sum().js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".js-sidebar-toggle").on("click", function(){
                $("body").toggleClass("sidebar-open");
            });

            $(".js-sidebar-overlay").on("click", function(){
                $("body").removeClass("sidebar-open");
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
