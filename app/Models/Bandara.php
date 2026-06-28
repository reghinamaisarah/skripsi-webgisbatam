<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bandara extends Model
{
    protected $table = 'bandara';

    protected $fillable = [
        'nama',
        'alamat',
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