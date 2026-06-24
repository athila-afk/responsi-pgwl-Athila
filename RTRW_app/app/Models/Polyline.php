<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polyline extends Model
{
    protected $fillable = [
    'nama',
    'kategori',
    'warna',
    'keterangan',
    'foto',
    'geom',
];
}
