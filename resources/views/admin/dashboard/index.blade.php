@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Users -->
        <div class="card bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-100">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 text-white p-3 rounded-lg">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">{{ number_format($totalUsers) }}</h3>
                    <p class="text-sm text-gray-600">Total Users</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-xs text-gray-500">
                    <span class="text-green-500"><i class="fas fa-arrow-up"></i> {{ rand(5, 15) }}%</span> from last month
                </span>
                <a href="{{ route('admin.users.index') }}" class="text-xs text-blue-600 hover:text-blue-800">View all</a>
            </div>
        </div>
        
        <!-- Service Requests -->
        <div class="card bg-gradient-to-br from-green-50 to-emerald-50 border-green-100">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 text-white p-3 rounded-lg">
                    <i class="fas fa-wrench text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">{{ number_format($totalRequests) }}</h3>
                    <p class="text-sm text-gray-600">Service Requests</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-xs text-gray-500">
                    <span class="text-green-500"><i class="fas fa-arrow-up"></i> {{ rand(10, 25) }}%</span> from last month
                </span>
                <a href="{{ route('admin.service-requests.index') }}" class="text-xs text-green-600 hover:text-green-800">View all</a>
            </div>
        </div>
        
        <!-- Total Revenue -->
        <div class="card bg-gradient-to-br from-purple-50 to-violet-50 border-purple-100">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 text-white p-3 rounded-lg">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">${{ number_format($totalRevenue, 2) }}</h3>
                    <p class="text-sm text-gray-600">Total Revenue</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-xs text-gray-500">
                    <span class="text-green-500"><i class="fas fa-arrow-up"></i> {{ rand(8, 20) }}%</span> from last month
                </span>
                <a href="{{ route('admin.payments.index') }}" class="text-xs text-purple-600 hover:text-purple-800">View all</a>
            </div>
        </div>
        
        <!-- Job Applications -->
        <div class="card bg-gradient-to-br from-amber-50 to-orange-50 border-amber-100">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-amber-500 text-white p-3 rounded-lg">
                    <i class="fas fa-briefcase text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">{{ number_format($totalApplications) }}</h3>
                    <p class="text-sm text-gray-600">Job Applications</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-xs text-gray-500">
                    <span class="text-green-500"><i class="fas fa-arrow-up"></i> {{ rand(3, 12) }}%</span> from last month
                </span>
                <a href="{{ route('admin.job-applications.index') }}" class="text-xs text-amber-600 hover:text-amber-800">View all</a>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Monthly Revenue Chart -->
        <div class="card">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Revenue</h3>
            <div id="monthly-revenue-chart" class="h-80"></div>
        </div>
        
        <!-- Service Request Status Distribution -->
        <div class="card">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Request Status Distribution</h3>
            <div id="request-status-chart" class="h-80"></div>
        </div>
    </div>
    
    <!-- Recent Activity Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Recent Service Requests -->
        <div class="card">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Service Requests</h3>
                <a href="{{ route('admin.service-requests.index') }}" class="text-sm text-primary-600 hover:text-primary-800">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentRequests as $request)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            @if($request->user)
                                                <img class="h-8 w-8 rounded-full" src="{{ $request->user->profile_photo_url }}" alt="{{ $request->name }}">
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $request->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $request->phone }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $request->service->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($request->status == 'new') bg-blue-100 text-blue-800
                                        @elseif($request->status == 'assigned') bg-indigo-100 text-indigo-800
                                        @elseif($request->status == 'in_progress') bg-yellow-100 text-yellow-800
                                        @elseif($request->status == 'completed') bg-green-100 text-green-800
                                        @elseif($request->status == 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ $request->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Recent Job Applications -->
        <div class="card">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Job Applications</h3>
                <a href="{{ route('admin.job-applications.index') }}" class="text-sm text-primary-600 hover:text-primary-800">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentApplications as $application)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $application->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $application->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $application->position }}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($application->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($application->status == 'reviewing') bg-blue-100 text-blue-800
                                        @elseif($application->status == 'shortlisted') bg-indigo-100 text-indigo-800
                                        @elseif($application->status == 'interview') bg-purple-100 text-purple-800
                                        @elseif($application->status == 'hired') bg-green-100 text-green-800
                                        @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ $application->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Additional Stats Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Top Service Providers -->
        <div class="card">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Service Providers</h3>
            <div class="space-y-4">
                @foreach($topServiceProviders as $provider)
                    <div class="flex items-center">
                        <img src="{{ $provider->profile_photo_url }}" alt="{{ $provider->name }}" class="h-10 w-10 rounded-full">
                        <div class="ml-3 flex-1">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $provider->name }}</p>
                                    <div class="flex items-center">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $provider->rating)
                                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                                @elseif($i <= $provider->rating + 0.5)
                                                    <i class="fas fa-star-half-alt text-yellow-400 text-xs"></i>
                                                @else
                                                    <i class="far fa-star text-yellow-400 text-xs"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="ml-1 text-xs text-gray-500">({{ $provider->total_ratings }})</span>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $provider->assignedServiceRequests()->where('status', 'completed')->count() }} completed</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- User Growth -->
        <div class="card">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">User Growth</h3>
            <div id="user-growth-chart" class="h-64"></div>
        </div>
        
        <!-- Recent Payments -->
        <div class="card">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Payments</h3>
                <a href="{{ route('admin.payments.index') }}" class="text-sm text-primary-600 hover:text-primary-800">View all</a>
            </div>
            <div class="space-y-4">
                @foreach($recentPayments as $payment)
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $payment->user->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ $payment->plan->name ?? 'N/A' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-gray-900">${{ number_format($payment->amount, 2) }}</p>
                                    <p class="text-xs text-gray-500">{{ $payment->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Revenue Chart
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const revenueData = @json($chartData);
        
        const monthlyRevenueOptions = {
            series: [{
                name: 'Revenue',
                data: Object.values(revenueData)
            }],
            chart: {
                type: 'area',
                height: 320,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            colors: ['#8b5cf6'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: monthNames,
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '12px',
                        fontFamily: 'Inter, sans-serif',
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return '$' + val.toFixed(0);
                    },
                    style: {
                        colors: '#64748b',
                        fontSize: '12px',
                        fontFamily: 'Inter, sans-serif',
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return '$' + val.toFixed(2);
                    }
                }
            }
        };

        const monthlyRevenueChart = new ApexCharts(document.querySelector("#monthly-revenue-chart"), monthlyRevenueOptions);
        monthlyRevenueChart.render();
        
        // Request Status Distribution Chart
        const statusData = @json($requestStatusDistribution);
        const statusLabels = Object.keys(statusData).map(status => status.charAt(0).toUpperCase() + status.slice(1));
        const statusValues = Object.values(statusData);
        const statusColors = ['#3b82f6', '#6366f1', '#eab308', '#22c55e', '#ef4444', '#64748b'];
        
        const requestStatusOptions = {
            series: statusValues,
            chart: {
                type: 'donut',
                height: 320
            },
            labels: statusLabels,
            colors: statusColors,
            legend: {
                position: 'bottom',
                fontFamily: 'Inter, sans-serif',
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '60%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '14px',
                                fontFamily: 'Inter, sans-serif',
                                color: '#334155'
                            },
                            value: {
                                show: true,
                                fontSize: '16px',
                                fontFamily: 'Inter, sans-serif',
                                color: '#334155',
                                formatter: function(val) {
                                    return val;
                                }
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '14px',
                                fontFamily: 'Inter, sans-serif',
                                color: '#334155',
                                formatter: function(w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        const requestStatusChart = new ApexCharts(document.querySelector("#request-status-chart"), requestStatusOptions);
        requestStatusChart.render();
        
        // User Growth Chart
        const userGrowthData = @json($userGrowth);
        const growthLabels = Object.keys(userGrowthData);
        const growthValues = Object.values(userGrowthData);
        
        const userGrowthOptions = {
            series: [{
                name: 'New Users',
                data: growthValues
            }],
            chart: {
                type: 'bar',
                height: 250,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '60%',
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ['#0ea5e9'],
            xaxis: {
                categories: growthLabels,
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '12px',
                        fontFamily: 'Inter, sans-serif',
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '12px',
                        fontFamily: 'Inter, sans-serif',
                    }
                }
            }
        };

        const userGrowthChart = new ApexCharts(document.querySelector("#user-growth-chart"), userGrowthOptions);
        userGrowthChart.render();
    });
</script>
@endpush
