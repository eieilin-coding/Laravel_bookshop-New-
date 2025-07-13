<!-- resources/views/dashboard.blade.php -->
@extends('layouts.adminlte')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Books Dashboard</h1>
    
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
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value.toLocaleString()} (${percentage}%)`;
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