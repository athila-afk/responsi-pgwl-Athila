<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GeoRanah Minang</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />



    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
        }

        /* NAVBAR (Menggunakan Warna UCLA Blue) */
        .navbar {
            background: #55768C;
            color: white;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand {
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .navbar-menu a {
            color: white;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.2s;
        }

        /* Efek Hover Menu */
        .navbar-menu a:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        /* Menu yang Sedang Aktif */
        .navbar-menu a.active {
            background: rgba(255, 255, 255, 0.25);
            font-weight: bold;
        }

        /* Tombol Logout Khusus Menggunakan Warna Maroon */
        .btn-logout {
            background: #B83556;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: background 0.2s;
        }

        .btn-logout:hover {
            background: #962943;
            /* Warna maroon agak gelap sedikit saat di-hover */
        }

        /* CONTENT */
        .content {
            padding: 30px;
        }
    </style>

    @stack('styles')
</head>

<body>

    <nav class="navbar">
        <div class="navbar-brand">
            GeoRanah Minang
        </div>
        <div class="navbar-menu">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a>
            <a href="{{ url('/zona') }}" class="{{ request()->is('zona') ? 'active' : '' }}">Peta</a>
            <a href="{{ url('/tabel') }}" class="{{ request()->is('tabel') ? 'active' : '' }}">Tabel Data</a>
            <a href="{{ url('/galeri') }}" class="{{ request()->is('galeri') ? 'active' : '' }}">Galeri</a>

            <form method="POST" action="/logout" style="display:inline; margin-left: 5px;">
                @csrf
                <button type="submit" class="btn-logout">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    @yield('content')

    @stack('scripts')

</body>

</html>
