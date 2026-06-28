<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WilayahAdministrasi extends Model
{
    protected $table = 'wilayah_administrasi';

    protected $fillable = [
        'kode_kk',
        'kode_kec',
        'kecamatan',
        'kab_kota',
        'provinsi',
        'geom',
    ];

    public $timestamps = false;

    public function kawasanIndustri()
    {
        return $this->hasMany(
            KawasanIndustri::class,
            'kode_kec',
            'kode_kec'
        );
    }

    public function pelabuhan()
    {
        return $this->hasMany(
            Pelabuhan::class,
            'kode_kec',
            'kode_kec'
        );
    }

    public function bandara()
    {
        return $this->hasMany(
            Bandara::class,
            'kode_kec',
            'kode_kec'
        );
    }
}