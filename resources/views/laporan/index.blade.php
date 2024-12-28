@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Laporan</h1>
            <a href="{{ route('laporans.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> Tambah Laporan
            </a>
        </div>

        @if (session()->has('pesan'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session()->get('pesan') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Program</th>
                        <th>Jumlah Penerima</th>
                        <th>Wilayah</th>
                        <th>Tanggal Penyaluran</th>
                        <th>Bukti Penyaluran</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporans as $laporan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $laporan->program->nama_program }}</td>
                            <td>{{ $laporan->jumlah_penerima }}</td>
                            <td>{{ $laporan->wilayah->provinsi }}, {{ $laporan->wilayah->kabupaten }},
                                {{ $laporan->wilayah->kecamatan }}</td>
                            <td>{{ $laporan->tanggal_penyaluran }}</td>
                            <td>
                                @if ($laporan->bukti_penyaluran)
                                    <a href="{{ asset('storage/' . $laporan->bukti_penyaluran) }}" class="btn btn-outline-success btn-sm" download>
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                @else
                                    <span class="text-muted">No File</span>
                                @endif
                            </td>
                            <td>{{ $laporan->catatan }}</td>
                            <td>
                                <span class="badge {{ $laporan->status == 'Pending' ? 'bg-warning text-dark' : 'bg-success' }}">
                                    {{ $laporan->status }}
                                </span>
                            </td>
                            <td>
                                @if ($laporan->status == 'Pending')
                                    <a href="{{ route('laporans.edit', $laporan->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('laporans.destroy', $laporan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">Not Editable</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
