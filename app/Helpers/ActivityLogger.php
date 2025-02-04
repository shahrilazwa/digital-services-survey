<?php

namespace App\Helpers;

use Exception;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log($action, $entityType = 'General', $entityId = null, $details = [])
    {
        try {
            // If no user is authenticated, fallback to system user ID 0
            $userId = Auth::check() ? Auth::id() : ($entityId ?? 0);

            // Prevent inserting null values for user_id
            if ($userId === null) {
                Log::error('Activity Log Attempted with Null User ID.');
                return;
            }

            // Check if details are already JSON-encoded
            if (!is_string($details)) {
                $details = $details;
            } else {
                // Verify if it's valid JSON
                json_decode($details);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $details = json_encode($details); // Encode if not valid JSON
                }
            }

            ActivityLog::create([
                'user_id' => $userId,  // Ensuring a valid user_id is always present
                'action' => $action,
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'details' => $details,
            ]);
        } catch (Exception $e) {
            // Log the error in the Laravel log
            Log::error('Activity Log Failed: ' . $e->getMessage());
            throw $e;
        }
    }    
}