@extends('layouts.app')

@section('content')
    <div style="padding:30px;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="color:#55768C;">Tabel Data Tata Ruang</h2>
            <a id="btn-buka-peta" href="/zona?tab=polygon"
                style="background:#B83556; color:white; padding:10px 20px; border-radius:6px; text-decoration:none; font-size:14px;">
                Buka Peta
            </a>
        </div>

        <!-- TAB -->
        <div style="display:flex; gap:5px; margin-bottom:20px;">
            <button onclick="setTab('polygon')" id="tab-polygon"
                style="padding:10px 20px; background:#B83556; color:white; border:none; border-radius:6px; cursor:pointer; font-size:14px;">
                Polygon ({{ count($zonas) }})
            </button>
            <button onclick="setTab('point')" id="tab-point"
                style="padding:10px 20px; background:#fbebed; color:#B83556; border:none; border-radius:6px; cursor:pointer; font-size:14px;">
                Point ({{ count($points) }})
            </button>
            <button onclick="setTab('polyline')" id="tab-polyline"
                style="padding:10px 20px; background:#fbebed; color:#B83556; border:none; border-radius:6px; cursor:pointer; font-size:14px;">
                Polyline ({{ count($polylines) }})
            </button>
        </div>

        <!-- TABEL POLYGON -->
        <div id="tabel-polygon">
            <div
                style="background:white; padding:15px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); margin-bottom:20px;">
                <label style="font-size:13px; color:#555; margin-right:10px;">Filter Jenis Zona:</label>
                <select id="filterJenis" onchange="filterTabel()"
                    style="padding:8px 12px; border:1px solid #ddd; border-radius:6px; font-size:13px;">
                    <option value="">-- Semua Jenis --</option>
                    <option value="Permukiman">Permukiman</option>
                    <option value="Perdagangan">Perdagangan & Jasa</option>
                    <option value="Industri">Industri</option>
                    <option value="Pertanian">Pertanian</option>
                    <option value="RTH">Ruang Terbuka Hijau</option>
                    <option value="Fasilitas Umum">Fasilitas Umum</option>
                    <option value="Kawasan Lindung">Kawasan Lindung</option>
                </select>
            </div>
            <div style="background:white; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); overflow:hidden;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#B83556; color:white;">
                            <th style="padding:12px 15px; text-align:left;">No</th>
                            <th style="padding:12px 15px; text-align:left;">Nama Zona</th>
                            <th style="padding:12px 15px; text-align:left;">Kode</th>
                            <th style="padding:12px 15px; text-align:left;">Jenis Zona</th>
                            <th style="padding:12px 15px; text-align:left;">Luas (Ha)</th>
                            <th style="padding:12px 15px; text-align:left;">Keterangan</th>
                            <th style="padding:12px 15px; text-align:left;">Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($zonas as $index => $zona)
                            <tr class="row-zona" data-jenis="{{ $zona->jenis_zona }}"
                                style="border-bottom:1px solid #eee; {{ $index % 2 == 0 ? 'background:#f9f9f9;' : 'background:white;' }}">
                                <td style="padding:12px 15px;">{{ $index + 1 }}</td>
                                <td style="padding:12px 15px; font-weight:bold;">{{ $zona->nama_zona }}</td>
                                <td style="padding:12px 15px;">{{ $zona->kode_zona }}</td>
                                <td style="padding:12px 15px;">
                                    <span
                                        style="display:inline-flex; align-items:center; gap:6px; min-width:150px; background:#f5f5f5; color:#333; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                                        <span
                                            style="width:10px; height:10px; border-radius:50%; background:{{ $zona->warna }}; border:1px solid rgba(0,0,0,0.1); flex-shrink:0;"></span>
                                        {{ $zona->jenis_zona }}
                                    </span>
                                </td>
                                <td style="padding:12px 15px; font-size:13px; color:#000;">
                                    {{ number_format($zona->luas_ha, 4, ',', '.') }} Ha
                                </td>
                                <td style="padding:12px 15px; color:#000; font-size:13px;">{{ $zona->keterangan ?? '-' }}
                                </td>
                                <td style="padding:12px 15px; font-size:13px; color:#000;">
                                    {{ \Carbon\Carbon::parse($zona->created_at)->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding:30px; text-align:center; color:#888;">Belum ada data zona.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:10px; color:#888; font-size:13px;">Total: <strong>{{ count($zonas) }}</strong> zona
            </div>
        </div>

        <!-- TABEL POINT -->
        <div id="tabel-point" style="display:none;">
            @php
                $pointColors = [
                    'Kantor Pemerintah' => '#1565c0',
                    'Rumah Sakit' => '#e53935',
                    'Sekolah' => '#f9a825',
                    'Terminal' => '#6d4c41',
                    'Bandara' => '#546e7a',
                    'Pasar' => '#fb8c00',
                    'Tempat Ibadah' => '#43a047',
                ];
            @endphp
            <div style="background:white; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); overflow:hidden;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#B83556; color:white;">
                            <th style="padding:12px 15px; text-align:left;">No</th>
                            <th style="padding:12px 15px; text-align:left;">Nama</th>
                            <th style="padding:12px 15px; text-align:left;">Kategori</th>
                            <th style="padding:12px 15px; text-align:left;">Koordinat</th>
                            <th style="padding:12px 15px; text-align:left;">Keterangan</th>
                            <th style="padding:12px 15px; text-align:left;">Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($points as $index => $point)
                            <tr
                                style="border-bottom:1px solid #eee; {{ $index % 2 == 0 ? 'background:#f9f9f9;' : 'background:white;' }}">
                                <td style="padding:12px 15px;">{{ $index + 1 }}</td>
                                <td style="padding:12px 15px; font-weight:bold;">{{ $point->nama }}</td>
                                <td style="padding:12px 15px;">
                                    <span
                                        style="display:inline-flex; align-items:center; gap:6px; min-width:150px; background:#f5f5f5; color:#333; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                                        <span
                                            style="width:10px; height:10px; border-radius:50%; background:{{ $pointColors[$point->kategori] ?? '#888' }}; border:1px solid rgba(0,0,0,0.1); flex-shrink:0;"></span>
                                        {{ $point->kategori }}
                                    </span>
                                </td>
                                <td style="padding:12px 15px; font-size:12px; color:#000;">
                                    {{ $point->lat }}, {{ $point->lng }}
                                </td>
                                <td style="padding:12px 15px; color:#000; font-size:13px;">{{ $point->keterangan ?? '-' }}
                                </td>
                                <td style="padding:12px 15px; font-size:13px; color:#000;">
                                    {{ \Carbon\Carbon::parse($point->created_at)->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding:30px; text-align:center; color:#888;">Belum ada data
                                    point.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:10px; color:#888; font-size:13px;">Total: <strong>{{ count($points) }}</strong> point
            </div>
        </div>

        <!-- TABEL POLYLINE -->
        <div id="tabel-polyline" style="display:none;">
            <div style="background:white; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); overflow:hidden;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#B83556; color:white;">
                            <th style="padding:12px 15px; text-align:left;">No</th>
                            <th style="padding:12px 15px; text-align:left;">Nama</th>
                            <th style="padding:12px 15px; text-align:left;">Kategori</th>
                            <th style="padding:12px 15px; text-align:left;">Panjang (km)</th>
                            <th style="padding:12px 15px; text-align:left;">Keterangan</th>
                            <th style="padding:12px 15px; text-align:left;">Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($polylines as $index => $polyline)
                            <tr
                                style="border-bottom:1px solid #eee; {{ $index % 2 == 0 ? 'background:#f9f9f9;' : 'background:white;' }}">
                                <td style="padding:12px 15px;">{{ $index + 1 }}</td>
                                <td style="padding:12px 15px; font-weight:bold;">{{ $polyline->nama }}</td>
                                <td style="padding:12px 15px;">
                                    <span
                                        style="display:inline-flex; align-items:center; gap:6px; min-width:150px; background:#f5f5f5; color:#333; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                                        <span
                                            style="width:10px; height:10px; border-radius:50%; background:{{ $polyline->warna }}; border:1px solid rgba(0,0,0,0.1); flex-shrink:0;"></span>
                                        {{ $polyline->kategori }}
                                    </span>
                                </td>
                                <td style="padding:12px 15px; font-size:13px; color:#000;">
                                    {{ number_format($polyline->panjang_km, 3, ',', '.') }} km
                                </td>
                                <td style="padding:12px 15px; color:#000; font-size:13px;">
                                    {{ $polyline->keterangan ?? '-' }}</td>
                                <td style="padding:12px 15px; font-size:13px; color:#000;">
                                    {{ \Carbon\Carbon::parse($polyline->created_at)->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding:30px; text-align:center; color:#888;">Belum ada data
                                    polyline.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:10px; color:#888; font-size:13px;">Total: <strong>{{ count($polylines) }}</strong>
                polyline</div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function setTab(tab) {
            document.getElementById('tabel-polygon').style.display = tab === 'polygon' ? 'block' : 'none';
            document.getElementById('tabel-point').style.display = tab === 'point' ? 'block' : 'none';
            document.getElementById('tabel-polyline').style.display = tab === 'polyline' ? 'block' : 'none';

            document.getElementById('tab-polygon').style.background = tab === 'polygon' ? '#B83556' : '#fbebed';
            document.getElementById('tab-polygon').style.color = tab === 'polygon' ? 'white' : '#B83556';
            document.getElementById('tab-point').style.background = tab === 'point' ? '#B83556' : '#fbebed';
            document.getElementById('tab-point').style.color = tab === 'point' ? 'white' : '#B83556';
            document.getElementById('tab-polyline').style.background = tab === 'polyline' ? '#B83556' : '#fbebed';
            document.getElementById('tab-polyline').style.color = tab === 'polyline' ? 'white' : '#B83556';

            // TAMBAHAN: update href tombol Buka Peta sesuai tab aktif
            document.getElementById('btn-buka-peta').href = '/zona?tab=' + tab;
        }

        function filterTabel() {
            var jenis = document.getElementById('filterJenis').value;
            document.querySelectorAll('.row-zona').forEach(function(row) {
                row.style.display = (jenis === '' || row.dataset.jenis === jenis) ? '' : 'none';
            });
        }
    </script>
@endpush
