<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = [
    'nama',
    'kategori',
    'keterangan',
    'foto',
    'geom',
];
}
