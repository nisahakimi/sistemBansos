@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Formulir Laporan Penyaluran Bantuan</h2>

    <form id="laporanForm" method="POST" action="{{ url('/api/laporans') }}" enctype="multipart/form-data">
        @csrf

        <!-- Program Dropdown -->
        <div class="form-group">
            <label for="program_id">Program:</label>
            <select id="program_id" name="program_id" class="form-control" required>
                <option value="">Select Program</option>
                @foreach ($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                @endforeach
            </select>
            <div id="program-error" class="invalid-feedback"></div>
        </div>

        <!-- Provinsi Dropdown -->
        <div class="form-group mt-3">
            <label for="provinsi">Provinsi:</label>
            <select id="provinsi" name="provinsi" class="form-control" required>
                <option value="">Select Provinsi</option>
                @foreach ($provinsis as $provinsi)
                    <option value="{{ $provinsi->provinsi }}">{{ $provinsi->provinsi }}</option>
                @endforeach
            </select>
        </div>

        <!-- Kabupaten Dropdown -->
        <div class="form-group mt-3">
            <label for="kabupaten">Kabupaten:</label>
            <select id="kabupaten" name="kabupaten" class="form-control" required>
                <option value="">Select Kabupaten</option>
            </select>
        </div>

        <!-- Kecamatan Dropdown -->
        <div class="form-group mt-3">
            <label for="kecamatan">Kecamatan:</label>
            <select id="kecamatan" name="kecamatan" class="form-control" required>
                <option value="">Select Kecamatan</option>
            </select>
        </div>

        <!-- Jumlah Penerima Bantuan Field -->
        <div class="form-group mt-3">
            <label for="jumlah_penerima">Jumlah Penerima Bantuan</label>
            <input type="number" name="jumlah_penerima" id="jumlah_penerima" class="form-control" required>
        </div>

        <!-- Tanggal Penyaluran Field -->
        <div class="form-group mt-3">
            <label for="tanggal_penyaluran">Tanggal Penyaluran</label>
            <input type="date" name="tanggal_penyaluran" id="tanggal_penyaluran" class="form-control" required>
        </div>

        <!-- Bukti Penyaluran Field -->
        <div class="form-group mt-3">
            <label for="bukti_penyaluran">Bukti Penyaluran</label>
            <input type="file" name="bukti_penyaluran" id="bukti_penyaluran" class="form-control" required>
        </div>

        <!-- Catatan Field -->
        <div class="form-group mt-3">
            <label for="catatan">Catatan Tambahan</label>
            <textarea name="catatan" id="catatan" class="form-control"></textarea>
        </div>

        <!-- Submit Button -->
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // When Provinsi is selected
        $('#provinsi').change(function () {
            var provinsi = $(this).val();
            if (provinsi) {
                $.ajax({
                    url: '/wilayahs/getKabupaten/' + provinsi,
                    type: 'GET',
                    success: function (data) {
                        var kabupatenSelect = $('#kabupaten');
                        kabupatenSelect.empty();
                        kabupatenSelect.append('<option value="">Select Kabupaten</option>');
                        $.each(data, function (index, kabupaten) {
                            kabupatenSelect.append('<option value="' + kabupaten.kabupaten + '">' + kabupaten.kabupaten + '</option>');
                        });
                        // Reset Kecamatan select
                        $('#kecamatan').empty().append('<option value="">Select Kecamatan</option>');
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error: " + status + error);
                    }
                });
            } else {
                $('#kabupaten').empty().append('<option value="">Select Kabupaten</option>');
                $('#kecamatan').empty().append('<option value="">Select Kecamatan</option>');
            }
        });

        // When Kabupaten is selected
        $('#kabupaten').change(function () {
            var kabupaten = $(this).val();
            if (kabupaten) {
                $.ajax({
                    url: '/wilayahs/getKecamatan/' + kabupaten,
                    type: 'GET',
                    success: function (data) {
                        var kecamatanSelect = $('#kecamatan');
                        kecamatanSelect.empty();
                        kecamatanSelect.append('<option value="">Select Kecamatan</option>');
                        $.each(data, function (index, kecamatan) {
                            kecamatanSelect.append('<option value="' + kecamatan.kecamatan + '">' + kecamatan.kecamatan + '</option>');
                        });
                    }
                });
            } else {
                $('#kecamatan').empty().append('<option value="">Select Kecamatan</option>');
            }
        });
    });

    // Handle form submission with AJAX
    $('#laporanForm').submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        var formData = new FormData(this); // Create a FormData object

        $.ajax({
            url: '/api/laporans', // API endpoint
            type: 'POST',
            data: formData,
            processData: false,  // Prevent jQuery from processing data
            contentType: false,  // Allow the browser to set content type
            success: function (response) {
                alert('Laporan submitted successfully!');
                // Optionally clear the form or redirect
                $('#laporanForm')[0].reset(); // Reset the form after success
                window.location.href = '/laporans'; // Redirect to the reports list
            },
            error: function (xhr, status, error) {
                alert('There was an error with the form submission.');
                console.log(xhr.responseText);
            }
        });
    });
</script>
@endsection
