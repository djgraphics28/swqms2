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
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                    💧 Smart Water Quality Monitoring Dashboard
                </h1>
                <p class="text-gray-600 dark:text-gray-400">Real-time monitoring of water quality parameters</p>
            </div>
            <div class="text-right">
                <p class="text-gray-600 dark:text-gray-400 font-mono font-bold tracking-tight bg-gray-800 dark:bg-gray-700 text-green-500 dark:text-green-400 p-2 rounded-lg inline-block"
                    x-data x-init="setInterval(() => $el.textContent = new Date().toLocaleString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: true
                    }), 1000)">
                    {{ now()->format('M j, Y g:i:s A') }}
                </p>
            </div>
        </div>
        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- pH Level -->
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">🧪 pH Level</h2>
                <p class="text-3xl font-bold text-green-500 dark:text-green-400" wire:loading.class="animate-pulse">
                    {{ $device->latest_log->ph_value ?? 0 }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Safe range: 6.5 - 8.5</p>
            </div>

            <!-- Temperature -->
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">🌡 Temperature</h2>
                <p class="text-3xl font-bold text-blue-500 dark:text-blue-400" wire:loading.class="animate-pulse">
                    {{ $device->latest_log->temperature ?? 0 }}°C
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Optimal: Below 35°C</p>
            </div>

            <!-- Turbidity -->
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">🌀 Turbidity</h2>
                <p class="text-3xl font-bold text-yellow-500 dark:text-yellow-400" wire:loading.class="animate-pulse">
                    {{ $device->latest_log->turbidity ?? 0 }} NTU
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Max limit: 5 NTU</p>
            </div>

            <!-- Conductivity -->
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">⚡ Conductivity</h2>
                <p class="text-3xl font-bold text-red-500 dark:text-red-400" wire:loading.class="animate-pulse">
                    {{ $device->latest_log->conductivity ?? 0 }} µS/cm
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Safe: Below 1000 µS/cm</p>
            </div>

            <!-- Dissolved Oxygen -->
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">🫧 Dissolved Oxygen</h2>
                <p class="text-3xl font-bold text-indigo-500 dark:text-indigo-400" wire:loading.class="animate-pulse">
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

    <!-- Guidelines -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
        <!-- Water Quality Guidelines for Parameters -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">📊 Water Quality Guidelines for
                Parameters</h2>
            <div class="overflow-x-auto">
                <table class="w-full mt-4 border-collapse border border-gray-300 dark:border-gray-700 min-w-full">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <th class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">Parameter</th>
                            <th class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">Unit</th>
                            <th class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">AA</th>
                            <th class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">A</th>
                            <th class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">B</th>
                            <th class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">C</th>
                            <th class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">D</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">Dissolved
                                Oxygen (Minimum)</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">mg/L</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">5</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">5</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">5</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">5</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">2</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">pH (Range)
                            </td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">-</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">6.5-8.5</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">6.5-8.5</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">6.5-8.5</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">6.5-9.0</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">6.0-9.0</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">Temperature
                            </td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">°C</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">26-30</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">26-30</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">26-30</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">25-31</td>
                            <td class="border border-gray-300 dark:border-gray-600 p-2 whitespace-nowrap">25-32</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Water Quality Guidelines for Turbidity -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">📊 Water Quality Guidelines for
                Turbidity</h2>
            <table class="w-full mt-4 border-collapse border border-gray-300 dark:border-gray-700">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="border border-gray-300 dark:border-gray-600 p-2">Classification</th>
                        <th class="border border-gray-300 dark:border-gray-600 p-2">Range</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">Low Turbidity</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">&lt;10 NTU</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">Moderately Turbid</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">11-50 NTU</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">High Turbidity</td>
                        <td class="border border-gray-300 dark:border-gray-600 p-2">&gt;100 NTU</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Water Quality Guidelines for Conductivity -->
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">📊 Water Quality Guidelines for
                Conductivity</h2>
            <table class="w-full mt-4 border-collapse border border-gray-300 dark:border-gray-600">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Classification</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Range</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">Low Conductivity</td>
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">0-200 μS/cm</td>
                    </tr>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">Mid-range/Normal Conductivity
                        </td>
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">200-1000 μS/cm</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">High Conductivity</td>
                        <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">1000-10,000 μS/cm</td>
                    </tr>
                </tbody>
            </table>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                Note: μS/cm stands for microsiemens per centimeter. Retrieved from: Government of the Northwest
                Territories, Conductivity.
            </p>
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
