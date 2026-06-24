@extends('layouts.app')

@section('content')
    <div style="display:flex; height:calc(100vh - 60px); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

        <div
            style="width:320px; background:#ffffff; padding:15px; overflow-y:auto; border-right:2px solid #e0e0e0; box-shadow: 2px 0 10px rgba(0,0,0,0.05);">

            <div style="display:flex; margin-bottom:15px; border-radius:8px; overflow:hidden; border:1px solid #DC97A5;">
                <button onclick="setTab('point')" id="tab-point"
                    style="flex:1; padding:10px 8px; background:#B83556; color:white; border:none; cursor:pointer; font-size:12px; font-weight:bold; display:flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="fa-solid fa-location-dot"></i> Point
                </button>
                <button onclick="setTab('polyline')" id="tab-polyline"
                    style="flex:1; padding:10px 8px; background:#fbebed; color:#55768C; border:none; cursor:pointer; font-size:12px; font-weight:bold; display:flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="fa-solid fa-route"></i> Polyline
                </button>
                <button onclick="setTab('polygon')" id="tab-polygon"
                    style="flex:1; padding:10px 8px; background:#fbebed; color:#55768C; border:none; cursor:pointer; font-size:12px; font-weight:bold; display:flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="fa-solid fa-draw-polygon"></i> Polygon
                </button>
            </div>

            <!-- FORM POINT -->
            <div id="form-point">
                <h3 style="color:#B83556; margin-top:0; margin-bottom:12px; font-size:18px; font-weight:700;">
                    <i class="fa-solid fa-location-dot"></i> Tambah Point
                </h3>
                <input type="text" id="point-nama" placeholder="Nama Fasilitas"
                    style="width:100%; padding:9px; margin-bottom:10px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;">
                <select id="point-kategori"
                    style="width:100%; padding:9px; margin-bottom:10px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; background:white;">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Kantor Pemerintah">Kantor Pemerintah</option>
                    <option value="Rumah Sakit">Rumah Sakit</option>
                    <option value="Sekolah">Sekolah</option>
                    <option value="Terminal">Terminal</option>
                    <option value="Bandara">Bandara</option>
                    <option value="Pasar">Pasar</option>
                    <option value="Tempat Ibadah">Tempat Ibadah</option>
                </select>
                <textarea id="point-keterangan" placeholder="Keterangan..." rows="3"
                    style="width:100%; padding:9px; margin-bottom:10px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; font-family:inherit;"></textarea>
                <div style="margin-bottom:12px;">
                    <label
                        style="font-size:13px; font-weight:600; color:#55768C; display:block; margin-bottom:5px;">Foto:</label>
                    <input type="file" id="point-foto" accept="image/*"
                        style="width:100%; padding:5px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;">
                    <!-- ===== TAMBAHAN: preview foto Point ===== -->
                    <img id="point-foto-preview" class="foto-preview" src="" alt="Preview foto">
                </div>
                <button onclick="simpanPoint()"
                    style="width:100%; padding:12px; background:#B83556; color:white; border:none; border-radius:6px; cursor:pointer; font-weight:bold; font-size:14px;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Point
                </button>
                <p style="font-size:11px; color:#666; text-align:center; margin-top:10px;">Klik titik di peta lalu isi form
                </p>
            </div>

            <!-- FORM POLYLINE -->
            <div id="form-polyline" style="display:none;">
                <h3 style="color:#B83556; margin-top:0; margin-bottom:12px; font-size:18px; font-weight:700;">
                    <i class="fa-solid fa-route"></i> Tambah Polyline
                </h3>
                <input type="text" id="polyline-nama" placeholder="Nama Jalan/Sungai"
                    style="width:100%; padding:9px; margin-bottom:10px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;">
                <select id="polyline-kategori"
                    style="width:100%; padding:9px; margin-bottom:10px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; background:white;">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Jalan Arteri">Jalan Arteri</option>
                    <option value="Jalan Kolektor">Jalan Kolektor</option>
                    <option value="Jalan Lokal">Jalan Lokal</option>
                    <option value="Sungai">Sungai</option>
                    <option value="Rel Kereta">Rel Kereta</option>
                </select>
                <div style="margin-bottom:10px;">
                    <label style="font-size:13px; font-weight:600; color:#55768C; display:block; margin-bottom:5px;">Warna
                        Garis:</label>
                    <input type="color" id="polyline-warna" value="#B83556"
                        style="width:100%; height:40px; border:1px solid #ccc; border-radius:6px; cursor:pointer;">
                </div>
                <textarea id="polyline-keterangan" placeholder="Keterangan..." rows="3"
                    style="width:100%; padding:9px; margin-bottom:10px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; font-family:inherit;"></textarea>
                <div style="margin-bottom:12px;">
                    <label
                        style="font-size:13px; font-weight:600; color:#55768C; display:block; margin-bottom:5px;">Foto:</label>
                    <input type="file" id="polyline-foto" accept="image/*"
                        style="width:100%; padding:5px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;">
                    <!-- ===== TAMBAHAN: preview foto Polyline ===== -->
                    <img id="polyline-foto-preview" class="foto-preview" src="" alt="Preview foto">
                </div>
                <button onclick="simpanPolyline()"
                    style="width:100%; padding:12px; background:#B83556; color:white; border:none; border-radius:6px; cursor:pointer; font-weight:bold; font-size:14px;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Polyline
                </button>
                <p style="font-size:11px; color:#666; text-align:center; margin-top:10px;">Gambar garis di peta lalu isi
                    form</p>
            </div>

            <!-- FORM POLYGON -->
            <div id="form-polygon" style="display:none;">
                <h3 style="color:#B83556; margin-top:0; margin-bottom:12px; font-size:18px; font-weight:700;">
                    <i class="fa-solid fa-draw-polygon"></i> Tambah Polygon
                </h3>
                <input type="text" id="zona-nama" placeholder="Nama Zona"
                    style="width:100%; padding:9px; margin-bottom:10px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;">
                <input type="text" id="zona-kode" placeholder="Kode Zona (contoh: R-2)"
                    style="width:100%; padding:9px; margin-bottom:10px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;">
                <select id="zona-jenis"
                    style="width:100%; padding:9px; margin-bottom:10px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; background:white;">
                    <option value="">-- Pilih Jenis Zona --</option>
                    <option value="Permukiman">Permukiman</option>
                    <option value="Perdagangan">Perdagangan dan Jasa</option>
                    <option value="Industri">Industri</option>
                    <option value="Pertanian">Pertanian</option>
                    <option value="RTH">Ruang Terbuka Hijau</option>
                    <option value="Fasilitas Umum">Fasilitas Umum</option>
                    <option value="Kawasan Lindung">Kawasan Lindung</option>
                </select>
                <div style="margin-bottom:10px;">
                    <label style="font-size:13px; font-weight:600; color:#55768C; display:block; margin-bottom:5px;">Warna
                        Zona:</label>
                    <input type="color" id="zona-warna" value="#55768C"
                        style="width:100%; height:40px; border:1px solid #ccc; border-radius:6px; cursor:pointer;">
                </div>
                <textarea id="zona-keterangan" placeholder="Keterangan..." rows="3"
                    style="width:100%; padding:9px; margin-bottom:10px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; font-family:inherit;"></textarea>
                <div style="margin-bottom:12px;">
                    <label
                        style="font-size:13px; font-weight:600; color:#55768C; display:block; margin-bottom:5px;">Foto:</label>
                    <input type="file" id="zona-foto" accept="image/*"
                        style="width:100%; padding:5px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;">
                    <!-- ===== TAMBAHAN: preview foto Zona ===== -->
                    <img id="zona-foto-preview" class="foto-preview" src="" alt="Preview foto">
                </div>
                <button onclick="simpanZona()"
                    style="width:100%; padding:12px; background:#B83556; color:white; border:none; border-radius:6px; cursor:pointer; font-weight:bold; font-size:14px;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Zona
                </button>
                <p style="font-size:11px; color:#666; text-align:center; margin-top:10px;">Gambar polygon di peta lalu isi
                    form</p>
            </div>

        </div>

        <div id="map" style="flex:1;"></div>
    </div>

    <style>
        .leaflet-popup-content-wrapper {
            background: #fbebed !important;
            border-radius: 10px;
        }

        .leaflet-popup-tip {
            background: #fbebed !important;
        }

        .legenda-peta {
            background: rgba(255, 255, 255, 0.95);
            padding: 12px 14px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            max-height: 320px;
            overflow-y: auto;
            max-width: 200px;
        }

        .legenda-peta h4 {
            margin: 0 0 8px 0;
            font-size: 13px;
            color: #B83556;
            font-weight: 700;
            border-bottom: 1px solid #eee;
            padding-bottom: 6px;
        }

        .legenda-peta .legenda-section {
            margin-bottom: 10px;
        }

        .legenda-peta .legenda-section-title {
            font-weight: 600;
            color: #55768C;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .legenda-item {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 3px;
        }

        .legenda-swatch-line {
            width: 18px;
            height: 3px;
            border-radius: 2px;
            flex-shrink: 0;
        }

        .legenda-swatch-box {
            width: 13px;
            height: 13px;
            border-radius: 3px;
            flex-shrink: 0;
            border: 1px solid rgba(0, 0, 0, 0.15);
        }

        .legenda-swatch-dot {
            width: 13px;
            height: 13px;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== TAMBAHAN: style preview foto saat dipilih (sebelum disimpan) ===== */
        .foto-preview {
            display: none;
            width: 100%;
            max-height: 160px;
            object-fit: cover;
            border-radius: 6px;
            margin-top: 8px;
            border: 1px solid #ddd;
        }
    </style>

    <!-- MODAL EDIT -->
    <div id="edit-modal-overlay"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div
            style="background:white; width:380px; max-height:90vh; overflow-y:auto; border-radius:10px; padding:20px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
            <h3 id="edit-modal-title"
                style="color:#B83556; margin-top:0; margin-bottom:15px; font-size:18px; font-weight:700;">
                <i class="fa-solid fa-pen-to-square"></i> Edit Data
            </h3>
            <div id="edit-kode-wrapper" style="display:none; margin-bottom:10px;">
                <label style="font-size:13px; font-weight:600; color:#55768C; display:block; margin-bottom:5px;">Kode
                    Zona:</label>
                <input type="text" id="edit-kode" placeholder="Kode Zona (contoh: R-2)"
                    style="width:100%; padding:9px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:10px;">
                <label style="font-size:13px; font-weight:600; color:#55768C; display:block; margin-bottom:5px;"
                    id="edit-nama-label">Nama:</label>
                <input type="text" id="edit-nama" placeholder="Nama"
                    style="width:100%; padding:9px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:10px;">
                <label style="font-size:13px; font-weight:600; color:#55768C; display:block; margin-bottom:5px;"
                    id="edit-kategori-label">Kategori:</label>
                <select id="edit-kategori"
                    style="width:100%; padding:9px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; background:white;"></select>
            </div>
            <div id="edit-warna-wrapper" style="display:none; margin-bottom:10px;">
                <label
                    style="font-size:13px; font-weight:600; color:#55768C; display:block; margin-bottom:5px;">Warna:</label>
                <input type="color" id="edit-warna" value="#B83556"
                    style="width:100%; height:40px; border:1px solid #ccc; border-radius:6px; cursor:pointer;">
            </div>
            <div style="margin-bottom:10px;">
                <label
                    style="font-size:13px; font-weight:600; color:#55768C; display:block; margin-bottom:5px;">Keterangan:</label>
                <textarea id="edit-keterangan" placeholder="Keterangan..." rows="3"
                    style="width:100%; padding:9px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box; font-family:inherit;"></textarea>
            </div>
            <div style="margin-bottom:8px;">
                <label style="font-size:13px; font-weight:600; color:#55768C; display:block; margin-bottom:5px;">Foto saat
                    ini:</label>
                <img id="edit-foto-preview" src=""
                    style="display:none; width:100%; max-height:140px; object-fit:cover; border-radius:6px; margin-bottom:8px;">
                <p id="edit-foto-kosong" style="font-size:12px; color:#999; margin:0 0 8px 0;">Belum ada foto</p>
            </div>
            <div style="margin-bottom:15px;">
                <label style="font-size:13px; font-weight:600; color:#55768C; display:block; margin-bottom:5px;">Ganti Foto
                    (opsional):</label>
                <input type="file" id="edit-foto" accept="image/*"
                    style="width:100%; padding:5px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;">
                <p style="font-size:11px; color:#666; margin:5px 0 0 0;">Kosongkan jika tidak ingin mengganti foto.</p>
            </div>
            <div style="display:flex; gap:8px;">
                <button onclick="tutupEditModal()"
                    style="flex:1; padding:11px; background:#e0e0e0; color:#333; border:none; border-radius:6px; cursor:pointer; font-weight:bold; font-size:14px;">
                    Batal
                </button>
                <button onclick="simpanEdit()"
                    style="flex:1; padding:11px; background:#B83556; color:white; border:none; border-radius:6px; cursor:pointer; font-weight:bold; font-size:14px;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL HASIL SPATIAL QUERY (Fasilitas dalam Zona) -->
    <div id="fasilitas-modal-overlay"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div
            style="background:white; width:380px; max-height:80vh; overflow-y:auto; border-radius:10px; padding:20px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
            <h3 id="fasilitas-modal-title"
                style="color:#B83556; margin-top:0; margin-bottom:5px; font-size:18px; font-weight:700;">
                <i class="fa-solid fa-magnifying-glass-location"></i> Fasilitas dalam Zona
            </h3>
            <p id="fasilitas-modal-subtitle" style="font-size:13px; color:#666; margin-top:0; margin-bottom:15px;"></p>
            <div id="fasilitas-modal-content"></div>
            <button onclick="tutupModalFasilitas()"
                style="width:100%; padding:11px; background:#e0e0e0; color:#333; border:none; border-radius:6px; cursor:pointer; font-weight:bold; font-size:14px; margin-top:10px;">
                Tutup
            </button>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
    <script>
        var map = L.map('map').setView([-0.8923788, 100.354286], 12);

        var googleHybrid = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            attribution: '© Google Hybrid'
        });
        var googleSatellite = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            attribution: '© Google Satellite'
        });
        var googleStreet = L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            attribution: '© Google Street'
        });
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        });
        var esriSatellite = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: '© Esri World Imagery'
            });

        googleHybrid.addTo(map);

        var baseMaps = {
            "Google Hybrid": googleHybrid,
            "Google Satellite": googleSatellite,
            "Google Street": googleStreet,
            "OpenStreetMap": osm,
            "Esri Satellite": esriSatellite,
        };

        var layerPoint = L.featureGroup().addTo(map);
        var layerPolyline = L.featureGroup();
        var layerZona = L.featureGroup();

        var layerBatasWilayah = L.featureGroup().addTo(map);

        var overlayMaps = {
            "Batas Kota Padang": layerBatasWilayah
        };
        L.control.layers(baseMaps, overlayMaps, {
            position: 'topright',
            collapsed: true
        }).addTo(map);

        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var activeTab = 'point';
        var currentLayer = null;

        var drawControl = new L.Control.Draw({
            edit: false,
            draw: {
                marker: true,
                polyline: false,
                polygon: false,
                rectangle: false,
                circle: false,
                circlemarker: false
            }
        });
        map.addControl(drawControl);

        var WARNA_POLYLINE = {
            'Jalan Arteri': '#000000',
            'Jalan Kolektor': '#e53935',
            'Jalan Lokal': '#fdd835',
            'Sungai': '#1565c0',
            'Rel Kereta': '#424242',
        };

        var WARNA_ZONA = {
            'Permukiman': '#fb8c00',
            'Perdagangan': '#e53935',
            'Industri': '#6d4c41',
            'Pertanian': '#9ccc65',
            'RTH': '#2e7d32',
            'Fasilitas Umum': '#1565c0',
            'Kawasan Lindung': '#4527a0',
        };

        document.getElementById('polyline-kategori').addEventListener('change', function() {
            var warnaDefault = WARNA_POLYLINE[this.value];
            if (warnaDefault) document.getElementById('polyline-warna').value = warnaDefault;
        });

        document.getElementById('zona-jenis').addEventListener('change', function() {
            var warnaDefault = WARNA_ZONA[this.value];
            if (warnaDefault) document.getElementById('zona-warna').value = warnaDefault;
        });

        // ===== TAMBAHAN: function generik untuk preview foto sebelum disimpan =====
        function previewFoto(inputEl, imgEl) {
            var file = inputEl.files[0];
            if (!file) {
                imgEl.style.display = 'none';
                imgEl.src = '';
                return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                imgEl.src = e.target.result;
                imgEl.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        // ===== TAMBAHAN: pasang event listener preview ke tiap input foto =====
        document.getElementById('point-foto').addEventListener('change', function() {
            previewFoto(this, document.getElementById('point-foto-preview'));
        });
        document.getElementById('polyline-foto').addEventListener('change', function() {
            previewFoto(this, document.getElementById('polyline-foto-preview'));
        });
        document.getElementById('zona-foto').addEventListener('change', function() {
            previewFoto(this, document.getElementById('zona-foto-preview'));
        });
        document.getElementById('edit-foto').addEventListener('change', function() {
            // Saat ganti foto di modal Edit, tampilkan preview file baru menimpa foto lama sementara
            previewFoto(this, document.getElementById('edit-foto-preview'));
            document.getElementById('edit-foto-kosong').style.display = 'none';
        });

        function setTab(tab) {
            activeTab = tab;
            document.getElementById('form-point').style.display = tab === 'point' ? 'block' : 'none';
            document.getElementById('form-polyline').style.display = tab === 'polyline' ? 'block' : 'none';
            document.getElementById('form-polygon').style.display = tab === 'polygon' ? 'block' : 'none';

            document.getElementById('tab-point').style.background = tab === 'point' ? '#B83556' : '#fbebed';
            document.getElementById('tab-point').style.color = tab === 'point' ? 'white' : '#55768C';
            document.getElementById('tab-polyline').style.background = tab === 'polyline' ? '#B83556' : '#fbebed';
            document.getElementById('tab-polyline').style.color = tab === 'polyline' ? 'white' : '#55768C';
            document.getElementById('tab-polygon').style.background = tab === 'polygon' ? '#B83556' : '#fbebed';
            document.getElementById('tab-polygon').style.color = tab === 'polygon' ? 'white' : '#55768C';

            if (tab === 'point') {
                layerPoint.addTo(map);
                if (map.hasLayer(layerPolyline)) map.removeLayer(layerPolyline);
                if (map.hasLayer(layerZona)) map.removeLayer(layerZona);
            } else if (tab === 'polyline') {
                layerPolyline.addTo(map);
                if (map.hasLayer(layerPoint)) map.removeLayer(layerPoint);
                if (map.hasLayer(layerZona)) map.removeLayer(layerZona);
            } else if (tab === 'polygon') {
                layerZona.addTo(map);
                if (map.hasLayer(layerPoint)) map.removeLayer(layerPoint);
                if (map.hasLayer(layerPolyline)) map.removeLayer(layerPolyline);
            }

            map.removeControl(drawControl);
            drawControl = new L.Control.Draw({
                edit: false,
                draw: {
                    marker: tab === 'point',
                    polyline: tab === 'polyline',
                    polygon: tab === 'polygon',
                    rectangle: tab === 'polygon',
                    circle: false,
                    circlemarker: false
                }
            });
            map.addControl(drawControl);
            drawnItems.clearLayers();
            currentLayer = null;

            updateLegenda();
        }

        map.on(L.Draw.Event.CREATED, function(e) {
            drawnItems.clearLayers();
            currentLayer = e.layer;
            drawnItems.addLayer(currentLayer);
        });

        function simpanPoint() {
            if (!currentLayer) {
                alert('Klik titik di peta terlebih dahulu!');
                return;
            }
            var nama = document.getElementById('point-nama').value;
            var kategori = document.getElementById('point-kategori').value;
            var keterangan = document.getElementById('point-keterangan').value;
            if (!nama || !kategori) {
                alert('Nama dan Kategori wajib diisi!');
                return;
            }
            var formData = new FormData();
            formData.append('nama', nama);
            formData.append('kategori', kategori);
            formData.append('keterangan', keterangan);
            formData.append('geojson', JSON.stringify(currentLayer.toGeoJSON().geometry));
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            var foto = document.getElementById('point-foto').files[0];
            if (foto) formData.append('foto', foto);
            fetch('/api/point', {
                method: 'POST',
                body: formData
            }).then(r => r.json()).then(d => {
                alert(d.message);
                drawnItems.clearLayers();
                currentLayer = null;
                document.getElementById('point-nama').value = '';
                document.getElementById('point-keterangan').value = '';
                document.getElementById('point-foto').value = '';
                // ===== TAMBAHAN: reset preview setelah berhasil simpan =====
                document.getElementById('point-foto-preview').style.display = 'none';
                document.getElementById('point-foto-preview').src = '';
                loadAllLayers();
            });
        }

        function simpanPolyline() {
            if (!currentLayer) {
                alert('Gambar garis di peta terlebih dahulu!');
                return;
            }
            var nama = document.getElementById('polyline-nama').value;
            var kategori = document.getElementById('polyline-kategori').value;
            var warna = document.getElementById('polyline-warna').value;
            var keterangan = document.getElementById('polyline-keterangan').value;
            if (!nama || !kategori) {
                alert('Nama dan Kategori wajib diisi!');
                return;
            }
            var formData = new FormData();
            formData.append('nama', nama);
            formData.append('kategori', kategori);
            formData.append('warna', warna);
            formData.append('keterangan', keterangan);
            formData.append('geojson', JSON.stringify(currentLayer.toGeoJSON().geometry));
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            var foto = document.getElementById('polyline-foto').files[0];
            if (foto) formData.append('foto', foto);
            fetch('/api/polyline', {
                method: 'POST',
                body: formData
            }).then(r => r.json()).then(d => {
                alert(d.message);
                drawnItems.clearLayers();
                currentLayer = null;
                document.getElementById('polyline-nama').value = '';
                document.getElementById('polyline-keterangan').value = '';
                document.getElementById('polyline-foto').value = '';
                // ===== TAMBAHAN: reset preview setelah berhasil simpan =====
                document.getElementById('polyline-foto-preview').style.display = 'none';
                document.getElementById('polyline-foto-preview').src = '';
                loadAllLayers();
            });
        }

        function simpanZona() {
            if (!currentLayer) {
                alert('Gambar polygon di peta terlebih dahulu!');
                return;
            }
            var nama = document.getElementById('zona-nama').value;
            var kode = document.getElementById('zona-kode').value;
            var jenis = document.getElementById('zona-jenis').value;
            var warna = document.getElementById('zona-warna').value;
            var keterangan = document.getElementById('zona-keterangan').value;
            if (!nama || !kode || !jenis) {
                alert('Nama, Kode, dan Jenis wajib diisi!');
                return;
            }
            var formData = new FormData();
            formData.append('nama_zona', nama);
            formData.append('kode_zona', kode);
            formData.append('jenis_zona', jenis);
            formData.append('warna', warna);
            formData.append('keterangan', keterangan);
            formData.append('geojson', JSON.stringify(currentLayer.toGeoJSON().geometry));
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            var foto = document.getElementById('zona-foto').files[0];
            if (foto) formData.append('foto', foto);
            fetch('/api/zona', {
                method: 'POST',
                body: formData
            }).then(r => r.json()).then(d => {
                alert(d.message);
                drawnItems.clearLayers();
                currentLayer = null;
                document.getElementById('zona-nama').value = '';
                document.getElementById('zona-kode').value = '';
                document.getElementById('zona-keterangan').value = '';
                document.getElementById('zona-foto').value = '';
                // ===== TAMBAHAN: reset preview setelah berhasil simpan =====
                document.getElementById('zona-foto-preview').style.display = 'none';
                document.getElementById('zona-foto-preview').src = '';
                loadAllLayers();
            });
        }

        function hapusData(tipe, id) {
            if (!confirm('Yakin ingin menghapus data ini?')) return;
            fetch('/api/' + tipe + '/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(r => r.json()).then(d => {
                alert(d.message);
                map.closePopup();
                loadAllLayers();
            });
        }

        var KATEGORI_OPTIONS = {
            point: ['Kantor Pemerintah', 'Rumah Sakit', 'Sekolah', 'Terminal', 'Bandara', 'Pasar', 'Tempat Ibadah'],
            polyline: ['Jalan Arteri', 'Jalan Kolektor', 'Jalan Lokal', 'Sungai', 'Rel Kereta'],
            polygon: ['Permukiman', 'Perdagangan', 'Industri', 'Pertanian', 'RTH', 'Fasilitas Umum', 'Kawasan Lindung']
        };

        var JENIS_ZONA_LABEL = {
            'Permukiman': 'Permukiman',
            'Perdagangan': 'Perdagangan dan Jasa',
            'Industri': 'Industri',
            'Pertanian': 'Pertanian',
            'RTH': 'Ruang Terbuka Hijau',
            'Fasilitas Umum': 'Fasilitas Umum',
            'Kawasan Lindung': 'Kawasan Lindung'
        };

        var editTarget = {
            tipe: null,
            id: null
        };

        function bukaEditModal(tipe, props) {
            editTarget.tipe = tipe;
            editTarget.id = props.id;
            var titleMap = {
                point: '<i class="fa-solid fa-location-dot"></i> Edit Point',
                polyline: '<i class="fa-solid fa-route"></i> Edit Polyline',
                polygon: '<i class="fa-solid fa-draw-polygon"></i> Edit Zona'
            };
            document.getElementById('edit-modal-title').innerHTML = titleMap[tipe];
            var select = document.getElementById('edit-kategori');
            select.innerHTML = '';
            KATEGORI_OPTIONS[tipe].forEach(function(val) {
                var opt = document.createElement('option');
                opt.value = val;
                opt.textContent = (tipe === 'polygon' && JENIS_ZONA_LABEL[val]) ? JENIS_ZONA_LABEL[val] : val;
                select.appendChild(opt);
            });
            document.getElementById('edit-kode-wrapper').style.display = (tipe === 'polygon') ? 'block' : 'none';
            document.getElementById('edit-warna-wrapper').style.display = (tipe === 'polyline' || tipe === 'polygon') ?
                'block' : 'none';
            if (tipe === 'polygon') {
                document.getElementById('edit-nama-label').textContent = 'Nama Zona:';
                document.getElementById('edit-kategori-label').textContent = 'Jenis Zona:';
                document.getElementById('edit-nama').value = props.nama_zona || '';
                document.getElementById('edit-kode').value = props.kode_zona || '';
                select.value = props.jenis_zona || '';
                document.getElementById('edit-warna').value = props.warna || '#55768C';
            } else if (tipe === 'polyline') {
                document.getElementById('edit-nama-label').textContent = 'Nama Jalan/Sungai:';
                document.getElementById('edit-kategori-label').textContent = 'Kategori:';
                document.getElementById('edit-nama').value = props.nama || '';
                select.value = props.kategori || '';
                document.getElementById('edit-warna').value = props.warna || '#B83556';
            } else {
                document.getElementById('edit-nama-label').textContent = 'Nama Fasilitas:';
                document.getElementById('edit-kategori-label').textContent = 'Kategori:';
                document.getElementById('edit-nama').value = props.nama || '';
                select.value = props.kategori || '';
            }
            document.getElementById('edit-keterangan').value = props.keterangan || '';
            var preview = document.getElementById('edit-foto-preview');
            var kosong = document.getElementById('edit-foto-kosong');
            if (props.foto) {
                preview.src = '/storage/images/' + props.foto;
                preview.style.display = 'block';
                kosong.style.display = 'none';
            } else {
                preview.style.display = 'none';
                kosong.style.display = 'block';
            }
            document.getElementById('edit-foto').value = '';
            select.onchange = function() {
                var warnaDefault = (editTarget.tipe === 'polygon') ? WARNA_ZONA[this.value] : WARNA_POLYLINE[this
                    .value];
                if (warnaDefault) document.getElementById('edit-warna').value = warnaDefault;
            };
            map.closePopup();
            document.getElementById('edit-modal-overlay').style.display = 'flex';
        }

        function tutupEditModal() {
            document.getElementById('edit-modal-overlay').style.display = 'none';
            editTarget = {
                tipe: null,
                id: null
            };
        }

        function simpanEdit() {
            if (!editTarget.id) return;
            var nama = document.getElementById('edit-nama').value;
            var kategori = document.getElementById('edit-kategori').value;
            var keterangan = document.getElementById('edit-keterangan').value;
            var foto = document.getElementById('edit-foto').files[0];
            if (!nama || !kategori) {
                alert('Nama dan Kategori wajib diisi!');
                return;
            }
            var formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('keterangan', keterangan);
            if (foto) formData.append('foto', foto);
            var endpoint = '';
            if (editTarget.tipe === 'polygon') {
                var kode = document.getElementById('edit-kode').value;
                var warna = document.getElementById('edit-warna').value;
                if (!kode) {
                    alert('Kode Zona wajib diisi!');
                    return;
                }
                formData.append('nama_zona', nama);
                formData.append('kode_zona', kode);
                formData.append('jenis_zona', kategori);
                formData.append('warna', warna);
                endpoint = '/api/zona/' + editTarget.id;
            } else if (editTarget.tipe === 'polyline') {
                var warnaLine = document.getElementById('edit-warna').value;
                formData.append('nama', nama);
                formData.append('kategori', kategori);
                formData.append('warna', warnaLine);
                endpoint = '/api/polyline/' + editTarget.id;
            } else {
                formData.append('nama', nama);
                formData.append('kategori', kategori);
                endpoint = '/api/point/' + editTarget.id;
            }
            fetch(endpoint, {
                method: 'POST',
                body: formData
            }).then(r => r.json()).then(d => {
                alert(d.message);
                tutupEditModal();
                loadAllLayers();
            }).catch(function() {
                alert('Terjadi kesalahan saat menyimpan perubahan.');
            });
        }

        function makePopupPoint(props) {
            var fotoHtml = props.foto ?
                `<img src="/storage/images/${props.foto}" style="width:100%; border-radius:6px; margin-bottom:10px; max-height:150px; object-fit:cover;">` :
                '';
            return `
            <div style="min-width:220px; font-family:'Segoe UI',sans-serif; padding:5px;">
                <div style="font-weight:bold; font-size:15px; color:#333; margin-bottom:8px;">${props.nama}</div>
                ${fotoHtml}
                <div style="font-size:13px; color:#555; margin-bottom:4px;">Kategori: ${props.kategori}</div>
                <div style="font-size:13px; color:#555; margin-bottom:12px;">Keterangan: ${props.keterangan || '-'}</div>
                <div style="display:flex; gap:8px;">
                    <button onclick='bukaEditModal("point", ${JSON.stringify(props)})'
                        style="flex:1; padding:8px; background:#55768C; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px;">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <button onclick="hapusData('point', ${props.id})"
                        style="flex:1; padding:8px; background:#B83556; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px;">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </div>
            </div>`;
        }

        function makePopupPolyline(props) {
            var fotoHtml = props.foto ?
                `<img src="/storage/images/${props.foto}" style="width:100%; border-radius:6px; margin-bottom:10px; max-height:150px; object-fit:cover;">` :
                '';
            return `
            <div style="min-width:220px; font-family:'Segoe UI',sans-serif; padding:5px;">
                <div style="font-weight:bold; font-size:15px; color:#333; margin-bottom:8px;">${props.nama}</div>
                ${fotoHtml}
                <div style="font-size:13px; color:#555; margin-bottom:4px;">Kategori: ${props.kategori}</div>
                <div style="font-size:13px; color:#555; margin-bottom:4px;">Panjang: ${props.panjang_km} km (${props.panjang_m.toLocaleString('id-ID')} m)</div>
                <div style="font-size:13px; color:#555; margin-bottom:12px;">Keterangan: ${props.keterangan || '-'}</div>
                <div style="display:flex; gap:8px;">
                    <button onclick='bukaEditModal("polyline", ${JSON.stringify(props)})'
                        style="flex:1; padding:8px; background:#55768C; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px;">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <button onclick="hapusData('polyline', ${props.id})"
                        style="flex:1; padding:8px; background:#B83556; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px;">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </div>
            </div>`;
        }

        function makePopupZona(props) {
            var fotoHtml = props.foto ?
                `<img src="/storage/images/${props.foto}" style="width:100%; border-radius:6px; margin-bottom:10px; max-height:150px; object-fit:cover;">` :
                '';
            return `
            <div style="min-width:220px; font-family:'Segoe UI',sans-serif; padding:5px;">
                <div style="font-weight:bold; font-size:15px; color:#333; margin-bottom:8px;">${props.nama_zona}</div>
                ${fotoHtml}
                <div style="font-size:13px; color:#555; margin-bottom:4px;">Kategori: ${props.jenis_zona}</div>
                <div style="font-size:13px; color:#555; margin-bottom:4px;">Kode: ${props.kode_zona}</div>
                <div style="font-size:13px; color:#555; margin-bottom:4px;">Luas: ${props.luas_ha} Ha (${props.luas_m2.toLocaleString('id-ID')} m²)</div>
                <div style="font-size:13px; color:#555; margin-bottom:4px;">Keliling: ${props.keliling_m.toLocaleString('id-ID')} m</div>
                <div style="font-size:13px; color:#555; margin-bottom:12px;">Keterangan: ${props.keterangan || '-'}</div>
                <button onclick="cekFasilitasDalamZona(${props.id}, '${(props.nama_zona || '').replace(/'/g, "\\'")}')"
                    style="width:100%; padding:8px; margin-bottom:8px; background:#2e7d32; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px;">
                    <i class="fa-solid fa-magnifying-glass-location"></i> Cek Fasilitas dalam Zona
                </button>
                <div style="display:flex; gap:8px;">
                    <button onclick='bukaEditModal("polygon", ${JSON.stringify(props)})'
                        style="flex:1; padding:8px; background:#55768C; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px;">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <button onclick="hapusData('zona', ${props.id})"
                        style="flex:1; padding:8px; background:#B83556; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px;">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </div>
            </div>`;
        }

        function getPointIcon(kategori) {
            const icons = {
                'Kantor Pemerintah': {
                    color: '#1565c0',
                    iconClass: 'fa-solid fa-building-columns'
                },
                'Rumah Sakit': {
                    color: '#e53935',
                    iconClass: 'fa-solid fa-hospital'
                },
                'Sekolah': {
                    color: '#f9a825',
                    iconClass: 'fa-solid fa-school'
                },
                'Terminal': {
                    color: '#6d4c41',
                    iconClass: 'fa-solid fa-bus'
                },
                'Bandara': {
                    color: '#546e7a',
                    iconClass: 'fa-solid fa-plane'
                },
                'Pasar': {
                    color: '#fb8c00',
                    iconClass: 'fa-solid fa-cart-shopping'
                },
                'Tempat Ibadah': {
                    color: '#43a047',
                    iconClass: 'fa-solid fa-place-of-worship'
                },
            };
            return icons[kategori] || {
                color: '#888',
                iconClass: 'fa-solid fa-location-dot'
            };
        }

        function loadAllLayers() {
            layerPoint.clearLayers();
            layerPolyline.clearLayers();
            layerZona.clearLayers();

            fetch('/api/point/geojson').then(r => r.json()).then(data => {
                data.features.forEach(function(f) {
                    var info = getPointIcon(f.properties.kategori);
                    var icon = L.divIcon({
                        html: `<div style="background:${info.color}; width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; color:white; border:2px solid white; box-shadow:0 2px 5px rgba(0,0,0,0.3);"><i class="${info.iconClass}"></i></div>`,
                        className: '',
                        iconSize: [32, 32],
                        iconAnchor: [16, 16]
                    });
                    L.geoJSON(f, {
                        pointToLayer: function(feature, latlng) {
                            return L.marker(latlng, {
                                icon: icon
                            });
                        }
                    }).bindPopup(makePopupPoint(f.properties), {
                        maxWidth: 250
                    }).addTo(layerPoint);
                });
            });

            fetch('/api/polyline/geojson').then(r => r.json()).then(data => {
                data.features.forEach(function(f) {
                    L.geoJSON(f, {
                        style: {
                            color: f.properties.warna,
                            weight: 3
                        }
                    }).bindPopup(makePopupPolyline(f.properties), {
                        maxWidth: 250
                    }).addTo(layerPolyline);
                });
            });

            fetch('/api/zona/geojson').then(r => r.json()).then(data => {
                data.features.forEach(function(f) {
                    L.geoJSON(f, {
                        style: {
                            color: f.properties.warna,
                            fillColor: f.properties.warna,
                            fillOpacity: 0.4,
                            weight: 2
                        }
                    }).bindPopup(makePopupZona(f.properties), {
                        maxWidth: 250
                    }).addTo(layerZona);
                });
            });
        }

        function loadBatasWilayah() {
            fetch('/geojson/batas_kota_padang.geojson')
                .then(r => r.json())
                .then(data => {
                    L.geoJSON(data, {
                        style: {
                            color: '#e63946',
                            weight: 2.5,
                            fillOpacity: 0,
                            dashArray: '6, 4'
                        },
                        onEachFeature: function(feature, layer) {
                            var p = feature.properties;
                            layer.bindPopup(
                                `<div style="font-family:'Segoe UI',sans-serif;"><strong>${p.nama}</strong><br>Provinsi: ${p.provinsi}</div>`
                            );
                        }
                    }).addTo(layerBatasWilayah);
                })
                .catch(function(err) {
                    console.error('Gagal memuat batas wilayah:', err);
                });
        }

        var legendaControl = L.control({
            position: 'bottomleft'
        });

        legendaControl.onAdd = function() {
            var div = L.DomUtil.create('div', 'legenda-peta');
            div.id = 'legenda-content';
            return div;
        };

        legendaControl.addTo(map);

        function updateLegenda() {
            var container = document.getElementById('legenda-content');
            if (!container) return;

            var html = '';

            if (activeTab === 'point') {
                html += '<h4><i class="fa-solid fa-location-dot"></i> Legenda Point</h4>';
                html += '<div class="legenda-section">';
                Object.keys(KATEGORI_OPTIONS.point).forEach(function(idx) {
                    var kategori = KATEGORI_OPTIONS.point[idx];
                    var info = getPointIcon(kategori);
                    html += '<div class="legenda-item">' +
                        '<div class="legenda-swatch-dot" style="background:' + info.color + ';">' +
                        '<i class="' + info.iconClass + '" style="font-size:8px; color:white;"></i></div>' +
                        '<span>' + kategori + '</span></div>';
                });
                html += '</div>';
            } else if (activeTab === 'polyline') {
                html += '<h4><i class="fa-solid fa-route"></i> Legenda Polyline</h4>';
                html += '<div class="legenda-section">';
                Object.keys(WARNA_POLYLINE).forEach(function(kategori) {
                    html += '<div class="legenda-item">' +
                        '<div class="legenda-swatch-line" style="background:' + WARNA_POLYLINE[kategori] +
                        ';"></div>' +
                        '<span>' + kategori + '</span></div>';
                });
                html += '</div>';
            } else if (activeTab === 'polygon') {
                html += '<h4><i class="fa-solid fa-draw-polygon"></i> Legenda Zona</h4>';
                html += '<div class="legenda-section">';
                Object.keys(WARNA_ZONA).forEach(function(jenis) {
                    var label = JENIS_ZONA_LABEL[jenis] || jenis;
                    html += '<div class="legenda-item">' +
                        '<div class="legenda-swatch-box" style="background:' + WARNA_ZONA[jenis] + ';"></div>' +
                        '<span>' + label + '</span></div>';
                });
                html += '</div>';
            }

            html += '<div class="legenda-section" style="margin-top:8px; padding-top:8px; border-top:1px solid #eee;">' +
                '<div class="legenda-section-title">Batas Administrasi</div>' +
                '<div class="legenda-item">' +
                '<div class="legenda-swatch-line" style="background:#e63946; border-top:2px dashed #e63946; height:0;"></div>' +
                '<span>Batas Kota Padang</span></div>' +
                '</div>';

            container.innerHTML = html;
        }

        function cekFasilitasDalamZona(zonaId, zonaNama) {
            map.closePopup();
            document.getElementById('fasilitas-modal-title').innerHTML =
                '<i class="fa-solid fa-magnifying-glass-location"></i> Fasilitas dalam Zona';
            document.getElementById('fasilitas-modal-subtitle').textContent = 'Memuat data...';
            document.getElementById('fasilitas-modal-content').innerHTML = '';
            document.getElementById('fasilitas-modal-overlay').style.display = 'flex';

            fetch('/api/zona/' + zonaId + '/fasilitas')
                .then(r => r.json())
                .then(data => {
                    document.getElementById('fasilitas-modal-subtitle').textContent =
                        'Zona: ' + data.zona.nama_zona + ' — Total ditemukan: ' + data.total_fasilitas + ' fasilitas';

                    if (data.total_fasilitas === 0) {
                        document.getElementById('fasilitas-modal-content').innerHTML =
                            '<p style="font-size:13px; color:#999; text-align:center; padding:15px 0;">Tidak ada fasilitas (Point) di dalam zona ini.</p>';
                        return;
                    }

                    var html = '<div style="display:flex; flex-direction:column; gap:8px;">';
                    data.fasilitas.forEach(function(f) {
                        var info = getPointIcon(f.kategori);
                        html += `
                            <div style="display:flex; align-items:center; gap:10px; padding:8px; background:#fbebed; border-radius:8px;">
                                <div style="background:${info.color}; width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; color:white; flex-shrink:0;">
                                    <i class="${info.iconClass}"></i>
                                </div>
                                <div style="flex:1; min-width:0;">
                                    <div style="font-size:13px; font-weight:600; color:#333;">${f.nama}</div>
                                    <div style="font-size:11px; color:#666;">${f.kategori}</div>
                                </div>
                            </div>`;
                    });
                    html += '</div>';
                    document.getElementById('fasilitas-modal-content').innerHTML = html;
                })
                .catch(function(err) {
                    document.getElementById('fasilitas-modal-subtitle').textContent = 'Gagal memuat data.';
                    console.error('Gagal cek fasilitas dalam zona:', err);
                });
        }

        function tutupModalFasilitas() {
            document.getElementById('fasilitas-modal-overlay').style.display = 'none';
        }

        loadAllLayers();
        loadBatasWilayah();
        updateLegenda();

        // TAMBAHAN: baca parameter ?tab= dari URL (dikirim dari halaman Tabel Data)
        (function() {
            var params = new URLSearchParams(window.location.search);
            var tabDariTabel = params.get('tab');
            if (tabDariTabel && ['point', 'polyline', 'polygon'].includes(tabDariTabel)) {
                setTab(tabDariTabel);
            }
        })();
    </script>
@endpush
