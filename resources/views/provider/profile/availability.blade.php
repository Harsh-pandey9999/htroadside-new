@extends('layouts.app')

@section('title', 'Manage Availability')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Manage Availability</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 dark:bg-green-900/30 dark:text-green-300" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 dark:bg-red-900/30 dark:text-red-300" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Set Your Availability</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configure when you're available to provide roadside assistance services</p>
        </div>
        
        <form action="{{ route('provider.profile.update-availability') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6">
                <div class="mb-6">
                    <div class="flex items-center">
                        <input id="is_available" name="is_available" type="checkbox" {{ $provider->is_available ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                        <label for="is_available" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            I am currently available for service requests
                        </label>
                    </div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Toggle this off when you're on vacation or unavailable for an extended period
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Regular Hours</h3>
                        
                        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                            <div class="mb-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <input id="{{ $day }}_available" name="days[{{ $day }}][available]" type="checkbox" 
                                            {{ isset($availability[$day]) && $availability[$day]['available'] ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                        <label for="{{ $day }}_available" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ ucfirst($day) }}
                                        </label>
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <div>
                                            <label for="{{ $day }}_start" class="sr-only">Start Time</label>
                                            <input type="time" id="{{ $day }}_start" name="days[{{ $day }}][start]" 
                                                value="{{ isset($availability[$day]) ? $availability[$day]['start'] : '09:00' }}"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                        </div>
                                        <span class="text-gray-500 dark:text-gray-400 self-center">to</span>
                                        <div>
                                            <label for="{{ $day }}_end" class="sr-only">End Time</label>
                                            <input type="time" id="{{ $day }}_end" name="days[{{ $day }}][end]" 
                                                value="{{ isset($availability[$day]) ? $availability[$day]['end'] : '17:00' }}"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Emergency Availability</h3>
                        
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input id="emergency_available" name="emergency_available" type="checkbox" 
                                    {{ $provider->emergency_available ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                <label for="emergency_available" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Available for emergency requests outside regular hours
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                You'll receive higher rates for emergency service requests
                            </p>
                        </div>
                        
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Time Off</h3>
                            
                            <div id="time-off-container">
                                @if(count($timeOff) > 0)
                                    @foreach($timeOff as $index => $period)
                                        <div class="time-off-period mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-md">
                                            <div class="flex justify-between items-center mb-2">
                                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Time Off Period</h4>
                                                <button type="button" class="remove-period text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                    <i class="fas fa-times"></i> Remove
                                                </button>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="time_off[{{ $index }}][start_date]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                        Start Date
                                                    </label>
                                                    <input type="date" id="time_off[{{ $index }}][start_date]" name="time_off[{{ $index }}][start_date]" 
                                                        value="{{ $period['start_date'] }}"
                                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                                </div>
                                                
                                                <div>
                                                    <label for="time_off[{{ $index }}][end_date]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                        End Date
                                                    </label>
                                                    <input type="date" id="time_off[{{ $index }}][end_date]" name="time_off[{{ $index }}][end_date]" 
                                                        value="{{ $period['end_date'] }}"
                                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3">
                                                <label for="time_off[{{ $index }}][reason]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                    Reason (optional)
                                                </label>
                                                <input type="text" id="time_off[{{ $index }}][reason]" name="time_off[{{ $index }}][reason]" 
                                                    value="{{ $period['reason'] }}"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <button type="button" id="add-time-off" class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                                <i class="fas fa-plus mr-2"></i> Add Time Off
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 text-right">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('time-off-container');
        const addButton = document.getElementById('add-time-off');
        let periodCount = {{ count($timeOff) }};
        
        addButton.addEventListener('click', function() {
            const newPeriod = document.createElement('div');
            newPeriod.className = 'time-off-period mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-md';
            
            const today = new Date().toISOString().split('T')[0];
            
            newPeriod.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Time Off Period</h4>
                    <button type="button" class="remove-period text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                        <i class="fas fa-times"></i> Remove
                    </button>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="time_off[${periodCount}][start_date]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Start Date
                        </label>
                        <input type="date" id="time_off[${periodCount}][start_date]" name="time_off[${periodCount}][start_date]" 
                            value="${today}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="time_off[${periodCount}][end_date]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            End Date
                        </label>
                        <input type="date" id="time_off[${periodCount}][end_date]" name="time_off[${periodCount}][end_date]" 
                            value="${today}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                    </div>
                </div>
                
                <div class="mt-3">
                    <label for="time_off[${periodCount}][reason]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Reason (optional)
                    </label>
                    <input type="text" id="time_off[${periodCount}][reason]" name="time_off[${periodCount}][reason]" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                </div>
            `;
            
            container.appendChild(newPeriod);
            periodCount++;
            
            // Add event listener to the new remove button
            const removeButton = newPeriod.querySelector('.remove-period');
            removeButton.addEventListener('click', function() {
                container.removeChild(newPeriod);
            });
        });
        
        // Add event listeners to existing remove buttons
        document.querySelectorAll('.remove-period').forEach(button => {
            button.addEventListener('click', function() {
                const period = this.closest('.time-off-period');
                container.removeChild(period);
            });
        });
    });
</script>
@endsection
@endsection
