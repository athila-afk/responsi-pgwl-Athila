<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zonas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_zona');
            $table->string('kode_zona');
            $table->string('jenis_zona');
            $table->string('warna')->default('#3388ff');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tambah kolom geometry untuk polygon
        DB::statement('ALTER TABLE zonas ADD COLUMN geom geometry(Polygon, 4326)');
    }

    public function down(): void
    {
        Schema::dropIfExists('zonas');
    }
};
