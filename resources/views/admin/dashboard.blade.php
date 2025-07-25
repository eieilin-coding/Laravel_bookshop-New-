<!-- resources/views/dashboard.blade.php -->
@extends('layouts.adminlte')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Dashboard Overview</h1>

        <div class="container-fluid">
            <!-- Small Box (Stat card) -->
            {{-- <h5 class="mb-2">Small Box</h5> --}}
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>{{ $totalBooks }}</h3>
                            <p>Total Books</p>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{ $totalDownload }}</sup></h3>
                            <p>Total Download Count</p>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box text-bg-secondary">
                        <div class="inner">
                            <h3>{{ $totalUsers }}</sup></h3>
                            <p>Total Users</p>
                        </div>
                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>{{ $totalCategories }}</h3>
                            <p>Total Category</p>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div>

        <div class="row">
            <!-- Top Books Bar Chart -->
            <div class="col-md-7 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Top 8 Books by Downloads</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="booksChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Categories Pie Chart -->
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Top 5 Categories by Downloads</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="categoriesChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Top Books Bar Chart
            const booksCtx = document.getElementById('booksChart').getContext('2d');
            const booksChart = new Chart(booksCtx, {
                type: 'bar',
                data: {
                    labels: @json($topBooks->pluck('title')),
                    datasets: [{
                        label: 'Download Count',
                        data: @json($topBooks->pluck('download_count')),
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Downloads: ${context.raw.toLocaleString()}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: { // This is the x-axis configuration
                            display: true, // Keep the axis itself, but hide the ticks/labels
                            ticks: {
                                display: false // Set this to false to hide the labels under the bars
                            },
                            grid: {
                                display: false // You might also want to hide the grid lines for a cleaner look
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            // Top Categories Pie Chart
            const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
            const categoriesChart = new Chart(categoriesCtx, {
                type: 'pie',
                data: {
                    labels: @json($topCategories->pluck('name')),
                    datasets: [{
                        data: @json($topCategories->pluck('books_sum_download_count')),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    // Get the entire dataset for the pie chart
                                    const allData = context.dataset.data;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = 0;
                                    if (total > 0) {
                                        percentage = Math.round((value / total) * 100);
                                    }
                                    return `${label}: ${value.toLocaleString()}%`;
                                }
                            }
                        }
                    }
                }
            });

            // Make charts responsive on window resize
            window.addEventListener('resize', function() {
                booksChart.resize();
                categoriesChart.resize();
            });
        });
    </script>
@endsection
