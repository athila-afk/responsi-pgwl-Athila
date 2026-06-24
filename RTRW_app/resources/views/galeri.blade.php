@extends('layouts.app')

@section('content')
    <div style="padding:30px; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="color:#55768C; margin:0;">Galeri Tata Ruang Kota Padang</h2>
            <button onclick="toggleForm()"
                style="background:#B83556; color:white; padding:10px 20px; border:none; border-radius:6px; cursor:pointer; font-size:14px; font-weight:bold;">
                + Tambah Foto
            </button>
        </div>

        @if (session('success'))
            <div
                style="background:#fbebed; color:#B83556; padding:12px 18px; border-radius:8px; margin-bottom:20px; font-size:14px; font-weight:600;">
                {{ session('success') }}
            </div>
        @endif

        <!-- FORM UPLOAD -->
        <div id="form-upload"
            style="display:none; background:#fbebed; padding:20px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); margin-bottom:25px;">
            <h4 style="color:#B83556; margin-top:0;">Tambah Foto Baru</h4>
            <form action="/galeri" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="foto" accept="image/*" required
                    style="width:100%; padding:5px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;">
                <button type="submit"
                    style="background:#B83556; color:white; padding:10px 20px; border:none; border-radius:6px; cursor:pointer; font-weight:bold; font-size:14px;">
                    Simpan Foto
                </button>
            </form>
        </div>

        <!-- GRID GALERI -->
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:20px;">
            @forelse($galeris as $item)
                <div class="foto-card">
                    <img src="{{ asset('storage/images/' . $item->foto) }}" alt="Foto Galeri"
                        onclick="bukaFoto('{{ asset('storage/images/' . $item->foto) }}')" style="cursor:zoom-in;">
                    <button class="btn-hapus" onclick="hapusFoto({{ $item->id }})">🗑️ Hapus</button>
                </div>
            @empty
                <p style="color:#888; grid-column:1/-1; text-align:center; padding:40px;">Belum ada foto di galeri.</p>
            @endforelse
        </div>

    </div>

    <!-- LIGHTBOX OVERLAY -->
    <div id="lightbox" onclick="closeLightbox()"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
               background:#fbebed; z-index:9999; justify-content:center;
               align-items:center; cursor:zoom-out;">
        <img id="lightbox-img" src=""
            style="max-width:90%; max-height:90vh; border-radius:10px; box-shadow:0 0 30px rgba(0,0,0,0.5);">
    </div>

    <style>
        .foto-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }

        .foto-card:hover {
            transform: scale(1.04) translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.18);
        }

        .foto-card:active {
            transform: scale(0.97);
        }

        .foto-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
        }

        .btn-hapus {
            width: 100%;
            background: #fbebed;
            color: #B83556;
            border: none;
            padding: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-hapus:hover {
            background: #f5c6cf;
        }
    </style>
@endsection

@push('scripts')
    <script>
        function toggleForm() {
            var form = document.getElementById('form-upload');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function hapusFoto(id) {
            if (!confirm('Yakin ingin menghapus foto ini?')) return;
            fetch('/galeri/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(r => r.json()).then(d => {
                alert(d.message);
                location.reload();
            });
        }

        function bukaFoto(url) {
            document.getElementById('lightbox-img').src = url;
            document.getElementById('lightbox').style.display = 'flex';
        }

        function closeLightbox() {
            document.getElementById('lightbox').style.display = 'none';
        }

        // Tutup lightbox pakai tombol Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
        });
    </script>
@endpush
