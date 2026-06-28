<?php

namespace App\Http\Controllers;

use App\Models\Bandara;
use App\Models\Jalan;
use App\Models\KawasanIndustri;
use App\Models\Pelabuhan;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $totalKawasan = KawasanIndustri::count();
        $totalBandara = Bandara::count();
        $totalPelabuhan = Pelabuhan::count();
        $totalJalan = Jalan::countMappedRoads();

        return view('landing', compact(
            'totalKawasan',
            'totalBandara',
            'totalPelabuhan',
            'totalJalan'
        ));
    }
}