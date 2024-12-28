@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title text-primary mb-4">Form Wilayah</h3>

            <!-- Form Start -->
            <form action="{{ route('wilayahs.store') }}" method="POST">
                @csrf

                <!-- Provinsi Field -->
                <div class="mb-3 row">
                    <label for="provinsi" class="col-sm-3 col-form-label text-md-end">Provinsi
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-9">
                        <input name="provinsi" id="provinsi" placeholder="Provinsi" type="text"
                            class="form-control @error('provinsi') is-invalid @enderror"
                            value="{{ old('provinsi') }}">
                        @error('provinsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Kabupaten Field -->
                <div class="mb-3 row">
                    <label for="kabupaten" class="col-sm-3 col-form-label text-md-end">Kabupaten
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-9">
                        <input name="kabupaten" id="kabupaten" placeholder="Kabupaten" type="text"
                            class="form-control @error('kabupaten') is-invalid @enderror"
                            value="{{ old('kabupaten') }}">
                        @error('kabupaten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Kecamatan Field -->
                <div class="mb-3 row">
                    <label for="kecamatan" class="col-sm-3 col-form-label text-md-end">Kecamatan
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-9">
                        <input name="kecamatan" id="kecamatan" placeholder="Kecamatan" type="text"
                            class="form-control @error('kecamatan') is-invalid @enderror"
                            value="{{ old('kecamatan') }}">
                        @error('kecamatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Kode Pos Field -->
                <div class="mb-3 row">
                    <label for="kode_pos" class="col-sm-3 col-form-label text-md-end">Kode Pos
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-9">
                        <input name="kode_pos" id="kode_pos" placeholder="Kode Pos" type="text"
                            class="form-control @error('kode_pos') is-invalid @enderror"
                            value="{{ old('kode_pos') }}">
                        @error('kode_pos')
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
