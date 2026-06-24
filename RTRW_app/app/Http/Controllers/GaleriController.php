<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Gallery::orderBy('created_at', 'desc')->get();
        return view('galeri', compact('galeris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $path = $request->file('foto')->store('images', 'public');

        Gallery::create(['foto' => basename($path)]);

        return redirect('/galeri')->with('success', 'Foto berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $galeri = Gallery::findOrFail($id);
        Storage::disk('public')->delete('images/' . $galeri->foto);
        $galeri->delete();

        return response()->json(['message' => 'Foto berhasil dihapus']);
    }
}
