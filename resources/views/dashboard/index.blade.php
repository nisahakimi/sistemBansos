@extends('layouts.app')

@section('title', 'Dashboard Monitoring Laporan')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center text-primary">Dashboard Monitoring Laporan</h3>

                <!-- Total Reports -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Laporan</h5>
                                <p class="card-text">{{ $totalReports }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Program-wise Recipients -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-success">Jumlah Penerima Bantuan per Program</h5>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Program</th>
                                    <th>Jumlah Penerima</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programStats as $program => $totalPenerima)
                                    <tr>
                                        <td>{{ $program }}</td>
                                        <td>{{ $totalPenerima }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Table for wilayah data -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-warning">Penyaluran Bantuan per Wilayah</h5>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Wilayah</th>
                                    <th>Total Penerima Bantuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wilayahData as $data)
                                    <tr>
                                        <td>{{ $data->provinsi }} / {{ $data->kabupaten }}</td>
                                        <td>{{ $data->total_penerima }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Chart for wilayah data -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <canvas id="wilayahChart" width="400" height="200"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Prepare data for the wilayah chart
        var wilayahData = @json($wilayahData);

        var chartLabels = wilayahData.map(function(data) {
            return data.provinsi + ' / ' + data.kabupaten; // Combine province and district
        });

        var chartCounts = wilayahData.map(function(data) {
            return data.total_penerima;
        });

        // Create the wilayah chart
        var ctx = document.getElementById('wilayahChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Jumlah Penerima Bantuan per Wilayah',
                    data: chartCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Light blue color for bars
                    borderColor: 'rgba(54, 162, 235, 1)', // Dark blue for borders
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            fontSize: 12,
                            fontColor: '#333'
                        }
                    },
                    x: {
                        ticks: {
                            fontSize: 12,
                            fontColor: '#333'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endsection
