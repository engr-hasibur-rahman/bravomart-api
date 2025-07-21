<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('product_queries', 'deleted_at')) {
            Schema::table('product_queries', function (Blueprint $table) {
                $table->softDeletes()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_queries', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
