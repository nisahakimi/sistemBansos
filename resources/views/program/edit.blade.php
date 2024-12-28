@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title text-primary mb-4">Edit Data Program</h3>

            <!-- Form Start -->
            <form action="{{ route('programs.update', ['program' => $program->id]) }}" method="POST">
                @method('PATCH')
                @csrf

                <!-- Nama Program Field -->
                <div class="mb-3 row">
                    <label for="nama_program" class="col-sm-3 col-form-label text-md-end">Nama Program
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-9">
                        <input name="nama_program" id="nama_program" placeholder="Nama Program" type="text"
                            class="form-control @error('nama_program') is-invalid @enderror"
                            value="{{ old('nama_program') ?? $program->nama_program }}">
                        @error('nama_program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-success w-100">Simpan</button>
                    </div>
                </div>
            </form>
            <!-- Form End -->
        </div>
    </div>
@endsection
