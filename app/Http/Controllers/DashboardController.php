<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Program;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // public function index()
    // {

    //     // // 1. Total Laporan
    //     $totalReports = Laporan::count(); // Count all reports
    //     return view('dashboard.index', compact('totalReports'));
    //     // $totalReports = Laporan::count();

    //     // // 2. Jumlah Penerima Bantuan per Program
    //     // $recipientsPerProgram = Program::withCount('laporans')->get();

    //     // // 3. Grafik Penyaluran Bantuan per Wilayah (Provinsi)
    //     // $distributionByProvince = Laporan::select('wilayahs.provinsi', DB::raw('count(*) as total'))
    //     //     ->join('wilayahs', 'wilayahs.id', '=', 'laporans.wilayah_id')  // Corrected this line: 'wilayahs' instead of 'wilayah'
    //     //     ->groupBy('wilayahs.provinsi')
    //     //     ->get();

    //     // // 4. Grafik Penyaluran Bantuan per Wilayah (Kabupaten)
    //     // $distributionByDistrict = Laporan::select('wilayahs.kabupaten', DB::raw('count(*) as total'))
    //     //     ->join('wilayahs', 'wilayahs.id', '=', 'laporans.wilayah_id')  // Corrected this line: 'wilayahs' instead of 'wilayah'
    //     //     ->groupBy('wilayahs.kabupaten')
    //     //     ->get();

    //     // // Return the data as a JSON response
    //     // // Pass the data to the Blade view
    //     // return view('dashboard.index', [
    //     //     'totalReports' => $totalReports,
    //     //     'recipientsPerProgram' => $recipientsPerProgram,
    //     //     'distributionByProvince' => $distributionByProvince,
    //     //     'distributionByDistrict' => $distributionByDistrict,
    //     // ]);
    // }

    // public function index()
    // {
    //     return view('dashboard.index');
    // }
}
