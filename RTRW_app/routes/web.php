<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\PolylineController;
use App\Http\Controllers\GaleriController;

// Route Login (tidak perlu auth)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Route yang butuh login
Route::middleware('auth')->group(function () {
    // Halaman
    Route::get('/', [ZonaController::class, 'beranda']);
    Route::get('/zona', [ZonaController::class, 'index']);
    Route::get('/tabel', [ZonaController::class, 'tabel']);

    // API Zona (Polygon)
    Route::get('/api/zona/geojson', [ZonaController::class, 'geojson']);
    Route::post('/api/zona', [ZonaController::class, 'store']);
    Route::delete('/api/zona/{id}', [ZonaController::class, 'destroy']);
    Route::put('/api/zona/{id}', [ZonaController::class, 'update']);

    // Spatial Query — fasilitas (Point) di dalam Zona tertentu 
    Route::get('/api/zona/{id}/fasilitas', [ZonaController::class, 'fasilitasDalamZona']);

    // API Point
    Route::get('/api/point/geojson', [PointController::class, 'geojson']);
    Route::post('/api/point', [PointController::class, 'store']);
    Route::delete('/api/point/{id}', [PointController::class, 'destroy']);
    Route::put('/api/point/{id}', [PointController::class, 'update']);

    // API Polyline
    Route::get('/api/polyline/geojson', [PolylineController::class, 'geojson']);
    Route::post('/api/polyline', [PolylineController::class, 'store']);
    Route::delete('/api/polyline/{id}', [PolylineController::class, 'destroy']);
    Route::put('/api/polyline/{id}', [PolylineController::class, 'update']);

    //Galeri
    Route::get('/galeri', [GaleriController::class, 'index']);
    Route::post('/galeri', [GaleriController::class, 'store']);
    Route::delete('/galeri/{id}', [GaleriController::class, 'destroy']);
});
