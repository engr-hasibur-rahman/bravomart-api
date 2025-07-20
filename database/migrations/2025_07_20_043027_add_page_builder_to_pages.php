<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('layout')->default('default')->nullable()->after('page_type'); // default, full-width, custom
            $table->string('page_class')->nullable()->after('layout');
            $table->boolean('enable_builder')->default(false)->after('page_class');
            $table->boolean('show_breadcrumb')->default(false)->after('enable_builder');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('layout');
            $table->dropColumn('page_class');
            $table->dropColumn('enable_builder');
            $table->dropColumn('show_breadcrumb');
        });
    }
};
