<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $wilayahs = Wilayah::all();
        return view('wilayah.index', ['wilayahs' => $wilayahs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $wilayahs = Wilayah::all();
        return view('wilayah.create', ['wilayahs' => $wilayahs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kode_pos' => 'required',
        ]);
        Wilayah::create($validatedData);
        return redirect()->route('wilayahs.index')->with('success', 'Wilayah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wilayah $wilayah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $wilayah = Wilayah::find($id);
        return view('wilayah.edit', ['wilayah' => $wilayah]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wilayah $wilayah)
    {
        //
        $validatedData = $request->validate([
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kode_pos' => 'required',
        ]);
        $wilayah->update($validatedData);
        return redirect()->route('wilayahs.index')->with('success', 'Wilayah berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wilayah $wilayah)
    {
        //
        $wilayah->delete();
        return redirect()->route('wilayahs.index')->with('success', 'Wilayah berhasil dihapus');
    }

      // Fetch Kabupaten based on Provinsi
    public function getKabupaten($provinsi)
    {
        // Fetch kabupaten where provinsi matches
        $kabupatens = Wilayah::where('provinsi', $provinsi)->distinct()->get(['id', 'kabupaten']);

        return response()->json($kabupatens);
    }

    // Fetch Kecamatan based on Kabupaten
    public function getKecamatan($kabupaten)
    {
        // Fetch kecamatan where kabupaten matches
        $kecamatans = Wilayah::where('kabupaten', $kabupaten)->distinct()->get(['id', 'kecamatan']);

        return response()->json($kecamatans);
    }
}
