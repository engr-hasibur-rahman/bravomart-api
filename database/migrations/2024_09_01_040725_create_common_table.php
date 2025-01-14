<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Migrations\UniqueBaseMigration;

return new class extends Migration {
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

            //Unique Key
            //$table->unique(array('translatable_id', 'translatable_type','language','key'),'unique_translation');

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
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        Schema::create('product_category', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->string('category_slug');
            $table->string('category_name_paths')->nullable();
            $table->string('parent_path')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('category_level')->nullable();
            $table->boolean('is_featured')->default(1);
            $table->double('admin_commission_rate')->nullable();
            $table->string('category_thumb')->nullable();
            $table->string('category_banner')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('display_order')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('product_type')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        // Schema::create('product_attribute_group', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('product_attribute_id');
        //     $table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('cascade');
        //     $table->string('size_label');
        //     $table->string('color_label');
        //     $table->string('material_label');
        //     $table->string('attribute_list');
        //     $table->unsignedBigInteger('created_by')->nullable();
        //     $table->unsignedBigInteger('updated_by')->nullable();
        //     $table->boolean('status')->default(1);
        //     $table->timestamps();
        // });

        // Schema::create('product_attribute_line', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('product_attribute_id');
        //     $table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('cascade');
        //     $table->string('attribute_line_name');
        //     $table->unsignedBigInteger('created_by')->nullable();
        //     $table->unsignedBigInteger('updated_by')->nullable();
        //     $table->boolean('status')->default(1);
        //     $table->timestamps();
        // });

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

        //https://github.com/MatanYadaev/laravel-eloquent-spatial
        Schema::create('com_areas', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name');
            $table->geometry('coordinates', subtype: 'polygon')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('com_merchant', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->double('rating')->nullable();
            $table->integer('num_of_reviews')->nullable();
            $table->integer('num_of_sale')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
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
        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('com_merchant_stores');
    }
};
