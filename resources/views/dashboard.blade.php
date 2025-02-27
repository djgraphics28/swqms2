<x-layouts.app>
    <div class="min-h-screen bg-gray-100 p-6">
        <!-- Dashboard Heading -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">💧 Smart Water Quality Monitoring Dashboard</h1>
            <p class="text-gray-600">Real-time monitoring of water quality parameters</p>
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- pH Level -->
            <div class="p-4 bg-white rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-700">🧪 pH Level</h2>
                <p class="text-3xl font-bold text-green-500">7.2</p>
                <p class="text-sm text-gray-500">Safe range: 6.5 - 8.5</p>
            </div>

            <!-- Temperature -->
            <div class="p-4 bg-white rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-700">🌡 Temperature</h2>
                <p class="text-3xl font-bold text-blue-500">25°C</p>
                <p class="text-sm text-gray-500">Optimal: Below 35°C</p>
            </div>

            <!-- Turbidity -->
            <div class="p-4 bg-white rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-700">🌀 Turbidity</h2>
                <p class="text-3xl font-bold text-yellow-500">3 NTU</p>
                <p class="text-sm text-gray-500">Max limit: 5 NTU</p>
            </div>

            <!-- Conductivity -->
            <div class="p-4 bg-white rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-700">⚡ Conductivity</h2>
                <p class="text-3xl font-bold text-red-500">700 µS/cm</p>
                <p class="text-sm text-gray-500">Safe: Below 1000 µS/cm</p>
            </div>

            <!-- Dissolved Oxygen -->
            <div class="p-4 bg-white rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-700">🫧 Dissolved Oxygen</h2>
                <p class="text-3xl font-bold text-indigo-500">6.5 mg/L</p>
                <p class="text-sm text-gray-500">Minimum: 4 mg/L</p>
            </div>
        </div>

        <!-- Alerts Section -->
        <div class="mt-6 p-6 bg-white rounded-lg shadow-md border border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">⚠ Recent Alerts</h2>

            <!-- Alert Box -->
            <div class="mt-4 p-4 bg-red-100 border-l-4 border-red-600 rounded">
                <h3 class="text-lg font-semibold text-red-700">[ALERT] High Turbidity Detected</h3>
                <p class="text-sm text-gray-700">
                    📍 Location: Abacan River
                    📅 Date & Time: Feb 27, 2025 - 10:45 AM
                    📊 Measured Value: 7.2 NTU
                    📈 Threshold Limit: 5 NTU
                    🔍 Possible Cause: Heavy rainfall or industrial waste
                    📢 Recommended Action: Conduct immediate water treatment
                </p>
            </div>

            <div class="mt-4 p-4 bg-yellow-100 border-l-4 border-yellow-600 rounded">
                <h3 class="text-lg font-semibold text-yellow-700">[WARNING] pH Level Fluctuation</h3>
                <p class="text-sm text-gray-700">
                    📍 Location: Pampanga River
                    📅 Date & Time: Feb 26, 2025 - 3:30 PM
                    📊 Measured Value: 6.2
                    📈 Threshold Limit: 6.5 - 8.5
                    🔍 Possible Cause: Acidic contamination
                    📢 Recommended Action: Monitor and test water source
                </p>
            </div>
        </div>

        <!-- Placeholder for Charts -->
        <div class="mt-6 p-6 bg-white rounded-lg shadow-md border border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">📊 Water Quality Trends</h2>
            <div class="h-64 flex items-center justify-center text-gray-400">
                (Chart Placeholder - Can be replaced with Livewire Charts)
            </div>
        </div>
    </div>
</x-layouts.app>
