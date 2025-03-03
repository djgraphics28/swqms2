<?php

use Livewire\Volt\Component;

new class extends Component {
    public $devices = [];
    public $code = '';
    public $location = '';
    public $lat = '';
    public $lng = '';
    public $isEditing = false;
    public $editingId = null;

    public function mount()
    {
        $this->loadDevices();
    }

    public function loadDevices()
    {
        // Load devices from the database
        $this->devices = \App\Models\Device::all()->toArray();
    }

    public function saveDevice()
    {
        $this->validate([
            'code' => 'required|string',
            'location' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        if ($this->isEditing) {
            // Update existing device in database
            $device = \App\Models\Device::find($this->editingId);
            if ($device) {
                $device->update([
                    'code' => $this->code,
                    'location' => $this->location,
                    'lat' => $this->lat,
                    'lng' => $this->lng,
                ]);

                // Update local array for UI
                $devices = collect($this->devices);
                $index = $devices->search(fn($item) => $item['id'] == $this->editingId);

                if ($index !== false) {
                    $this->devices[$index] = [
                        'id' => $this->editingId,
                        'code' => $this->code,
                        'location' => $this->location,
                        'lat' => $this->lat,
                        'lng' => $this->lng,
                    ];
                }
            }
        } else {
            // Create new device in database
            $device = \App\Models\Device::create([
                'code' => $this->code,
                'location' => $this->location,
                'lat' => $this->lat,
                'lng' => $this->lng,
            ]);

            // Add to local array for UI
            $this->devices[] = [
                'id' => $device->id,
                'code' => $this->code,
                'location' => $this->location,
                'lat' => $this->lat,
                'lng' => $this->lng,
            ];
        }

        $this->resetForm();
    }

    public function editDevice($id)
    {
        $device = collect($this->devices)->firstWhere('id', $id);

        if ($device) {
            $this->isEditing = true;
            $this->editingId = $id;
            $this->code = $device['code'];
            $this->location = $device['location'];
            $this->lat = $device['lat'];
            $this->lng = $device['lng'];
        }
    }

    public function deleteDevice($id)
    {
        // Delete from database
        \App\Models\Device::destroy($id);

        // Update local array for UI
        $this->devices = collect($this->devices)
            ->filter(function ($device) use ($id) {
                return $device['id'] != $id;
            })
            ->values()
            ->all();
    }

    public function resetForm()
    {
        $this->code = '';
        $this->location = '';
        $this->lat = '';
        $this->lng = '';
        $this->isEditing = false;
        $this->editingId = null;
    }
}; ?>

<div>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">{{ $isEditing ? 'Edit Device' : 'Add New Device' }}</h2>
                <form wire:submit.prevent="saveDevice">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="code"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Code</label>
                            <input type="text" id="code" wire:model="code"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('code')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="location"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                            <input type="text" id="location" wire:model="location"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('location')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="lat"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Latitude</label>
                            <input type="number" step="any" id="lat" wire:model="lat"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('lat')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="lng"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Longitude</label>
                            <input type="number" step="any" id="lng" wire:model="lng"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('lng')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4 flex space-x-3">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ $isEditing ? 'Update' : 'Save' }}
                        </button>
                        @if ($isEditing)
                            <button type="button" wire:click="resetForm"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </button>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Devices</h2>

                @if (count($devices) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Code</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Location</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Latitude</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Longitude</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($devices as $device)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $device['code'] }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $device['location'] }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $device['lat'] }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $device['lng'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="editDevice('{{ $device['id'] }}')"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">Edit</button>
                                            <button wire:click="deleteDevice('{{ $device['id'] }}')"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                        No devices found. Add your first device above.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
