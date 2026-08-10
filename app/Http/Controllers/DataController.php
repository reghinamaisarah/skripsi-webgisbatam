<?php

namespace App\Http\Controllers;

use App\Models\Bandara;
use App\Models\Jalan;
use App\Models\KawasanIndustri;
use App\Models\Pelabuhan;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    private const RADIUS_MIN = 0.001;
    private const RADIUS_DEFAULT = 5;

    private const STATUS_BAIK = 2;

    public function index()
    {
        // Data kawasan industri + kecamatan
        $kawasan = KawasanIndustri::with('wilayah')
            ->orderBy('nama', 'asc')
            ->get();

        // Data pelabuhan + kecamatan
        $pelabuhan = Pelabuhan::with('wilayah')
            ->orderBy('nama', 'asc')
            ->get();

        // Data bandara + kecamatan
        $bandara = Bandara::with('wilayah')
            ->orderBy('nama', 'asc')
            ->get();

        // Data jalan untuk tabel UI
        $jalan = Jalan::forDisplay()->get();

        // Total data untuk statistik
        $totalKawasan = KawasanIndustri::count();
        $totalPelabuhan = Pelabuhan::count();
        $totalBandara = Bandara::count();

        // Menghitung jumlah nama jalan unik yang terpetakan
        $totalJalan = Jalan::countMappedRoads();

        // Radius buffer, bisa dipilih radius, default 5 km
        $radius = (float) request('radius', self::RADIUS_DEFAULT);
        $radius = max(self::RADIUS_MIN, $radius);
        $radiusMeter = $radius * 1000;

        // Filter status hasil analisis
        $statusFilter = request('status');
        $statusFilter = in_array($statusFilter, ['baik', 'kurang'], true) ? $statusFilter : null;

        $aksesibilitas = DB::select("
            SELECT
                ki.id,

                EXISTS (
                    SELECT 1
                    FROM jalan j
                    WHERE ST_DWithin(ki.geom::geography, j.geom::geography, ?)
                ) AS jalan_terjangkau,

                EXISTS (
                    SELECT 1
                    FROM pelabuhan p
                    WHERE ST_DWithin(ki.geom::geography, p.geom::geography, ?)
                ) AS pelabuhan_terjangkau,

                EXISTS (
                    SELECT 1
                    FROM bandara b
                    WHERE ST_DWithin(ki.geom::geography, b.geom::geography, ?)
                ) AS bandara_terjangkau

            FROM kawasan_industri ki
            ORDER BY ki.nama ASC
        ", [$radiusMeter, $radiusMeter, $radiusMeter]);

        $aksesMap = collect($aksesibilitas)->keyBy('id')->map(function ($row) {
            $jumlahAkses = (int) $row->jalan_terjangkau
                + (int) $row->pelabuhan_terjangkau
                + (int) $row->bandara_terjangkau;

            $row->jumlah_akses = $jumlahAkses;
            $row->status_akses = $jumlahAkses >= self::STATUS_BAIK ? 'baik' : 'kurang';

            return $row;
        });

        // Urutkan kawasan berdasarkan jumlah akses (paling terjangkau duluan)
        $kawasan = $kawasan->sortByDesc(function ($item) use ($aksesMap) {
            return $aksesMap->get($item->id)->jumlah_akses ?? 0;
        })->values();

        // Kalau ada filter status, sisakan kawasan yang statusnya cocok
        if ($statusFilter) {
            $kawasan = $kawasan->filter(function ($item) use ($aksesMap, $statusFilter) {
                return ($aksesMap->get($item->id)->status_akses ?? null) === $statusFilter;
            })->values();
        }

        return view('data', compact(
            'kawasan',
            'pelabuhan',
            'bandara',
            'jalan',
            'totalKawasan',
            'totalPelabuhan',
            'totalBandara',
            'totalJalan',
            'aksesMap',
            'radius',
            'statusFilter'
        ));
    }
}