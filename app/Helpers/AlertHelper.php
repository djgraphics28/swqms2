<?php

namespace App\Helpers;

use App\Models\Notification;

class AlertHelper
{
    public static function checkAlerts($device, $logData)
    {
        $alerts = [];

        // pH Level Alert
        if ($logData['ph_value'] > 9.0) {
            $alerts[] = [
                'message' => "Critical Alert: pH level at {$logData['ph_value']}. Possible heavy contamination.",
                'type' => 'alert',
                'category' => 'pH Level'
            ];
        } elseif (($logData['ph_value'] >= 6.0 && $logData['ph_value'] <= 6.5) ||
                  ($logData['ph_value'] >= 8.5 && $logData['ph_value'] <= 9.0)) {
            $alerts[] = [
                'message' => "Mild Alert: pH level at {$logData['ph_value']}. Check for industrial or household chemicals.",
                'type' => 'warning',
                'category' => 'pH Level'
            ];
        }

        // Conductivity Alert
        if ($logData['conductivity'] > 10000) {
            $alerts[] = [
                'message' => "Critical Alert: Conductivity at {$logData['conductivity']} µS/cm. Extremely High Conductivity, Dangerous, Likely Contaminated.",
                'type' => 'alert',
                'category' => 'Conductivity'
            ];
        } elseif ($logData['conductivity'] >= 1000 && $logData['conductivity'] <= 10000) {
            $alerts[] = [
                'message' => "Mild Alert: Conductivity at {$logData['conductivity']} µS/cm. High Conductivity, May Indicate Pollution or Hard Water.",
                'type' => 'warning',
                'category' => 'Conductivity'
            ];
        }

        // Turbidity Alert
        if ($logData['turbidity'] > 5) {
            $alerts[] = [
                'message' => "Critical Alert: Turbidity at {$logData['turbidity']} NTU. Possible heavy sedimentation or pollution.",
                'type' => 'alert',
                'category' => 'Turbidity'
            ];
        } elseif ($logData['turbidity'] >= 4 && $logData['turbidity'] <= 5) {
            $alerts[] = [
                'message' => "Mild Alert: Turbidity at {$logData['turbidity']} NTU. Possible algae growth or soil erosion.",
                'type' => 'warning',
                'category' => 'Turbidity'
            ];
        }

        // Temperature Alert
        if ($logData['temperature'] > 32) {
            $alerts[] = [
                'message' => "Critical Alert: Temperature at {$logData['temperature']}°C. High temperature, Possible industrial discharge or extreme weather.",
                'type' => 'alert',
                'category' => 'Temperature'
            ];
        } elseif ($logData['temperature'] < 26) {
            $alerts[] = [
                'message' => "Mild Alert: Temperature at {$logData['temperature']}°C. Low Temp, Unusual, Check Sources.",
                'type' => 'warning',
                'category' => 'Temperature'
            ];
        }

        // Store notifications if any alerts are found
        foreach ($alerts as $alert) {
            Notification::create([
                'device_id' => $device->id,
                'message' => $alert['message'],
                'type' => $alert['type'],
                'category' => $alert['category'],
            ]);
        }
    }

    public static function getPhLevelLabel($phValue)
    {
        if ($phValue >= 6.5 && $phValue <= 8.5) {
            return "Safe: pH level at {$phValue}. Within normal range.";
        } elseif ( $phValue < 6.0 ) {
            return "Not Safe: pH level at {$phValue}. Check for industrial or household chemicals.";
        } elseif ( $phValue > 9.0) {
            return "High pH Level: pH level at {$phValue}. Possible heavy contamination.";
        }
        return null;
    }
}
