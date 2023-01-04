<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('category_product_id');
            $table
                ->enum('type', ['catalog_online', 'catalog_pdf'])
                ->default('catalog_online');
            $table->text('product_photo_path')->nullable();
            $table->string('name');
            $table->decimal('price');
            $table->text('description')->nullable();
            $table->string(' button_text')->nullable();
            $table->string(' button_path')->nullable();

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
        Schema::dropIfExists('products');
    }
};
