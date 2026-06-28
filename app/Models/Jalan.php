<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Jalan extends Model
{
    protected $table = 'jalan';

    protected $fillable = [
        'nama_jalan',
        'jenis_jalan',
        'geom',
    ];

    public $timestamps = false;

    // Normalisasi nama jalan.
    private static function normalizedRoadNameExpression(): string
    {
        return 'LOWER(TRIM(nama_jalan))';
    }

    // Filter dasar untuk mengambil data jalan yang layak ditampilkan
    public function scopeValidForDisplay(Builder $query): Builder
    {
        return $query
            ->whereNotNull('nama_jalan')
            ->whereRaw("TRIM(nama_jalan) <> ''")
            ->whereRaw("nama_jalan NOT ILIKE ?", ['%U.Turn%'])
            ->whereRaw("LTRIM(nama_jalan) NOT LIKE ?", ['[%']);
    }

    //  Mengambil daftar nama jalan unik yang layak ditampilkan.
    public function scopeForDisplay(Builder $query): Builder
    {
        $normalizedName = self::normalizedRoadNameExpression();

        return $query
            ->validForDisplay()
            ->selectRaw("
                {$normalizedName} AS nama_jalan_normalized,
                MIN(TRIM(nama_jalan)) AS nama_jalan,
                MIN(jenis_jalan) AS jenis_jalan
            ")
            ->groupByRaw($normalizedName)
            ->orderBy('nama_jalan', 'asc');
    }

    // Menghitung jumlah nama jalan unik yang terpetakan.
    public static function countMappedRoads(): int
    {
        $normalizedName = self::normalizedRoadNameExpression();

        $total = static::query()
            ->validForDisplay()
            ->selectRaw("
                COUNT(DISTINCT {$normalizedName}) AS total
            ")
            ->value('total');

        return (int) $total;
    }
}