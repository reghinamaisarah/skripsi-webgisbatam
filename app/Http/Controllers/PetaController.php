<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KawasanIndustri;

class PetaController extends Controller
{
    public function index(Request $request)
    {
        $hasApplied = $request->has('radius')
            && $request->has('infrastruktur')
            && $request->has('status');

        // Parameter analisis
        $radius = (float) $request->input('radius', 3);

        if ($radius <= 0) {
            $radius = 3;
        }

        $infrastruktur = $request->input('infrastruktur', []);

        $statusFilter = $request->input('status', '');

        if (!is_array($infrastruktur)) {
            $infrastruktur = [$infrastruktur];
        }

        $accessConditions = [];
        $validInfrastruktur = ['jalan', 'pelabuhan', 'bandara'];

        foreach ($infrastruktur as $infra) {
            if (!in_array($infra, $validInfrastruktur)) continue;

            $table = $infra;

            $accessConditions[] = "EXISTS (
                SELECT 1
                FROM {$table} t
                WHERE ST_Intersects(
                    ST_Buffer(
                        ki.geom::geography,
                        {$radius} * 1000
                    )::geometry,
                    t.geom
                )
            )";
        }

        $terjangkauExpr = empty($accessConditions)
            ? 'FALSE'
            : '(' . implode(' AND ', $accessConditions) . ')';

        if (!$hasApplied) {
            $terjangkauExpr = 'NULL';
        }

        // Semua buffer dihitung langsung menggunakan ST_Buffer().
        $kawasan = DB::select("
            SELECT
                ki.id,
                ki.nama,
                ki.lokasi,
                ki.luas_lahan,
                ki.infrastruktur,
                ki.fasilitas,
                ki.tahun_beroperasi,
                ki.kode_kec,
                wa.kecamatan,
                ST_AsGeoJSON(ki.geom) AS geom,

                -- Aksesibilitas pada radius AKTIF (bebas, sesuai input user)
                EXISTS (
                    SELECT 1 FROM jalan j
                    WHERE ST_Intersects(
                        ST_Buffer(ki.geom::geography, {$radius} * 1000)::geometry,
                        j.geom
                    )
                ) AS jalan_aktif,
                EXISTS (
                    SELECT 1 FROM pelabuhan p
                    WHERE ST_Intersects(
                        ST_Buffer(ki.geom::geography, {$radius} * 1000)::geometry,
                        p.geom
                    )
                ) AS pelabuhan_aktif,
                EXISTS (
                    SELECT 1 FROM bandara b
                    WHERE ST_Intersects(
                        ST_Buffer(ki.geom::geography, {$radius} * 1000)::geometry,
                        b.geom
                    )
                ) AS bandara_aktif,

                -- Status keterjangkauan berdasarkan parameter aktif (radius dinamis dari user)
                {$terjangkauExpr} AS terjangkau

            FROM kawasan_industri ki
            LEFT JOIN wilayah_administrasi wa ON ki.kode_kec = wa.kode_kec

            ORDER BY ki.nama ASC
        ");

        if ($hasApplied && $statusFilter === 'terjangkau') {
            $kawasan = array_values(
                array_filter($kawasan, fn($k) => $k->terjangkau === true)
            );
        } elseif ($hasApplied && $statusFilter === 'tidak_terjangkau') {
            $kawasan = array_values(
                array_filter($kawasan, fn($k) => $k->terjangkau === false)
            );
        }

        // Buffer (layer buffer aktif di peta, radius mengikuti input user)
        $buffer = DB::select("
            SELECT
                id,
                nama,
                ST_AsGeoJSON(
                    ST_Buffer(
                        geom::geography,
                        {$radius} * 1000
                    )::geometry
                ) AS buffer_aktif
            FROM kawasan_industri
        ");

        // Jalan
        $jalan = DB::select("
            SELECT
                id,
                nama_jalan,
                jenis_jalan,
                ST_AsGeoJSON(ST_SimplifyPreserveTopology(geom, 0.0001)) AS geom
            FROM jalan
            ORDER BY nama_jalan ASC
        ");

        // Bandara
        $bandara = DB::select("
            SELECT
                b.id,
                b.nama,
                b.alamat,
                b.kode_kec,
                wa.kecamatan,
                ST_AsGeoJSON(b.geom) AS geom
            FROM bandara b
            LEFT JOIN wilayah_administrasi wa ON b.kode_kec = wa.kode_kec
            ORDER BY b.nama ASC
        ");

        // Pelabuhan
        $pelabuhan = DB::select("
            SELECT
                p.id,
                p.nama,
                p.alamat,
                p.jenis,
                p.kode_kec,
                wa.kecamatan,
                ST_AsGeoJSON(p.geom) AS geom
            FROM pelabuhan p
            LEFT JOIN wilayah_administrasi wa ON p.kode_kec = wa.kode_kec
            ORDER BY p.nama ASC
        ");

        // Wilayah Administrasi (seluruh Kota Batam)
        $wilayah = DB::select("
            SELECT
                ST_AsGeoJSON(
                    ST_SimplifyPreserveTopology(ST_Union(geom), 0.0001)
                ) AS geom
            FROM wilayah_administrasi
        ");

        $totalKawasan = KawasanIndustri::count();

        // Hitung summary untuk panel
        $allKawasan = DB::select("
            SELECT
                ki.id,
                {$terjangkauExpr} AS terjangkau
            FROM kawasan_industri ki
        ");
        if ($hasApplied) {
            $totalTerjangkau = count(
                array_filter($allKawasan, fn($k) => $k->terjangkau === true)
            );

            $totalTidakTerjangkau = count(
                array_filter($allKawasan, fn($k) => $k->terjangkau === false)
            );
        } else {
            $totalTerjangkau = 0;
            $totalTidakTerjangkau = 0;
        }

        return view('peta', compact(
            'kawasan',
            'buffer',
            'jalan',
            'wilayah',
            'bandara',
            'pelabuhan',
            'totalKawasan',
            'totalTerjangkau',
            'totalTidakTerjangkau',
            'radius',
            'infrastruktur',
            'statusFilter',
            'hasApplied'
        ));
    }
}