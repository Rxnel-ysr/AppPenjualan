@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Analytics Dashboard</h1>

    <div class="row mb-4 gap-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Items that low on stock')}}</h5>
                </div>
                <div class="card-body">
                    @if ($items->isNotEmpty()) <table class="table table-dark table-hover table-sm rounded-3 shadow-lg table-custom" style="user-select: none;">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th scope="col">Name</th>
                                <th scope="col">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr class="hover-effect item-table" onclick="window.location='<?= route('item.index') ?>?name=<?= urlencode($item->name) ?>'" style="cursor: pointer;">
                                <td class="text-center">{{ $item->name }}</td>
                                <td class="text-center">{{ $item->qty }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="d-flex justify-content-center align-items-center">
                        <h4 class="card-tile text-muted">{{ __('All good.') }}</h4>
                    </div>
                    @endif
                </div>
                @if ($items->hasMorePages())
                <div class="card-footer">
                    {{ $items->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>

        <div class="row mb-6">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Gains</h5>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
        <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Line Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Sales 2023',
                    data: [65, 59, 80, 81, 56, 55],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Revenue Pie Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'pie',
            data: {
                labels: ['Products', 'Services', 'Subscriptions', 'Consulting'],
                datasets: [{
                    data: [300, 200, 150, 100],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });

        // Users Bar Chart
        const usersCtx = document.getElementById('usersChart').getContext('2d');
        const usersChart = new Chart(usersCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'New Users',
                    data: [45, 60, 75, 90, 100, 115],
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Tasks Doughnut Chart
        const tasksCtx = document.getElementById('tasksChart').getContext('2d');
        const tasksChart = new Chart(tasksCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Pending', 'Overdue'],
                datasets: [{
                    data: [120, 45, 30, 15],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(255, 99, 132, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                },
                cutout: '70%'
            }
        });

        // Performance Radar Chart
        const performanceCtx = document.getElementById('performanceChart').getContext('2d');
        const performanceChart = new Chart(performanceCtx, {
            type: 'radar',
            data: {
                labels: ['Sales', 'Marketing', 'Development', 'Support', 'Finance', 'HR'],
                datasets: [{
                    label: 'Department Performance',
                    data: [65, 59, 90, 81, 56, 55],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    pointBackgroundColor: 'rgba(153, 102, 255, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(153, 102, 255, 1)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                }
            }
        });
    });
</script> -->
        @endpush
        @endsection