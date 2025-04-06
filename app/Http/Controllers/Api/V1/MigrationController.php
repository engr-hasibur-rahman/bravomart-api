<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrationController extends Controller
{
    public function migrateRefresh(Request $request)
    {
        $request->validate([
            'table' => 'required|string'
        ]);

        $table = $request->input('table');

        // Check if table exists
        if (!Schema::hasTable($table)) {
            return response()->json(['error' => "Table '$table' does not exist"], 400);
        }

        try {
            // Step 1: Backup existing table data
            $existingData = DB::table($table)->get();

// Step 2: Get migration file name for the table
            $migration = DB::table('migrations')->where('migration', 'like', "%{$table}%")->first();

            if (!$migration) {
                return response()->json(['error' => "No migration found for table '$table'"], 400);
            }

            $migrationName = $migration->migration;

// Step 3: Disable foreign key checks before migration
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

// Step 4: Rollback and re-run the migration
            if ($migrationName) {
                // If migration name exists, we run the migration refresh for the specific migration
                Artisan::call('migrate:refresh', [
                    '--path' => "Modules/Subscription/database/migrations/{$migrationName}.php", // Correct path to your migration file
                    '--force' => true
                ]);
            } else {
                // If no specific migration file is provided, run all migrations in the Subscription module
                Artisan::call('migrate', [
                    '--path' => 'Modules/Subscription/database/migrations', // Path to all migrations in the module
                    '--force' => true
                ]);
            }


            // Step 5: Get the current columns of the table after migration
            $columns = Schema::getColumnListing($table);

            // Step 6: Filter out any columns that are no longer in the table
            $filteredData = $existingData->map(function ($row) use ($columns) {
                $rowArray = (array) $row;

                // Remove any column that doesn't exist in the new schema
                return array_intersect_key($rowArray, array_flip($columns));
            });

            // Step 7: Restore the backed-up data
            foreach ($filteredData as $row) {
                DB::table($table)->insert($row);
            }

            // Step 8: Enable foreign key checks after restoring data
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return response()->json([
                'success' => "Migration refreshed for table '$table' without deleting existing data.",
                'migration' => $migrationName
            ]);
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Ensure foreign key checks are re-enabled
            return response()->json(['error' => 'Migration refresh failed', 'message' => $e->getMessage()], 500);
        }
    }
}
