<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Program;
use App\Models\Wilayah;
use Dotenv\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $laporans = Laporan::all()->sortBy('id');;
        $programs = Program::all();
        $wilayahs = Wilayah::all();
        return view('laporan.index', ['laporans' => $laporans, 'programs' => $programs, 'wilayahs' => $wilayahs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $programs = Program::all();

        // $provinsi = Wilayah::select('provinsi')->distinct()->get();
        // $wilayahs = Wilayah::all();
        $provinsis = Wilayah::distinct()->get(['provinsi']);

        $laporans = Laporan::all();
        return view('laporan.create', compact('programs', 'provinsis', 'laporans'));
        // return view('laporan.create', ['programs' => $programs, 'wilayahs' => $wilayahs, 'laporans' => $laporans]);

    }



    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        //
        $wilayah = Wilayah::where('provinsi', $request->provinsi)
            ->where('kabupaten', $request->kabupaten)
            ->where('kecamatan', $request->kecamatan)
            ->first();

        // Jika wilayah ditemukan
        if (!$wilayah) {
            return response()->json(['pesan' => 'Wilayah tidak ditemukan'], 404);
        }

        // Validate incoming request data
        $validated = $request->validate([
            'program_id' => 'required',
            'jumlah_penerima' => 'required',
            'tanggal_penyaluran' => 'required|date',

            // 'kabupaten' => 'required',
            // 'kecamatan' => 'required',
            'bukti_penyaluran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'catatan' => 'nullable|string',
        ]);

        // Create the laporan (you can handle file uploads here if needed)
        $laporan = Laporan::create([
            'program_id' => $validated['program_id'],
            'jumlah_penerima' => $validated['jumlah_penerima'],
            'tanggal_penyaluran' => $validated['tanggal_penyaluran'],
            'wilayah_id' => $wilayah->id,
            // 'kabupaten' => $validated['kabupaten'],
            // 'kecamatan' => $validated['kecamatan'],
            'catatan' => $validated['catatan'] ?? null,
            'bukti_penyaluran' => $request->file('bukti_penyaluran')->store('uploads', 'public'), // Adjust this path as needed
        ]);

        // return response()->json([
        //     'pesan' => 'Laporan created successfully!',
        //     'data' => $laporan
        // ], 201);
        return redirect()->route('laporans.index')->with('pesan', 'Laporan created successfully!');
        // $request->validate([
        //     'program_id' => 'required|exists:programs,id',
        //     'provinsi' => 'required|string',
        //     'kabupaten' => 'required|string',
        //     'kecamatan' => 'required|string',
        //     'jumlah_penerima' => 'required|integer',
        //     'tanggal_penyaluran' => 'required|date',
        //     'bukti_penyaluran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // Max 10MB
        //     'catatan' => 'nullable|string',
        // ]);

        // // Handle the uploaded file
        // if ($request->hasFile('bukti_penyaluran')) {
        //     $buktiPenyaluranPath = $request->file('bukti_penyaluran')->store('bukti_penyaluran', 'public');
        // } else {
        //     $buktiPenyaluranPath = null;
        // }

        // // Create a new Laporan record
        // $laporan = new Laporan();
        // $laporan->program_id = $request->program_id;
        // $laporan->provinsi = $request->provinsi;
        // $laporan->kabupaten = $request->kabupaten;
        // $laporan->kecamatan = $request->kecamatan;
        // $laporan->jumlah_penerima = $request->jumlah_penerima;
        // $laporan->tanggal_penyaluran = $request->tanggal_penyaluran;
        // $laporan->bukti_penyaluran = $buktiPenyaluranPath;
        // $laporan->catatan = $request->catatan;
        // $laporan->save();

        // // Return success response or redirect
        // return redirect()->route('laporans.index')->with('success', 'Laporan successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Laporan $laporan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        // $programs = Program::all();
        // Fetch the specific laporan with the associated wilayah
        $laporan = Laporan::with('wilayah')->findOrFail($id);

        // Fetch all wilayah data for selection
        $programs = Program::all();
        $provinsis = Wilayah::distinct()->get(['provinsi']);
        $kabupatens = Wilayah::distinct()->get(['kabupaten']);
        $kecamatans = Wilayah::distinct()->get(['kecamatan']);
        return view('laporan.edit', compact('programs', 'provinsis', 'laporan', 'kabupatens', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        //
        $validatedData = $request->validate([
            'program_id' => 'required',
            'jumlah_penerima' => 'required',
            'tanggal_penyaluran' => 'required|date',
            'bukti_penyaluran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'catatan' => 'nullable|string',
        ]);
        // dd($validatedData);

        $laporan = Laporan::findOrFail($id);
        // Find the corresponding wilayah by provinsi, kabupaten, and kecamatan
        $wilayah = Wilayah::where('provinsi',  $request->provinsi)
            ->where('kabupaten', $request->kabupaten)
            ->where('kecamatan', $request->kecamatan)
            ->first();

        if (!$wilayah) {
            return redirect()->back()->withErrors('Wilayah data not found.');
        }

        if ($request->hasFile('bukti_penyaluran')) {
            // Delete the old file from storage if it exists
            if ($laporan->bukti_penyaluran) {
                Storage::disk('public')->delete($laporan->bukti_penyaluran);
            }

            // Store the new file
            $path = $request->file('bukti_penyaluran')->store('uploads', 'public');
        } else {
            // If no new file is uploaded, keep the old file path
            $path = $laporan->bukti_penyaluran;
        }
        // dd($validatedData, $laporan->getDirty());


        // Update the laporan (you can handle file uploads here if needed)
        $laporan->update([
            'program_id' => $validatedData['program_id'],
            'jumlah_penerima' => $validatedData['jumlah_penerima'],
            'tanggal_penyaluran' => $validatedData['tanggal_penyaluran'],
            'wilayah_id' => $wilayah->id,
            'catatan' => $validatedData['catatan'] ?? null,
            // 'bukti_penyaluran' => $request->file('bukti_penyaluran') ? $request->file('bukti_penyaluran')->store('uploads', 'public') : $laporan->bukti_penyaluran,
            'bukti_penyaluran' => $path,
        ]);
        // return response()->json([
        //     'pesan' => 'Laporan updated successfully!',
        //     'data' => $laporan
        // ], 200);
        // dd($laporan->fresh());
        return redirect()->route('laporans.index')->with('pesan', 'Laporan updated successfully!');
        // return response()->json([
        //         'pesan' => 'Laporan created successfully!',
        //         'data' => $laporan
        //     ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laporan $laporan)
    {
        //
        $laporan->delete();
        return redirect()->route('laporans.index')->with('pesan', 'Laporan deleted successfully!');
    }

    public function approve($id)
    {
        $laporan = Laporan::find($id);

        if (!$laporan) {
            return response()->json(['error' => 'Laporan not found'], 404);
        }

        $laporan->status = 'Disetujui';
        $laporan->save();

        return response()->json(['message' => 'Laporan telah disetujui']);
    }

    public function reject(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $laporan->status = 'Ditolak';
        $laporan->alasan = $request->input('alasan');
        $laporan->save();

        return response()->json(['message' => 'Laporan has been rejected.'], 200);
    }

    // public function getDashboardData()
    // {
    //     // Fetch the total number of reports
    //     $totalLaporan = Laporan::count();

    //     // Fetch the total number of recipients
    //     $jumlahPenerima = Laporan::sum('jumlah_penerima');

    //     // Fetch reports per region (wilayah)
    //     $laporanPerWilayah = Laporan::select('wilayah_id', Laporan::raw('count(*) as count'))
    //         ->groupBy('wilayah_id')
    //         ->get();

    //     // Return as JSON response
    //     return response()->json([
    //         'totalLaporan' => $totalLaporan,
    //         'jumlahPenerima' => $jumlahPenerima,
    //         'laporanPerWilayah' => $laporanPerWilayah
    //     ]);
    // }

    public function dashboard()
    {
        // Fetch the reports grouped by 'wilayah' and count them
        $reports = DB::table('laporans')
            ->select('wilayah_id', DB::raw('count(*) as count'))
            ->groupBy('wilayah_id')
            ->get();

        // Fetch wilayah names from the wilayahs table
        $wilayahs = DB::table('wilayahs')->pluck('provinsi', 'id');

        // Combine the reports and wilayahs data
        $reportData = $reports->map(function ($report) use ($wilayahs) {
            return [
                'wilayah' => $wilayahs[$report->wilayah_id] ?? 'Unknown',
                'count' => $report->count
            ];
        });

        // Fetch total number of reports
        $totalReports = DB::table('laporans')->count();

        $programData = DB::table('laporans')
            ->select('program_id', DB::raw('sum(jumlah_penerima) as total_penerima'))
            ->groupBy('program_id')
            ->get();

        // Fetch program names from the programs table (assuming you have a programs table with the program names)
        $programNames = DB::table('programs')->pluck('nama_program', 'id');

        // Combine the program data
        $programStats = $programData->mapWithKeys(function ($item) use ($programNames) {
            return [
                $programNames[$item->program_id] ?? 'Unknown Program' => $item->total_penerima
            ];
        });

        // Fetch the number of reports per wilayah
        $wilayahData = DB::table('laporans')
        ->join('wilayahs', 'laporans.wilayah_id', '=', 'wilayahs.id')
        ->select('wilayahs.provinsi', 'wilayahs.kabupaten', DB::raw('sum(laporans.jumlah_penerima) as total_penerima'))
        ->groupBy('laporans.wilayah_id', 'wilayahs.provinsi', 'wilayahs.kabupaten')
        ->get();

        return view('dashboard.index', compact('reportData', 'totalReports', 'programStats', 'wilayahData'));
    }
}
