<?php

namespace App\Http\Controllers\API;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Events\DashboardUpdated;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function updateDashboard(Request $request)
    {
        // Find the device by 'code'
        $device = Device::where('code', $request->code)->first();

        if (!$device) {
            return response()->json([
                'message' => 'Device not found'
            ], 404);
        }

        // Create a new log entry for the device
        $device->logs()->create([
            'temperature' => $request->temperature,
            'voltage' => $request->voltage,
            'ph_level' => $request->ph_level,
            'turbidity' => $request->turbidity,
            'conductivity' => $request->conductivity
        ]);

        // Fetch the latest device data with the latest log
        $data = Device::where('code', $request->code)->with('latest_log')->first();

        // Log the event before broadcasting (for debugging)
        \Log::info('Broadcasting DashboardUpdated event', ['data' => $data]);

        // Broadcast the event
        event(new DashboardUpdated($data));

        return response()->json([
            'message' => 'Dashboard updated successfully'
        ]);
    }
}
