<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class MigrationController extends Controller
{
    public function migrateRefresh(Request $request)
    {
        $request->validate([
            'table' => 'required|string',
            'type' => 'required|in:refresh,rollback,reset,fresh,migrate'
        ]);

        $table = $request->input('table');
        $type = $request->input('type');

        // Check if table exists (for operations needing it)
        if (in_array($type, ['refresh', 'rollback', 'reset']) && !Schema::hasTable($table)) {
            return response()->json(['error' => "Table '$table' does not exist"], 400);
        }

        try {
            $migrationName = null;
            $existingData = collect();

            if (in_array($type, ['refresh', 'rollback'])) {
                // Backup data
                $existingData = DB::table($table)->get();

                // Find migration
                $migration = DB::table('migrations')->where('migration', 'like', "%{$table}%")->first();
                if (!$migration) {
                    return response()->json(['error' => "No migration found for table '$table'"], 400);
                }
                $migrationName = $migration->migration;

                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            }

            // Run Artisan migration commands based on type
            switch ($type) {
                case 'refresh':
                    $migrationPath = base_path("Modules/Subscription/database/migrations/{$migrationName}.php");
                    $pathOption = File::exists($migrationPath)
                        ? 'Modules/Subscription/database/migrations'
                        : "database/migrations/{$migrationName}.php";

                    Artisan::call('migrate:refresh', [
                        '--path' => $pathOption,
                        '--force' => true,
                    ]);
                    break;

                case 'rollback':
                    Artisan::call('migrate:rollback', ['--force' => true]);
                    break;

                case 'reset':
                    Artisan::call('migrate:reset', ['--force' => true]);
                    break;

                case 'fresh':
                    Artisan::call('migrate:fresh', ['--force' => true]);
                    break;

                case 'migrate':
                    Artisan::call('migrate', ['--force' => true]);
                    break;
            }

            // Restore data for rollback/refresh
            if (in_array($type, ['refresh', 'rollback']) && $existingData->isNotEmpty()) {
                $columns = Schema::getColumnListing($table);

                $filteredData = $existingData->map(function ($row) use ($columns) {
                    return array_intersect_key((array)$row, array_flip($columns));
                });

                foreach ($filteredData as $row) {
                    DB::table($table)->insert($row);
                }
            }

            if (in_array($type, ['refresh', 'rollback'])) {
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }

            return response()->json([
                'success' => "Migration `$type` executed successfully for table '$table'.",
                'migration' => $migrationName,
            ]);
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return response()->json([
                'error' => "Migration `$type` failed",
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function truncateTables()
    {
        // Define your target tables here
        $tables = [
            'customers',
            'customer_addresses',
            'customer_deactivation_reasons',
            'delivery_men',
            'delivery_man_reviews',
            'deliveryman_deactivation_reasons',
            'orders',
            'order_activities',
            'order_addresses',
            'order_delivery_histories',
            'order_details',
            'order_masters',
            'order_refunds',
            'order_refund_reasons',
            'reviews',
            'review_reactions',
            'store_subscriptions',
            'subscription_histories',
            'tickets',
            'ticket_messages',
            'universal_notifications',
            'wallets',
            'wallet_transactions',
            'wallet_withdrawals_transactions',
        ];

        $errors = [];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                try {
                    DB::table($table)->truncate();
                } catch (\Exception $e) {
                    $errors[$table] = $e->getMessage();
                }
            } else {
                $errors[$table] = 'Table does not exist.';
            }
        }

        return response()->json([
            'status' => empty($errors),
            'message' => empty($errors) ? 'All tables truncated successfully.' : 'Some tables could not be truncated.',
            'errors' => $errors
        ]);
    }

}
