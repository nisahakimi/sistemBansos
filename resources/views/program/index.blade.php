@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <!-- Page Header and Create Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Programs</h1>
            <a href="{{ route('programs.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> Create Program
            </a>
        </div>

        <!-- Success Message -->
        @if (session()->has('pesan'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session()->get('pesan') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Programs Table -->
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Program Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($programs as $program)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $program->nama_program }}</td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('programs.edit', $program->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('programs.destroy', $program->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this program?');">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
