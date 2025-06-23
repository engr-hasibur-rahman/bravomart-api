<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SeederController extends Controller
{
    public function runSeeder(Request $request)
    {
        $request->validate([
            'seeder' => 'required|string'
        ]);

        $seederName = $request->input('seeder');

        // Determine full class name (optional: you can modify this logic based on your naming conventions)
        $fullSeederClass = $seederName;

        // Check if seeder file exists in default path
        $seederPath = base_path("database/seeders/{$seederName}.php");
        if (!File::exists($seederPath)) {
            return response()->json(['error' => "Seeder '$seederName' not found in database/seeders."], 400);
        }

        try {
            // Run the specific seeder using Artisan
            Artisan::call('db:seed', [
                '--class' => $fullSeederClass,
                '--force' => true
            ]);

            return response()->json([
                'success' => "Seeder '$fullSeederClass' executed successfully.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => "Seeder execution failed.",
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
