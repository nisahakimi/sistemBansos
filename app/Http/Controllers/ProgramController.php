<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $programs = Program::all();
        return view('program.index', ['programs' => $programs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $programs = Program::all();
        return view('program.create', ['programs' => $programs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'nama_program' => 'required',
        ]);

        Program::create($validatedData);
        return redirect()->route('programs.index')->with('success', 'Program berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $program = Program::find($id);
        return view('program.edit', ['program' => $program]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $validatedData = $request->validate([
            'nama_program' => 'required',
        ]);

        $program = Program::find($id);
        $program->update($request->all());
        return redirect()->route('programs.index')->with('success', 'Program berhasil diubah');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        //
        $program->delete();
        return redirect()->route('programs.index')->with('success', 'Program berhasil dihapus');
    }
}
