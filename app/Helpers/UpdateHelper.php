<?php
namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UpdateHelper
{
    /**
     * Updates a record in a specified table.
     *
     * @param string $tableName The name of the table to update.
     * @param int $id The ID of the record to update.
     * @param array $data The data to update in the record.
     * @return bool|array Returns true if update was successful, or an error array.
     */
    public static function updateRecord($tableName, $id, array $data, $useTimestamps = true)
    {
        try {
            if ($useTimestamps) {
                $data['updated_at'] = Carbon::now();
            }
            // Update the record
            $updated = DB::table($tableName)
                ->where('id', $id)
                ->update($data);

            if ($updated) {
                return true; // Update successful
            } else {
                return ['error' => 'No rows affected. Check if the ID exists.'];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        } catch (\Exception $e) {
            return ['error' => 'An unexpected error occurred: ' . $e->getMessage()];
        }
    }
}
