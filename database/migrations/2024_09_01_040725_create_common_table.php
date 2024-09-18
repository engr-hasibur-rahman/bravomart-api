<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Migrations\UniqueBaseMigration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('translatable_id'); // ID of the related model
            $table->string('translatable_type'); // Model type (e.g., App\Models\Category)
            $defaultLanguage = config('bivamart.default_language', 'en');
            $table->string('language')->default($defaultLanguage);
            $table->string('key');
            $table->text('value');
            $table->timestamps();

            // Indexes for better performance
            $table->index(['translatable_id', 'translatable_type']);
            $table->index(['language', 'key']);
        });

        Schema::create('product_brand', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name');
            $table->string('brand_slug');
            $table->string('brand_logo')->nullable();
            $table->string('meta_title');
            $table->text('meta_description');
            $table->string('seller_relation_with_brand')->nullable();
            $table->timestamp('authorization_valid_from')->nullable();
            $table->timestamp('authorization_valid_to')->nullable();
            $table->integer('display_order');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('product_category', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->string('category_slug');
            $table->string('category_name_paths');
            $table->string('parent_path');
            $table->integer('parent_id');
            $table->boolean('is_featured')->default(false);
            $table->double('admin_commission_rate');
            $table->string('category_banner');
            $table->string('category_icon');
            $table->string('category_cover_image');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->integer('display_order');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        // Schema::create('media', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('fileable_id');
        //     $table->string('fileable_type');
        //     $table->string('type');
        //     $table->string('name');
        //     $table->string('src');
        //     $table->string('extension');
        //     $table->string('path');
        //     $table->string('description');
        //     $table->unsignedBigInteger('created_by')->nullable();
        //     $table->unsignedBigInteger('updated_by')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
        Schema::dropIfExists('product_brand');
        Schema::dropIfExists('product_category');
    }
};
