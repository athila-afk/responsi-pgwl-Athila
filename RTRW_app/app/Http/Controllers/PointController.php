<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointController extends Controller
{
    public function geojson()
    {
        $points = DB::select("
        SELECT id, nama, kategori, keterangan, foto,
            ST_AsGeoJSON(geom) as geometry
        FROM points
    ");

        $features = [];
        foreach ($points as $point) {
            $features[] = [
                'type' => 'Feature',
                'geometry' => json_decode($point->geometry),
                'properties' => [
                    'id' => $point->id,
                    'nama' => $point->nama,
                    'kategori' => $point->kategori,
                    'keterangan' => $point->keterangan,
                    'foto' => $point->foto,
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
            $filename = time() . '_point.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/images'), $filename);
            $foto = $filename;
        }

        DB::statement("
        INSERT INTO points (nama, kategori, keterangan, foto, geom, created_at, updated_at)
        VALUES (?, ?, ?, ?, ST_GeomFromGeoJSON(?), NOW(), NOW())
    ", [
            $request->nama,
            $request->kategori,
            $request->keterangan,
            $foto,
            $request->geojson,
        ]);

        return response()->json(['message' => 'Point berhasil disimpan!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
        ]);

        $point = Point::findOrFail($id);

        $foto = $point->foto;
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada, supaya file tidak menumpuk di server
            if ($foto && file_exists(public_path('storage/images/' . $foto))) {
                unlink(public_path('storage/images/' . $foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_point.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/images'), $filename);
            $foto = $filename;
        }

        // Geometry sengaja TIDAK diubah di sini.
        // Edit posisi titik dilakukan lewat toolbar Leaflet.Draw (geser marker),
        // bukan lewat form data ini.
        DB::statement("
        UPDATE points
        SET nama = ?, kategori = ?, keterangan = ?, foto = ?, updated_at = NOW()
        WHERE id = ?
    ", [
            $request->nama,
            $request->kategori,
            $request->keterangan,
            $foto,
            $id,
        ]);

        return response()->json(['message' => 'Point berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        Point::findOrFail($id)->delete();
        return response()->json(['message' => 'Point berhasil dihapus!']);
    }
}
