<?php

namespace App\Http\Controllers;

use App\Models\Polyline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PolylineController extends Controller
{
    public function geojson()
    {
        $polylines = DB::select("
        SELECT id, nama, kategori, warna, keterangan, foto,
            ST_AsGeoJSON(geom) as geometry,
            ST_Length(geom::geography) as panjang_m
        FROM polylines
    ");

        $features = [];
        foreach ($polylines as $polyline) {
            $features[] = [
                'type' => 'Feature',
                'geometry' => json_decode($polyline->geometry),
                'properties' => [
                    'id' => $polyline->id,
                    'nama' => $polyline->nama,
                    'kategori' => $polyline->kategori,
                    'warna' => $polyline->warna,
                    'keterangan' => $polyline->keterangan,
                    'foto' => $polyline->foto,
                    // ===== TAMBAHAN: hasil analisis spasial =====
                    'panjang_m' => round($polyline->panjang_m, 2),
                    'panjang_km' => round($polyline->panjang_m / 1000, 3),
                ]
            ];
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'geojson' => 'required',
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_polyline.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/images'), $filename);
            $foto = $filename;
        }

        DB::statement("
        INSERT INTO polylines (nama, kategori, warna, keterangan, foto, geom, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ST_GeomFromGeoJSON(?), NOW(), NOW())
    ", [
            $request->nama,
            $request->kategori,
            $request->warna ?? '#ff0000',
            $request->keterangan,
            $foto,
            $request->geojson,
        ]);

        return response()->json(['message' => 'Polyline berhasil disimpan!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
        ]);

        $polyline = Polyline::findOrFail($id);

        $foto = $polyline->foto;
        if ($request->hasFile('foto')) {
            if ($foto && file_exists(public_path('storage/images/' . $foto))) {
                unlink(public_path('storage/images/' . $foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_polyline.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/images'), $filename);
            $foto = $filename;
        }

        // Geometry sengaja TIDAK diubah di sini, sama seperti Point.
        DB::statement("
        UPDATE polylines
        SET nama = ?, kategori = ?, warna = ?, keterangan = ?, foto = ?, updated_at = NOW()
        WHERE id = ?
    ", [
            $request->nama,
            $request->kategori,
            $request->warna ?? $polyline->warna,
            $request->keterangan,
            $foto,
            $id,
        ]);

        return response()->json(['message' => 'Polyline berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        Polyline::findOrFail($id)->delete();
        return response()->json(['message' => 'Polyline berhasil dihapus!']);
    }
}
