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

        // ── Parameter analisis ──
        $radius = in_array($request->input('radius'), ['1', '3', '5'])
            ? $request->input('radius')
            : '3';

        $infrastruktur = $request->input('infrastruktur', []);

        $statusFilter = $request->input('status', '');

        // Pastikan infrastruktur selalu array
        if (!is_array($infrastruktur)) {
            $infrastruktur = [$infrastruktur];
        }

        $bufferColumn = "buffer_{$radius}km";

        $accessConditions = [];
        $validInfrastruktur = ['jalan', 'pelabuhan', 'bandara'];

        foreach ($infrastruktur as $infra) {
            if (!in_array($infra, $validInfrastruktur)) continue;

            if ($infra === 'jalan') {
                $accessConditions[] = "EXISTS (
                    SELECT 1 FROM jalan j
                    WHERE ST_Intersects(bk.{$bufferColumn}, j.geom)
                )";
            } elseif ($infra === 'pelabuhan') {
                $accessConditions[] = "EXISTS (
                    SELECT 1 FROM pelabuhan p
                    WHERE ST_Intersects(bk.{$bufferColumn}, p.geom)
                )";
            } elseif ($infra === 'bandara') {
                $accessConditions[] = "EXISTS (
                    SELECT 1 FROM bandara b
                    WHERE ST_Intersects(bk.{$bufferColumn}, b.geom)
                )";
            }
        }

        // Jika tidak ada infrastruktur dipilih, anggap semua tidak terjangkau
        $terjangkauExpr = empty($accessConditions)
            ? 'FALSE'
            : '(' . implode(' AND ', $accessConditions) . ')';

        if (!$hasApplied) {
            $terjangkauExpr = 'NULL';
        }    

        // ── Bangun HAVING / WHERE untuk filter status ──
        $statusHaving = '';
        if ($statusFilter === 'terjangkau') {
            $statusHaving = "HAVING {$terjangkauExpr}";
        } elseif ($statusFilter === 'tidak_terjangkau') {
            $statusHaving = "HAVING NOT ({$terjangkauExpr})";
        }

        // ── Query kawasan industri dengan analisis dinamis ──
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

                -- Aksesibilitas per radius (selalu dihitung, untuk detail panel)
                EXISTS (
                    SELECT 1 FROM jalan j
                    WHERE ST_Intersects(bk.buffer_1km, j.geom)
                ) AS jalan_1km,
                EXISTS (
                    SELECT 1 FROM jalan j
                    WHERE ST_Intersects(bk.buffer_3km, j.geom)
                ) AS jalan_3km,
                EXISTS (
                    SELECT 1 FROM jalan j
                    WHERE ST_Intersects(bk.buffer_5km, j.geom)
                ) AS jalan_5km,

                EXISTS (
                    SELECT 1 FROM pelabuhan p
                    WHERE ST_Intersects(bk.buffer_1km, p.geom)
                ) AS pelabuhan_1km,
                EXISTS (
                    SELECT 1 FROM pelabuhan p
                    WHERE ST_Intersects(bk.buffer_3km, p.geom)
                ) AS pelabuhan_3km,
                EXISTS (
                    SELECT 1 FROM pelabuhan p
                    WHERE ST_Intersects(bk.buffer_5km, p.geom)
                ) AS pelabuhan_5km,

                EXISTS (
                    SELECT 1 FROM bandara b
                    WHERE ST_Intersects(bk.buffer_1km, b.geom)
                ) AS bandara_1km,
                EXISTS (
                    SELECT 1 FROM bandara b
                    WHERE ST_Intersects(bk.buffer_3km, b.geom)
                ) AS bandara_3km,
                EXISTS (
                    SELECT 1 FROM bandara b
                    WHERE ST_Intersects(bk.buffer_5km, b.geom)
                ) AS bandara_5km,

                -- Status keterjangkauan berdasarkan parameter aktif
                {$terjangkauExpr} AS terjangkau

            FROM kawasan_industri ki
            JOIN buffer_kawasan bk ON ki.id = bk.id
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

        // ── Buffer (untuk semua kawasan, digunakan di frontend saat klik marker) ──
        $buffer = DB::select("
            SELECT
                id,
                nama,
                ST_AsGeoJSON(buffer_1km) AS buffer_1km,
                ST_AsGeoJSON(buffer_3km) AS buffer_3km,
                ST_AsGeoJSON(buffer_5km) AS buffer_5km
            FROM buffer_kawasan
        ");

        // ── Jalan ──
        $jalan = DB::select("
            SELECT
                id,
                nama_jalan,
                jenis_jalan,
                ST_AsGeoJSON(geom) AS geom
            FROM jalan
            ORDER BY nama_jalan ASC
        ");

        // ── Bandara ──
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

        // ── Pelabuhan ──
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

        // ── Wilayah Administrasi (seluruh Kota Batam, semua polygon) ──
        $wilayah = DB::select("
            SELECT
                ST_AsGeoJSON(
                    ST_Union(geom)
                ) AS geom
            FROM wilayah_administrasi
        ");

        $totalKawasan = KawasanIndustri::count();

        // ── Hitung summary untuk panel ──
        $allKawasan = DB::select("
            SELECT
                ki.id,
                {$terjangkauExpr} AS terjangkau
            FROM kawasan_industri ki
            JOIN buffer_kawasan bk ON ki.id = bk.id
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