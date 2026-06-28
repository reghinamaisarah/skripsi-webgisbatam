<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelabuhan extends Model
{
    protected $table = 'pelabuhan';

    protected $fillable = [
        'nama',
        'alamat',
        'jenis',
        'geom',
        'kode_kec',
    ];

    public $timestamps = false;

    public function wilayah()
    {
        return $this->belongsTo(
            WilayahAdministrasi::class,
            'kode_kec',
            'kode_kec'
        );
    }
}