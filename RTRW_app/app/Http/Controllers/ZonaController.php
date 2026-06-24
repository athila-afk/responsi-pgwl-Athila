<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ZonaController extends Controller
{
    // Halaman beranda
    public function beranda()
    {
        $totalZona = Zona::count();
        $totalPoint = \App\Models\Point::count();
        $totalPolyline = \App\Models\Polyline::count();
        $perJenis = Zona::select('jenis_zona', DB::raw('count(*) as total'))
            ->groupBy('jenis_zona')
            ->get();
        return view('beranda', compact('totalZona', 'totalPoint', 'totalPolyline', 'perJenis'));
    }

    // Halaman peta
    public function index()
    {
        return view('zona.index');
    }

    // Halaman tabel
    public function tabel()
    {
        $zonas = DB::select("
        SELECT id, nama_zona, kode_zona, jenis_zona, warna, keterangan, foto,
            created_at,
            ROUND(ST_Area(geom::geography)::numeric / 10000, 4) as luas_ha
        FROM zonas ORDER BY created_at DESC
    ");

        $points = DB::select("
        SELECT id, nama, kategori, keterangan, foto, created_at,
            ROUND(ST_Y(geom)::numeric, 6) as lat,
            ROUND(ST_X(geom)::numeric, 6) as lng
        FROM points ORDER BY created_at DESC
    ");

        $polylines = DB::select("
        SELECT id, nama, kategori, warna, keterangan, foto, created_at,
            ROUND(ST_Length(geom::geography)::numeric / 1000, 3) as panjang_km
        FROM polylines ORDER BY created_at DESC
    ");

        return view('zona.tabel', compact('zonas', 'points', 'polylines'));
    }

    // API GeoJSON
    public function geojson()
    {
        $zonas = DB::select("
        SELECT id, nama_zona, kode_zona, jenis_zona, warna, keterangan, foto,
            ST_AsGeoJSON(geom) as geometry,
            ST_Area(geom::geography) as luas_m2,
            ST_Perimeter(geom::geography) as keliling_m
        FROM zonas
    ");

        $features = [];
        foreach ($zonas as $zona) {
            $features[] = [
                'type' => 'Feature',
                'geometry' => json_decode($zona->geometry),
                'properties' => [
                    'id' => $zona->id,
                    'nama_zona' => $zona->nama_zona,
                    'kode_zona' => $zona->kode_zona,
                    'jenis_zona' => $zona->jenis_zona,
                    'warna' => $zona->warna,
                    'keterangan' => $zona->keterangan,
                    'foto' => $zona->foto,
                    'luas_m2' => round($zona->luas_m2, 2),
                    'luas_ha' => round($zona->luas_m2 / 10000, 4),
                    'keliling_m' => round($zona->keliling_m, 2),
                ]
            ];
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features
        ]);
    }

    // Simpan zona
    public function store(Request $request)
    {
        $request->validate([
            'nama_zona' => 'required',
            'kode_zona' => 'required',
            'jenis_zona' => 'required',
            'geojson'   => 'required',
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_polygon.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/images'), $filename);
            $foto = $filename;
        }

        DB::statement("
        INSERT INTO zonas (nama_zona, kode_zona, jenis_zona, warna, keterangan, foto, geom, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ST_GeomFromGeoJSON(?), NOW(), NOW())
    ", [
            $request->nama_zona,
            $request->kode_zona,
            $request->jenis_zona,
            $request->warna ?? '#3388ff',
            $request->keterangan,
            $foto,
            $request->geojson,
        ]);

        return response()->json(['message' => 'Zona berhasil disimpan!']);
    }

    // Perbarui zona
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_zona' => 'required',
            'kode_zona' => 'required',
            'jenis_zona' => 'required',
        ]);

        $zona = Zona::findOrFail($id);

        $foto = $zona->foto;
        if ($request->hasFile('foto')) {
            if ($foto && file_exists(public_path('storage/images/' . $foto))) {
                unlink(public_path('storage/images/' . $foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_polygon.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/images'), $filename);
            $foto = $filename;
        }

        // Geometry sengaja TIDAK diubah di sini, sama seperti Point & Polyline.
        DB::statement("
        UPDATE zonas
        SET nama_zona = ?, kode_zona = ?, jenis_zona = ?, warna = ?, keterangan = ?, foto = ?, updated_at = NOW()
        WHERE id = ?
    ", [
            $request->nama_zona,
            $request->kode_zona,
            $request->jenis_zona,
            $request->warna ?? $zona->warna,
            $request->keterangan,
            $foto,
            $id,
        ]);

        return response()->json(['message' => 'Zona berhasil diperbarui!']);
    }

    // Hapus zona
    public function destroy($id)
    {
        Zona::findOrFail($id)->delete();
        return response()->json(['message' => 'Zona berhasil dihapus!']);
    }

    // ===== Spatial Query — cari Point yang berada di dalam Zona tertentu =====
    public function fasilitasDalamZona($id)
    {
        $zona = Zona::findOrFail($id);

        $points = DB::select("
            SELECT p.id, p.nama, p.kategori, p.keterangan, p.foto
            FROM points p
            JOIN zonas z ON ST_Within(p.geom, z.geom)
            WHERE z.id = ?
        ", [$id]);

        return response()->json([
            'zona' => [
                'id' => $zona->id,
                'nama_zona' => $zona->nama_zona,
                'jenis_zona' => $zona->jenis_zona,
            ],
            'total_fasilitas' => count($points),
            'fasilitas' => $points,
        ]);
    }
}
