@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div
        style="padding: 30px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; min-height: 100vh; box-sizing: border-box;">

        <div
            style="background-image: linear-gradient(rgba(184, 53, 86, 0.40), rgba(184, 53, 86, 0.45)), url('https://i.pinimg.com/1200x/ad/4f/1f/ad4f1f63487929774d718eec9635fefe.jpg'); background-size: cover; background-position: center; color: white; padding: 45px 35px 55px 35px; border-radius: 14px; margin-bottom: 25px; box-shadow: 0 6px 20px rgba(184, 53, 86, 0.15); position: relative;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px;">
                <div style="flex: 1; min-width: 0;">
                    <h1
                        style="margin: 0 0 10px 0; font-size: clamp(20px, 2.4vw, 32px); font-weight: 800; letter-spacing: -0.5px; line-height: 1.3; white-space: nowrap;">
                        GeoRanah Minang: Manata Ranah, Manjago Nagari</h1>
                    <p style="margin: 0; opacity: 0.95; font-size: 16px; font-weight: 500;">👤 Salamaik datang ka Ranah Minang,
                        {{ auth()->user()->name }}!</p>
                </div>

                <div style="position: absolute; bottom: 20px; right: 35px; text-align: right; color: white;">
                    <span style="font-size: 14px; font-weight: 600; opacity: 0.95; margin-right: 15px;">📅 <span
                            id="live-date">-- -- ----</span></span>
                    <span style="font-size: 14px; opacity: 0.95;">🕒 <span id="live-clock"
                            style="font-weight: 700;">--:--:--</span> WIB</span>
                </div>
            </div>
        </div>

        <div
            style="display: grid; grid-template-columns: calc(50% - 13px) calc(50% - 13px); gap: 25px; align-items: start;">

            <div style="display: flex; flex-direction: column; gap: 25px; width: 100%;">

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                    <div
                        style="background: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 12px #55768C; display: flex; align-items: center; gap: 15px; border-left: 5px solid #B83556;">
                        <div
                            style="background: #fbebed; padding: 10px; border-radius: 50%; width: 52px; height: 52px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-map" style="color: #B83556; font-size: 22px;"></i>
                        </div>
                        <div>
                            <div style="font-size: 24px; font-weight: bold; color: #B83556;">{{ $totalZona }}</div>
                            <div style="color: #000000; font-size: 12px;">Total Lahan</div>
                        </div>
                    </div>
                    <div
                        style="background: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 12px #55768C; display: flex; align-items: center; gap: 15px; border-left: 5px solid #B83556;">
                        <div
                            style="background: #fbebed; padding: 10px; border-radius: 50%; width: 52px; height: 52px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-location-dot" style="color: #B83556; font-size: 22px;"></i>
                        </div>
                        <div>
                            <div style="font-size: 24px; font-weight: bold; color: #B83556;">{{ $totalPoint }}</div>
                            <div style="color: #000000; font-size: 12px;">Total Fasilitas</div>
                        </div>
                    </div>
                    <div
                        style="background: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 12px #55768C; display: flex; align-items: center; gap: 15px; border-left: 5px solid #DC97A5;">
                        <div
                            style="background: #fbebed; padding: 10px; border-radius: 50%; width: 52px; height: 52px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-road" style="color: #B83556; font-size: 22px;"></i>
                        </div>
                        <div>
                            <div style="font-size: 24px; font-weight: bold; color: #B83556;">{{ $totalPolyline }}</div>
                            <div style="color: #000000; font-size: 12px;">Total Jalan</div>
                        </div>
                    </div>
                </div>

                <div
                    style="background: #55768C; border-radius: 14px; box-shadow: 0 4px 15px #55768C; overflow: hidden; width: 100%;">
                    <div style="padding: 15px 20px; border-bottom: 1px solid #fbebed; background: #fbebed;">
                        <h4 style="margin: 0; color: #B83556; font-size: 15px; font-weight: 600;">Peta Interaktif Wilayah
                        </h4>
                    </div>
                    <div id="mini-map" style="height: 320px; width: 100%;"></div>

                    <a href="/zona"
                        style="display: block; text-align: center; background: #fbebed; color: #B83556; padding: 14px; text-decoration: none; font-weight: bold; font-size: 14px; transition: background 0.3s;">
                        Buka Peta Penuh & Digitasi ➔
                    </a>
                </div>

                <div
                    style="background: #fbebed; padding: 20px; border-radius: 14px; box-shadow: 0 4px 15px #55768C; display: flex; align-items: center; gap: 18px; width: 100%; box-sizing: border-box;">
                    <img src="{{ asset('image/Athila.jpg') }}" alt="Foto Profil"
                        style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                    <div>
                        <h4 style="margin: 0 0 6px 0; color: #B83556; font-size: 15px; font-weight: bold;">Identitas
                            Pengembang</h4>
                        <div style="font-size: 15px; font-weight: bold; color: #000000;">Nama : Athila</div>
                        <div style="font-size: 15px; font-weight: bold; color: #000000 ; margin-top: 2px;">NIM :
                            24/544641/SV/25487</div>
                        <div style="font-size: 15px; font-weight: bold; color: #000000;">Prodi : Sistem Informasi Geografis
                        </div>
                    </div>
                </div>

            </div>

            <div style="display: flex; flex-direction: column; gap: 25px; width: 100%;">

                <div
                    style="background: #fbebed; padding: 20px; border-radius: 14px; box-shadow: 0 4px 15px #55768C; width: 100%; box-sizing: border-box;">
                    <h4 style="margin: 0 0 15px 0; color: #B83556; font-size: 15px; font-weight: 600;">📊 Proporsi Data
                        Spasial Terdigitasi</h4>

                    <div id="spatial-donut-chart" style="margin-bottom: 15px;"></div>

                    <div style="border-top: 1px solid #eee; padding-top: 15px; text-align: center;">
                        <div style="font-size: 24px; font-weight: bold; color: #B83556;">
                            {{ $totalZona + $totalPoint + $totalPolyline }}</div>
                        <div style="font-size: 12px; font-weight: bold ;color: #55768C;">Total Keseluruhan Aset Objek
                            Spasial</div>
                    </div>
                </div>

                <div
                    style="background: #fbebed; padding: 20px; border-radius: 14px; box-shadow: 0 4px 15px #55768C; display: flex; flex-direction: column; justify-content: space-between; box-sizing: border-box; width: 100%;">
                    <div>
                        <h4 style="margin: 0 0 10px 0; color: #B83556; font-size: 15px; font-weight: 600;">📋 Tentang
                            Aplikasi</h4>
                        <p
                            style="color: #55768C; font-size: 13px; line-height: 1.6; margin: 0 0 15px 0; font-weight: bold;">
                            Selamat datang di GeoRanah Minang, portal resmi pengelolaan data geospasial tata ruang Sumatera
                            Barat. Dikembangkan untuk mempermudah proses digitasi wilayah, sistem ini mengintegrasikan
                            pemetaan interaktif objek vital daerah (Point), jalur konektivitas transportasi (Polyline), dan
                            zonasi guna lahan (Polygon) agar dapat diakses secara cepat dan informatif oleh pihak pengelola
                            maupun masyarakat.
                        </p>
                        <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 20px;">
                            <span
                                style="background: #B83556; color: #fbebed; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">Laravel
                                12</span>
                            <span
                                style="background: #B83556; color: #fbebed; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">Leaflet.js</span>
                            <span
                                style="background: #B83556; color: #fbebed; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">PostGIS</span>
                        </div>
                    </div>
                    <a href="/tabel"
                        style="display: block; text-align: center; border: 2px solid #55768C; color: #55768C; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px; transition: all 0.3s;">
                        Lihat Tabel Data Spasial
                    </a>
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // 1. DIGITAL CLOCK & LIVE DATE SCRIPT (100% OTOMATIS)
        function startLiveDateTime() {
            const dateElement = document.getElementById('live-date');
            const clockElement = document.getElementById('live-clock');

            if (!dateElement || !clockElement) return;

            setInterval(() => {
                const now = new Date();
                const opsiTanggal = {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                };
                dateElement.innerText = now.toLocaleDateString('id-ID', opsiTanggal);

                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                clockElement.innerText = `${hours}:${minutes}:${seconds}`;
            }, 1000);
        }

        // 2. APEXCHARTS CONFIGURATION
        function initDonutChart() {
            const totalPolygon = parseInt("{{ $totalZona }}") || 0;
            const totalPoint = parseInt("{{ $totalPoint }}") || 0;
            const totalPolyline = parseInt("{{ $totalPolyline }}") || 0;

            const options = {
                chart: {
                    type: 'donut',
                    height: 250
                },
                series: [totalPolygon, totalPoint, totalPolyline],
                labels: ['Polygon (Lahan)', 'Point (Fasilitas)', 'Polyline (Jalan)'],
                colors: ['#55768C', '#B83556', '#DC97A5'],
                legend: {
                    position: 'bottom',
                    fontSize: '12px'
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return Math.round(val) + "%"
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#spatial-donut-chart"), options);
            chart.render();
        }

        // 3. LEAFLET MINI PETA INITIALIZATION
        function initMiniMap() {
            const map = L.map('mini-map', {
                zoomControl: true,
                scrollWheelZoom: false
            }).setView([-0.7399, 100.8000], 7);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const groupBounds = L.featureGroup();

            // Fetch Polygon
            fetch('/api/zona/geojson')
                .then(res => res.json())
                .then(data => {
                    if (data && data.features && data.features.length > 0) {
                        const layer = L.geoJSON(data, {
                            style: {
                                color: "#55768C",
                                weight: 2,
                                fillOpacity: 0.4
                            }
                        }).addTo(map);
                        groupBounds.addLayer(layer);
                        map.fitBounds(groupBounds.getBounds());
                    }
                }).catch(e => console.log(e));

            // Fetch Point
            fetch('/api/point/geojson')
                .then(res => res.json())
                .then(data => {
                    if (data && data.features && data.features.length > 0) {
                        const layer = L.geoJSON(data, {
                            pointToLayer: function(feature, latlng) {
                                return L.marker(latlng);
                            }
                        }).addTo(map);
                        groupBounds.addLayer(layer);
                        map.fitBounds(groupBounds.getBounds());
                    }
                }).catch(e => console.log(e));

            // Fetch Polyline
            fetch('/api/polyline/geojson')
                .then(res => res.json())
                .then(data => {
                    if (data && data.features && data.features.length > 0) {
                        const layer = L.geoJSON(data, {
                            style: {
                                color: "#B83556",
                                weight: 4,
                                opacity: 0.8
                            }
                        }).addTo(map);
                        groupBounds.addLayer(layer);
                        map.fitBounds(groupBounds.getBounds());
                    }
                }).catch(e => console.log(e));
        }

        // Jalankan seluruh fungsi bersamaan
        document.addEventListener('DOMContentLoaded', () => {
            startLiveDateTime();
            initDonutChart();
            initMiniMap();
        });
    </script>
@endsection
