@extends('admin.layouts.material')

@section('title', 'Service Types')
@section('page_title', 'Service Types')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Service Types List -->
    <div class="lg:col-span-2">
        <div class="md-card md-card-elevated">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <h2 class="text-xl font-medium text-on-surface-high">Service Types</h2>
                    
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.service-types') }}" class="md-chip {{ !request('status') ? 'md-chip-filled' : 'md-chip-outlined' }}">
                            All
                        </a>
                        <a href="{{ route('admin.service-types', ['status' => 'active']) }}" class="md-chip {{ request('status') == 'active' ? 'md-chip-filled md-chip-success' : 'md-chip-outlined' }}">
                            Active
                        </a>
                        <a href="{{ route('admin.service-types', ['status' => 'inactive']) }}" class="md-chip {{ request('status') == 'inactive' ? 'md-chip-filled md-chip-error' : 'md-chip-outlined' }}">
                            Inactive
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <form action="{{ route('admin.service-types') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    
                    <div class="md-input-field flex-1">
                        <input type="text" id="search" name="search" value="{{ request('search') }}" class="md-input">
                        <label for="search">Search by name or description</label>
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="md-btn md-btn-filled">
                            <span class="material-icons mr-1">search</span>
                            Search
                        </button>
                        
                        <a href="{{ route('admin.service-types') }}" class="md-btn md-btn-outlined">
                            <span class="material-icons mr-1">clear</span>
                            Clear
                        </a>
                    </div>
                </form>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                    <thead class="bg-surface-2 dark:bg-surface-2-dark">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Service Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Base Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-on-surface-medium uppercase tracking-wider">Usage</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-on-surface-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-surface-1 dark:bg-surface-1-dark divide-y divide-neutral-200 dark:divide-neutral-700">
                        @forelse($serviceTypes as $serviceType)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center overflow-hidden">
                                        @if($serviceType->icon)
                                            <img src="{{ asset('storage/' . $serviceType->icon) }}" alt="{{ $serviceType->name }}" class="h-10 w-10 object-cover">
                                        @else
                                            <span class="material-icons text-primary-500 dark:text-primary-400">build</span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-on-surface-high">{{ $serviceType->name }}</div>
                                        <div class="text-sm text-on-surface-medium">{{ Str::limit($serviceType->description, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-on-surface-high">{{ settings('currency_symbol', '$') }}{{ number_format($serviceType->base_price, 2) }}</div>
                                @if($serviceType->has_additional_charges)
                                    <div class="text-xs text-on-surface-medium">+ Additional charges may apply</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($serviceType->is_active)
                                    <span class="md-chip md-chip-success">Active</span>
                                @else
                                    <span class="md-chip md-chip-error">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-on-surface-high">{{ $serviceType->request_count }} requests</div>
                                <div class="text-sm text-on-surface-medium">{{ $serviceType->provider_count }} providers</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button type="button" class="md-btn md-btn-icon md-btn-text" 
                                        onclick="editServiceType({{ $serviceType->id }}, '{{ $serviceType->name }}', '{{ $serviceType->description }}', {{ $serviceType->base_price }}, {{ $serviceType->has_additional_charges ? 'true' : 'false' }}, {{ $serviceType->is_active ? 'true' : 'false' }})"
                                        title="Edit Service Type">
                                    <span class="material-icons">edit</span>
                                </button>
                                
                                @if($serviceType->is_active)
                                    <form action="{{ route('admin.service-types.toggle-status', $serviceType->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_active" value="0">
                                        <button type="submit" class="md-btn md-btn-icon md-btn-text text-error-500" title="Deactivate Service Type" onclick="return confirm('Are you sure you want to deactivate this service type?')">
                                            <span class="material-icons">block</span>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.service-types.toggle-status', $serviceType->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_active" value="1">
                                        <button type="submit" class="md-btn md-btn-icon md-btn-text text-success-500" title="Activate Service Type">
                                            <span class="material-icons">check_circle</span>
                                        </button>
                                    </form>
                                @endif
                                
                                @if($serviceType->request_count == 0)
                                    <form action="{{ route('admin.service-types.destroy', $serviceType->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="md-btn md-btn-icon md-btn-text text-error-500" title="Delete Service Type" onclick="return confirm('Are you sure you want to delete this service type? This action cannot be undone.')">
                                            <span class="material-icons">delete</span>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-on-surface-medium">
                                <div class="flex flex-col items-center py-6">
                                    <span class="material-icons text-4xl text-on-surface-disabled mb-2">build</span>
                                    <p class="text-on-surface-medium mb-4">No service types found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($serviceTypes->hasPages())
            <div class="p-6 border-t border-neutral-200 dark:border-neutral-700">
                <div class="md-pagination">
                    {{ $serviceTypes->appends(request()->except('page'))->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Add/Edit Service Type -->
    <div class="lg:col-span-1">
        <div class="md-card md-card-elevated sticky top-6">
            <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-xl font-medium text-on-surface-high" id="form-title">Add New Service Type</h2>
            </div>
            
            <div class="p-6">
                <form id="serviceTypeForm" action="{{ route('admin.service-types.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div id="method-field"></div>
                    
                    <div class="md-input-field">
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="md-input" required>
                        <label for="name">Service Type Name</label>
                        @error('name')
                            <span class="text-error-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="md-input-field">
                        <textarea id="description" name="description" class="md-input" rows="3" required>{{ old('description') }}</textarea>
                        <label for="description">Description</label>
                        @error('description')
                            <span class="text-error-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="md-input-field">
                        <div class="flex items-center">
                            <span class="text-on-surface-medium mr-2">{{ settings('currency_symbol', '$') }}</span>
                            <input type="number" id="base_price" name="base_price" value="{{ old('base_price') }}" class="md-input" min="0" step="0.01" required>
                        </div>
                        <label for="base_price">Base Price</label>
                        @error('base_price')
                            <span class="text-error-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="md-input-field">
                        <div class="md-file-input">
                            <input type="file" id="icon" name="icon" accept="image/*">
                            <label for="icon">
                                <span class="material-icons mr-2">upload_file</span>
                                <span id="file-name">Choose Icon Image</span>
                            </label>
                        </div>
                        <div class="text-xs text-on-surface-medium mt-1">Recommended size: 128x128px</div>
                        @error('icon')
                            <span class="text-error-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="flex items-center">
                        <div class="md-checkbox">
                            <input type="checkbox" id="has_additional_charges" name="has_additional_charges" value="1" {{ old('has_additional_charges') ? 'checked' : '' }}>
                            <label for="has_additional_charges">Allow Additional Charges</label>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="md-checkbox">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active">Active</label>
                        </div>
                    </div>
                    
                    <div class="flex justify-between">
                        <button type="button" id="resetButton" class="md-btn md-btn-outlined" onclick="resetForm()">
                            <span class="material-icons mr-1">refresh</span>
                            Reset
                        </button>
                        
                        <button type="submit" class="md-btn md-btn-filled">
                            <span class="material-icons mr-1" id="submit-icon">add</span>
                            <span id="submit-text">Add Service Type</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Service Type Statistics -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Usage Statistics -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h2 class="text-lg font-medium text-on-surface-high">Service Type Usage</h2>
        </div>
        
        <div class="p-6">
            <div class="h-64 mb-6">
                <canvas id="serviceTypeUsageChart"></canvas>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="md-card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-on-surface-medium text-sm font-medium">Most Requested</p>
                            <h3 class="text-lg font-semibold text-on-surface-high mt-1">{{ $stats['most_requested']->name ?? 'N/A' }}</h3>
                            <p class="text-on-surface-medium text-xs">{{ $stats['most_requested']->request_count ?? 0 }} requests</p>
                        </div>
                        <div class="bg-primary-100 dark:bg-primary-900 dark:bg-opacity-30 p-3 rounded-full">
                            <span class="material-icons text-primary-600 dark:text-primary-300">trending_up</span>
                        </div>
                    </div>
                </div>
                
                <div class="md-card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-on-surface-medium text-sm font-medium">Highest Revenue</p>
                            <h3 class="text-lg font-semibold text-on-surface-high mt-1">{{ $stats['highest_revenue']->name ?? 'N/A' }}</h3>
                            <p class="text-on-surface-medium text-xs">{{ settings('currency_symbol', '$') }}{{ number_format($stats['highest_revenue']->total_revenue ?? 0, 2) }}</p>
                        </div>
                        <div class="bg-success-100 dark:bg-success-900 dark:bg-opacity-30 p-3 rounded-full">
                            <span class="material-icons text-success-600 dark:text-success-300">payments</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Provider Coverage -->
    <div class="md-card md-card-elevated">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h2 class="text-lg font-medium text-on-surface-high">Provider Coverage</h2>
        </div>
        
        <div class="p-6">
            <div class="h-64 mb-6">
                <canvas id="providerCoverageChart"></canvas>
            </div>
            
            <div class="md-card p-4 bg-surface-2 dark:bg-surface-2-dark">
                <h3 class="text-sm font-medium text-on-surface-medium mb-2">Coverage by Service Type</h3>
                
                <div class="space-y-3">
                    @foreach($providerCoverage as $coverage)
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-on-surface-high">{{ $coverage['name'] }}</span>
                            <span class="text-sm text-on-surface-high">{{ $coverage['count'] }} providers</span>
                        </div>
                        <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2">
                            <div class="h-2 rounded-full" style="width: {{ $coverage['percentage'] }}%; background-color: {{ $coverage['color'] }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup file input display
        document.getElementById('icon').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Choose Icon Image';
            document.getElementById('file-name').textContent = fileName;
        });
        
        // Service Type Usage Chart
        const usageCtx = document.getElementById('serviceTypeUsageChart').getContext('2d');
        const usageChart = new Chart(usageCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($usageStats['labels']) !!},
                datasets: [{
                    label: 'Number of Requests',
                    data: {!! json_encode($usageStats['data']) !!},
                    backgroundColor: {!! json_encode($usageStats['colors']) !!},
                    borderColor: {!! json_encode($usageStats['borderColors']) !!},
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        
        // Provider Coverage Chart
        const coverageCtx = document.getElementById('providerCoverageChart').getContext('2d');
        const coverageChart = new Chart(coverageCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_column($providerCoverage, 'name')) !!},
                datasets: [{
                    data: {!! json_encode(array_column($providerCoverage, 'count')) !!},
                    backgroundColor: {!! json_encode(array_column($providerCoverage, 'color')) !!},
                    borderColor: '#FFFFFF',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    });
    
    // Edit Service Type
    function editServiceType(id, name, description, basePrice, hasAdditionalCharges, isActive) {
        // Update form title
        document.getElementById('form-title').textContent = 'Edit Service Type';
        
        // Update form action
        const form = document.getElementById('serviceTypeForm');
        form.action = `{{ url('admin/service-types') }}/${id}`;
        
        // Add method field
        document.getElementById('method-field').innerHTML = `<input type="hidden" name="_method" value="PUT">`;
        
        // Fill form fields
        document.getElementById('name').value = name;
        document.getElementById('description').value = description;
        document.getElementById('base_price').value = basePrice;
        document.getElementById('has_additional_charges').checked = hasAdditionalCharges;
        document.getElementById('is_active').checked = isActive;
        
        // Update submit button
        document.getElementById('submit-icon').textContent = 'save';
        document.getElementById('submit-text').textContent = 'Update Service Type';
        
        // Scroll to form
        document.querySelector('.md-card.sticky').scrollIntoView({ behavior: 'smooth' });
    }
    
    // Reset Form
    function resetForm() {
        // Reset form title
        document.getElementById('form-title').textContent = 'Add New Service Type';
        
        // Reset form action
        const form = document.getElementById('serviceTypeForm');
        form.action = `{{ route('admin.service-types.store') }}`;
        
        // Clear method field
        document.getElementById('method-field').innerHTML = '';
        
        // Reset form fields
        form.reset();
        document.getElementById('file-name').textContent = 'Choose Icon Image';
        
        // Reset submit button
        document.getElementById('submit-icon').textContent = 'add';
        document.getElementById('submit-text').textContent = 'Add Service Type';
    }
</script>
@endpush
