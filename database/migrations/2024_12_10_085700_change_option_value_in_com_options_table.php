<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Run the migrations.
     */

    public function up(): void
    {
        // Truncate overly long data entries
        DB::table('com_options')->whereRaw('LENGTH(option_value) > 4294967295')
            ->update(['option_value' => DB::raw('SUBSTRING(option_value, 1, 4294967295)')]);

        // Check if there are any data issues that might cause problems during the alteration
        DB::table('com_options')->whereNull('option_value')
            ->update(['option_value' => '']);
        Schema::table('com_options', function (Blueprint $table) {
            $table->longText('option_value')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('com_options', function (Blueprint $table) {
            $table->string('option_value')->change();
        });
    }
};
