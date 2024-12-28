@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h3 class="card-title mb-4">Edit Laporan Penyaluran Bantuan</h3>
            <form action="{{ url('/api/laporans/' . $laporan->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf

                <!-- Program Selection -->
                <div class="form-group row">
                    <label for="program_id" class="col-sm-2 col-form-label">Program <i class="text-danger">*</i></label>
                    <div class="col-sm-10">
                        <select id="program_id" name="program_id" class="form-control" required>
                            <option value="">Select Program</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}" {{ $program->id == $laporan->program_id ? 'selected' : '' }}>
                                    {{ $program->nama_program }}
                                </option>
                            @endforeach
                        </select>
                        @error('program_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Province Selection -->
                <div class="form-group row">
                    <label for="provinsi" class="col-sm-2 col-form-label">Provinsi</label>
                    <div class="col-sm-10">
                        <select id="provinsi" name="provinsi" class="form-control">
                            @foreach ($provinsis as $provinsi)
                                <option value="{{ $provinsi->provinsi }}"
                                    {{ $laporan->wilayah->provinsi == $provinsi->provinsi ? 'selected' : '' }}>
                                    {{ $provinsi->provinsi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- District Selection -->
                <div class="form-group row">
                    <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten</label>
                    <div class="col-sm-10">
                        <select id="kabupaten" name="kabupaten" class="form-control">
                            @foreach ($kabupatens as $kabupaten)
                                <option value="{{ $kabupaten->kabupaten }}"
                                    {{ $laporan->wilayah->kabupaten == $kabupaten->kabupaten ? 'selected' : '' }}>
                                    {{ $kabupaten->kabupaten }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Sub-District Selection -->
                <div class="form-group row">
                    <label for="kecamatan" class="col-sm-2 col-form-label">Kecamatan</label>
                    <div class="col-sm-10">
                        <select id="kecamatan" name="kecamatan" class="form-control">
                            @foreach ($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->kecamatan }}"
                                    {{ $laporan->wilayah->kecamatan == $kecamatan->kecamatan ? 'selected' : '' }}>
                                    {{ $kecamatan->kecamatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Recipient Count -->
                <div class="form-group row">
                    <label for="jumlah_penerima" class="col-sm-2 col-form-label">Jumlah Penerima Bantuan <i class="text-danger">*</i></label>
                    <div class="col-sm-10">
                        <input name="jumlah_penerima" id="jumlah_penerima" type="number"
                               class="form-control @error('jumlah_penerima') is-invalid @enderror"
                               value="{{ old('jumlah_penerima') ?? $laporan->jumlah_penerima }}" required>
                        @error('jumlah_penerima')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Distribution Date -->
                <div class="form-group row">
                    <label for="tanggal_penyaluran" class="col-sm-2 col-form-label">Tanggal Penyaluran <i class="text-danger">*</i></label>
                    <div class="col-sm-10">
                        <input name="tanggal_penyaluran" id="tanggal_penyaluran" type="date"
                               class="form-control @error('tanggal_penyaluran') is-invalid @enderror"
                               value="{{ old('tanggal_penyaluran') ?? $laporan->tanggal_penyaluran }}" required>
                        @error('tanggal_penyaluran')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Proof of Distribution -->
                <div class="form-group row">
                    <label for="bukti_penyaluran" class="col-sm-2 col-form-label">Bukti Penyaluran <i class="text-danger">*</i></label>
                    <div class="col-sm-10">
                        @if ($laporan->bukti_penyaluran)
                            <div class="mb-2">
                                <label for="bukti_penyaluran">Existing File:</label>
                                <a href="{{ asset('storage/' . $laporan->bukti_penyaluran) }}" target="_blank">View File</a>
                            </div>
                        @endif
                        <div>
                            <label for="bukti_penyaluran">Upload New File:</label>
                            <input type="file" name="bukti_penyaluran" id="bukti_penyaluran">
                        </div>
                    </div>
                </div>

                <!-- Additional Notes -->
                <div class="form-group row">
                    <label for="catatan" class="col-sm-2 col-form-label">Catatan Tambahan</label>
                    <div class="col-sm-10">
                        <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror">
                            {{ old('catatan') ?? $laporan->catatan }}
                        </textarea>
                        @error('catatan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-secondary">Simpan</button>
                    </div>
                </div>

                <!-- Admin Actions: Approve or Reject -->
                @if ($laporan->status != 'Disetujui' && $laporan->status != 'Ditolak' && auth()->user()->role === 'admin')
                    <hr>
                    <button id="approveButton" class="btn btn-success">Approve</button>

                    <div id="reject-section" style="display: none;">
                        <label for="reason">Reason for Rejection</label>
                        <textarea name="reason" id="reason" rows="4" placeholder="Enter rejection reason" class="form-control"></textarea>
                        <button type="button" id="reject-submit-button" class="btn btn-danger">Reject and Submit</button>
                    </div>

                    <button type="button" id="reject-button" class="btn btn-danger">Reject</button>
                @endif
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Ajax for dynamic wilayah selection (Provinsi -> Kabupaten -> Kecamatan)
            $('#provinsi').change(function() {
                var provinsi = $(this).val();
                if (provinsi) {
                    $.ajax({
                        url: '/wilayahs/getKabupaten/' + provinsi,
                        type: 'GET',
                        success: function(data) {
                            var kabupatenSelect = $('#kabupaten');
                            kabupatenSelect.empty();
                            kabupatenSelect.append('<option value="">Select Kabupaten</option>');
                            $.each(data, function(index, kabupaten) {
                                kabupatenSelect.append('<option value="' + kabupaten.kabupaten + '">' + kabupaten.kabupaten + '</option>');
                            });
                            $('#kecamatan').empty().append('<option value="">Select Kecamatan</option>');
                        }
                    });
                } else {
                    $('#kabupaten').empty().append('<option value="">Select Kabupaten</option>');
                    $('#kecamatan').empty().append('<option value="">Select Kecamatan</option>');
                }
            });

            $('#kabupaten').change(function() {
                var kabupaten = $(this).val();
                if (kabupaten) {
                    $.ajax({
                        url: '/wilayahs/getKecamatan/' + kabupaten,
                        type: 'GET',
                        success: function(data) {
                            var kecamatanSelect = $('#kecamatan');
                            kecamatanSelect.empty();
                            kecamatanSelect.append('<option value="">Select Kecamatan</option>');
                            $.each(data, function(index, kecamatan) {
                                kecamatanSelect.append('<option value="' + kecamatan.kecamatan + '">' + kecamatan.kecamatan + '</option>');
                            });
                        }
                    });
                } else {
                    $('#kecamatan').empty().append('<option value="">Select Kecamatan</option>');
                }
            });

            // Handle approve and reject functionality
            $('#approveButton').click(function() {
                $(this).text('Approved').prop('disabled', true);
                $('#reject-section').hide();
            });

            $('#reject-button').click(function() {
                $('#reject-section').toggle();
            });

            $('#reject-submit-button').click(function() {
                var reason = $('#reason').val();
                if (reason) {
                    alert('Report rejected with reason: ' + reason);
                    $(this).prop('disabled', true);
                    $('#reject-button').prop('disabled', true);
                } else {
                    alert('Please provide a reason for rejection.');
                }
            });
        });
    </script>
@endsection
