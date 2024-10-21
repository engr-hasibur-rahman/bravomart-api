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
            $table->integer('parent_id')->nullable();
            $table->boolean('is_featured')->default(1);
            $table->double('admin_commission_rate')->nullable();
            $table->string('category_banner')->nullable();
            $table->string('category_icon')->nullable();
            $table->string('category_cover_image')->nullable();
            $table->string('meta_title');
            $table->text('meta_description');
            $table->integer('display_order')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('attribute_name');
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
            $table->string('name'); 
            $table->geometry('coordinates', subtype: 'polygon')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });        

        Schema::create('com_stores', function (Blueprint $table) {
            $table->id();
            $table->string('area_id'); 
            $table->string('type')->nullable();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('slug');
            $table->string('vat_tax_number')->nullable();
            $table->boolean('is_featured')->nullable();
            $table->string('opening_time')->nullable();
            $table->string('closing_time')->nullable();
            $table->double('subscription_type')->nullable();
            $table->double('package_id')->nullable();
            $table->double('admin_commi_percent')->nullable();
            $table->double('admin_commi_amount')->nullable();
            $table->double('delivery_charge')->nullable();
            $table->string('delivery_time')->nullable();
            $table->boolean('delivery_self_system')->nullable();
            $table->boolean('delivery_take_away')->nullable();
            $table->double('order_minimum')->nullable();
            $table->boolean('veg_status')->nullable();
            $table->string('off_day')->nullable();
            $table->boolean('enable_saling');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->string('status');
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
    }
};
