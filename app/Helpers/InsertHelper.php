<?php
namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InsertHelper
{
    /**
     * Inserts a new record into a specified table.
     *
     * @param string $tableName The name of the table to insert into.
     * @param array $data The data to insert into the record.
     * @return bool|array Returns true if insertion was successful, or an error array.
     */
    public static function insertRecord($tableName, array $data, $useTimestamps = true)
    {
        try {
            if ($useTimestamps) {
                $currentTimestamp = Carbon::now();
                $data['created_at'] = $currentTimestamp;
                $data['updated_at'] = $currentTimestamp;
            }
            // Insert the data
            $inserted = DB::table($tableName)->insert($data);

            if ($inserted) {
                return true; // Insert successful
            } else {
                return ['error' => 'Insert failed. No rows were added.'];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        } catch (\Exception $e) {
            return ['error' => 'An unexpected error occurred: ' . $e->getMessage()];
        }
    }

        public static function oldLoanInsertRecord($tableName, array $data, $useTimestamps = true)
    {
        try {
            if ($useTimestamps) {
                $currentTimestamp = Carbon::now();
                $data['created_at'] = $currentTimestamp;
            }
            // Insert the data
            $inserted = DB::table($tableName)->insert($data);

            if ($inserted) {
                return true; // Insert successful
            } else {
                return ['error' => 'Insert failed. No rows were added.'];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        } catch (\Exception $e) {
            return ['error' => 'An unexpected error occurred: ' . $e->getMessage()];
        }
    }
}
