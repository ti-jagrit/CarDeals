@extends('admin/adminDash')

@section('content')
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>
        <div class="row">
            <!-- Total Cars -->
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Cars</h5>
                        <p class="card-text">{{ $totalCars }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Meetings -->
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Meetings</h5>
                        <p class="card-text">{{ $totalMeetings }}</p>
                    </div>
                </div>
            </div>

            <!-- Average Price -->
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Average Car Price</h5>
                        <p class="card-text">{{ number_format($averagePrice, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meetings Per Year Chart -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>Meetings Per Year</h3>
                <canvas id="meetingsPerYearChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('meetingsPerYearChart').getContext('2d');
            var meetingsPerYear = @json($meetingsPerYear);

            var labels = meetingsPerYear.map(function(item) {
                return item.year;
            });

            var data = meetingsPerYear.map(function(item) {
                return item.count;
            });

            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Meetings',
                        data: data,
                        backgroundColor: '#fe5b29',
                        borderColor: '#fe5b29',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

    <style>
        .card {
            margin-bottom: 20px;
        }
    </style>
@endsection
