<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $fillable = [
    'nama_zona',
    'kode_zona',
    'jenis_zona',
    'warna',
    'keterangan',
    'foto',
    'geom',
];
}
