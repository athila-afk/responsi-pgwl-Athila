<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('points', function (Blueprint $table) {
            $table->string('foto')->nullable();
        });

        Schema::table('polylines', function (Blueprint $table) {
            $table->string('foto')->nullable();
        });

        Schema::table('zonas', function (Blueprint $table) {
            $table->string('foto')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('points', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
        Schema::table('polylines', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
        Schema::table('zonas', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
