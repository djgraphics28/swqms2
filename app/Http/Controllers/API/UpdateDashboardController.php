<?php

namespace App\Http\Controllers\API;

use App\Models\Device;
use App\Helpers\AlertHelper;
use Illuminate\Http\Request;
use App\Events\DashboardUpdated;
use App\Http\Controllers\Controller;

class UpdateDashboardController extends Controller
{
    public function store(Request $request)
    {
        // Find the device by code
        $device = Device::where('code', $request->code)->first();

        if (!$device) {
            return response()->json([
                'message' => 'Device not found'
            ], 404);
        }

        // Create the log entry
        $logData = [
            'temperature' => $request->temperature,
            'voltage' => $request->voltage,
            'ph_value' => $request->ph_value,
            'turbidity' => $request->turbidity,
            'conductivity' => $request->conductivity
        ];

        $device->logs()->create($logData);

        // Check for alerts and create notifications if necessary
        AlertHelper::checkAlerts($device, $logData);

        event(new DashboardUpdated($device, []));

        return response()->json([
            'message' => 'Dashboard updated successfully'
        ]);
    }
}
