<?php

use Livewire\Volt\Component;
use App\Models\Device;
use App\Models\Notification;
use Livewire\Attributes\On;

new class extends Component {
    #[On('DashboardUpdated')]
    public function with(): array
    {
        return [
            'device' => Device::with('latest_log')->find(1),
            'notifications' => Notification::latest()->get(),
        ];
    }

    public function refreshData()
    {
        $this->dispatch('$refresh');
    }
};

?>

<div wire:poll.5s>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-6">
        <!-- Dashboard Heading -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                💧 Smart Water Quality Monitoring Dashboard
            </h1>
            <p class="text-gray-600 dark:text-gray-400">Real-time monitoring of water quality parameters</p>
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- pH Level -->
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">🧪 pH Level</h2>
                <p class="text-3xl font-bold text-green-500 dark:text-green-400">{{ $device->latest_log->ph_value ?? 0 }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Safe range: 6.5 - 8.5</p>
            </div>

            <!-- Temperature -->
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">🌡 Temperature</h2>
                <p class="text-3xl font-bold text-blue-500 dark:text-blue-400">
                    {{ $device->latest_log->temperature ?? 0 }}°C
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Optimal: Below 35°C</p>
            </div>

            <!-- Turbidity -->
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">🌀 Turbidity</h2>
                <p class="text-3xl font-bold text-yellow-500 dark:text-yellow-400">
                    {{ $device->latest_log->turbidity ?? 0 }} NTU
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Max limit: 5 NTU</p>
            </div>

            <!-- Conductivity -->
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">⚡ Conductivity</h2>
                <p class="text-3xl font-bold text-red-500 dark:text-red-400">
                    {{ $device->latest_log->conductivity ?? 0 }} µS/cm
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Safe: Below 1000 µS/cm</p>
            </div>

            <!-- Dissolved Oxygen -->
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">🫧 Dissolved Oxygen</h2>
                <p class="text-3xl font-bold text-indigo-500 dark:text-indigo-400">
                    {{ $device->latest_log->voltage ?? 0 }} mg/L
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Minimum: 4 mg/L</p>
            </div>
        </div>

        <!-- Alerts Section -->
        <div
            class="mt-6 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">⚠ Recent Alerts</h2>

            @if ($notifications->count() > 5)
                <div class="max-h-100 overflow-y-auto pr-2">
            @endif

            @foreach ($notifications as $notification)
                @php
                    $bgColor =
                        $notification->type === 'alert'
                            ? 'bg-red-100 dark:bg-red-900/30 border-red-600'
                            : 'bg-yellow-100 dark:bg-yellow-900/30 border-yellow-600';
                    $textColor =
                        $notification->type === 'alert'
                            ? 'text-red-700 dark:text-red-400'
                            : 'text-yellow-700 dark:text-yellow-400';
                @endphp

                <!-- Notification Box -->
                <div class="mt-4 p-4 {{ $bgColor }} border-l-4 rounded">
                    <h3 class="text-lg font-semibold {{ $textColor }}">[{{ strtoupper($notification->type) }}]
                        {{ $notification->category }}</h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        📍 Location: {{ $notification->device->location ?? 'Unknown' }}<br>
                        📅 Date & Time: {{ $notification->created_at->format('M d, Y - h:i A') }}<br>
                        📢 Message: {{ $notification->message }}
                    </p>
                </div>
            @endforeach

            @if ($notifications->count() > 5)
        </div>
        @endif
    </div>

    <!-- Placeholder for Charts -->
    <div class="mt-6 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">📊 Water Quality Trends</h2>
        <div class="h-64 flex items-center justify-center text-gray-400 dark:text-gray-500">
            (Chart Placeholder - Can be replaced with Livewire Charts)
        </div>
    </div>
</div>
</div>

<script>
    setInterval(() => {
         Livewire.emit('refreshData');
    }, 5000); // Refresh every 5 seconds
</script>

<script>
    window.Echo.channel('dashboard')
        .listen('.DashboardUpdated', (e) => {
            console.log(e);
            // Livewire.emit('refreshData');
        });
</script>
