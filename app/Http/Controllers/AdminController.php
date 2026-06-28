<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KawasanIndustri;
use App\Models\Pelabuhan;
use App\Models\Bandara;
use App\Models\Jalan;

class AdminController extends Controller
{
    public function index()
    {
        $kawasan = KawasanIndustri::with('wilayah')
            ->select('kawasan_industri.*')
            ->selectRaw('ST_Y(geom) AS latitude')
            ->selectRaw('ST_X(geom) AS longitude')
            ->orderBy('nama')
            ->get();

        $pelabuhan = Pelabuhan::with('wilayah')
            ->select('pelabuhan.*')
            ->selectRaw('ST_Y(geom) AS latitude')
            ->selectRaw('ST_X(geom) AS longitude')
            ->orderBy('nama')
            ->get();

        $bandara = Bandara::with('wilayah')
            ->select('bandara.*')
            ->selectRaw('ST_Y(geom) AS latitude')
            ->selectRaw('ST_X(geom) AS longitude')
            ->orderBy('nama')
            ->get();

        $jalan = Jalan::orderBy('nama_jalan')
            ->get();

        $totalKawasan = $kawasan->count();
        $totalPelabuhan = $pelabuhan->count();
        $totalBandara = $bandara->count();
        $totalJalan = $jalan->count();

        return view('admin.pageadmin', compact(
            'kawasan',
            'pelabuhan',
            'bandara',
            'jalan',
            'totalKawasan',
            'totalPelabuhan',
            'totalBandara',
            'totalJalan'
        ));
    }

    private function pointData(Request $request): array
    {
        $request->validate([
            'latitude'  => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $latitude = (float) $request->input('latitude');
        $longitude = (float) $request->input('longitude');

        return [
            'geom' => DB::raw("ST_SetSRID(ST_MakePoint({$longitude}, {$latitude}), 4326)"),
            'kode_kec' => $this->findKodeKec($latitude, $longitude),
        ];
    }

    private function findKodeKec(float $latitude, float $longitude): ?string
    {
        $row = DB::selectOne("
            SELECT kode_kec
            FROM wilayah_administrasi
            WHERE ST_Contains(
                geom,
                ST_SetSRID(ST_MakePoint(?, ?), 4326)
            )
            OR ST_Intersects(
                geom,
                ST_SetSRID(ST_MakePoint(?, ?), 4326)
            )
            LIMIT 1
        ", [$longitude, $latitude, $longitude, $latitude]);

        return $row->kode_kec ?? null;
    }

    # KAWASAN INDUSTRI
    public function storeKawasan(Request $request)
    {
        $data = $request->only([
            'nama',
            'lokasi',
            'luas_lahan',
            'infrastruktur',
            'fasilitas',
            'tahun_beroperasi',
        ]);

        $data = array_merge($data, $this->pointData($request));

        KawasanIndustri::create($data);

        return redirect()->route('admin.page', [
            'tab' => 'kawasan',
        ])->with('success', 'Data kawasan berhasil ditambahkan.');
    }

    public function updateKawasan(Request $request, $id)
    {
        $data = $request->only([
            'nama',
            'lokasi',
            'luas_lahan',
            'infrastruktur',
            'fasilitas',
            'tahun_beroperasi',
        ]);

        $data = array_merge($data, $this->pointData($request));

        KawasanIndustri::findOrFail($id)->update($data);

        return redirect()->route('admin.page', [
            'tab' => 'kawasan',
        ])->with('success', 'Data kawasan berhasil diperbarui.');
    }

    public function deleteKawasan($id)
    {
        KawasanIndustri::findOrFail($id)->delete();

        return redirect()->route('admin.page', [
            'tab' => 'kawasan',
        ])->with('success', 'Data kawasan berhasil dihapus.');
    }

    # PELABUHAN
    public function storePelabuhan(Request $request)
    {
        $data = $request->only([
            'nama',
            'alamat',
            'jenis',
        ]);

        $data = array_merge($data, $this->pointData($request));

        Pelabuhan::create($data);

        return redirect()->route('admin.page', [
            'tab'    => 'infrastruktur',
            'subtab' => 'pelabuhan',
        ])->with('success', 'Data pelabuhan berhasil ditambahkan.');
    }

    public function updatePelabuhan(Request $request, $id)
    {
        $data = $request->only([
            'nama',
            'alamat',
            'jenis',
        ]);

        $data = array_merge($data, $this->pointData($request));

        Pelabuhan::findOrFail($id)->update($data);

        return redirect()->route('admin.page', [
            'tab'    => 'infrastruktur',
            'subtab' => 'pelabuhan',
        ])->with('success', 'Data pelabuhan berhasil diperbarui.');
    }

    public function deletePelabuhan($id)
    {
        Pelabuhan::findOrFail($id)->delete();

        return redirect()->route('admin.page', [
            'tab'    => 'infrastruktur',
            'subtab' => 'pelabuhan',
        ])->with('success', 'Data pelabuhan berhasil dihapus.');
    }

    # BANDARA
    public function storeBandara(Request $request)
    {
        $data = $request->only([
            'nama',
            'alamat',
        ]);

        $data = array_merge($data, $this->pointData($request));

        Bandara::create($data);

        return redirect()->route('admin.page', [
            'tab'    => 'infrastruktur',
            'subtab' => 'bandara',
        ])->with('success', 'Data bandara berhasil ditambahkan.');
    }

    public function updateBandara(Request $request, $id)
    {
        $data = $request->only([
            'nama',
            'alamat',
        ]);

        $data = array_merge($data, $this->pointData($request));

        Bandara::findOrFail($id)->update($data);

        return redirect()->route('admin.page', [
            'tab'    => 'infrastruktur',
            'subtab' => 'bandara',
        ])->with('success', 'Data bandara berhasil diperbarui.');
    }

    public function deleteBandara($id)
    {
        Bandara::findOrFail($id)->delete();

        return redirect()->route('admin.page', [
            'tab'    => 'infrastruktur',
            'subtab' => 'bandara',
        ])->with('success', 'Data bandara berhasil dihapus.');
    }

    # JALAN
    public function storeJalan(Request $request)
    {
        Jalan::create($request->all());

        return redirect()->route('admin.page', [
            'tab'    => 'infrastruktur',
            'subtab' => 'jalan',
        ])->with('success', 'Data jalan berhasil ditambahkan.');
    }

    public function updateJalan(Request $request, $id)
    {
        Jalan::findOrFail($id)->update($request->all());

        return redirect()->route('admin.page', [
            'tab'    => 'infrastruktur',
            'subtab' => 'jalan',
        ])->with('success', 'Data jalan berhasil diperbarui.');
    }

    public function deleteJalan($id)
    {
        Jalan::findOrFail($id)->delete();

        return redirect()->route('admin.page', [
            'tab'    => 'infrastruktur',
            'subtab' => 'jalan',
        ])->with('success', 'Data jalan berhasil dihapus.');
    }
}
