<?php

namespace App\Http\Controllers;

use App\Models\Bandara;
use App\Models\Jalan;
use App\Models\KawasanIndustri;
use App\Models\Pelabuhan;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
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

        // Analisis aksesibilitas radius 5 km
        $aksesibilitas = DB::select("
            SELECT
                ki.id,

                EXISTS (
                    SELECT 1
                    FROM jalan j
                    WHERE ST_Intersects(bk.buffer_5km, j.geom)
                ) AS jalan_5km,

                EXISTS (
                    SELECT 1
                    FROM pelabuhan p
                    WHERE ST_Intersects(bk.buffer_5km, p.geom)
                ) AS pelabuhan_5km,

                EXISTS (
                    SELECT 1
                    FROM bandara b
                    WHERE ST_Intersects(bk.buffer_5km, b.geom)
                ) AS bandara_5km

            FROM kawasan_industri ki
            JOIN buffer_kawasan bk
                ON ki.id = bk.id

            ORDER BY ki.nama ASC
        ");

        $aksesMap = collect($aksesibilitas)->keyBy('id');

        return view('data', compact(
            'kawasan',
            'pelabuhan',
            'bandara',
            'jalan',
            'totalKawasan',
            'totalPelabuhan',
            'totalBandara',
            'totalJalan',
            'aksesMap'
        ));
    }
}