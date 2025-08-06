<?php
namespace App\Helpers;

use App\Models\systemactivitylog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class activityLogHelper
{
    /**
     * Updates a record in a specified table.
     *
     * @param string $tableName The name of the table to update.
     * @param int $id The ID of the record to update.
     * @param array $data The data to update in the record.
     * @return bool|array Returns true if update was successful, or an error array.
     */
    public static function activityLog($ipAddress, $location, $country, $activityMessage, $type, $className, $useTimestamps = true)
{
    try {
        // Check if user is authenticated
        if (!Auth::check()) {
            return ['error' => 'User not authenticated.'];
        }

        if ($useTimestamps) {
            $currentTimestamp = Carbon::now();
        }

        // Get the authenticated user's ID
        $userId = Auth::user()->id;

        // Create a new system activity log record
        $activityLog = new systemactivitylog();
        $activityLog->userId = $userId;
        $activityLog->location = $location;
        $activityLog->country = $country;
        $activityLog->ipAddress = $ipAddress;
        $activityLog->activity = $activityMessage;
        $activityLog->type = $type;
        $activityLog->className = $className;
        $activityLog->created_at = $currentTimestamp;
        $activityLog->updated_at = $currentTimestamp;

        // Save the record and check the result
        if ($activityLog->save()) {
            return true; // Save successful
        } else {
            return ['error' => 'Failed to save the activity log.'];
        }
    } catch (\Illuminate\Database\QueryException $e) {
        // Handle database query errors
        return ['error' => 'Database error: ' . $e->getMessage()];
    } catch (\Exception $e) {
        // Handle other exceptions
        return ['error' => 'An unexpected error occurred: ' . $e->getMessage()];
    }
}

}
