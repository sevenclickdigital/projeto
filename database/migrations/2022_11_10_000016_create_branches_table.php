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
        Schema::create('branches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->string('branch_logo_path')->nullable();
            $table->string('branch_cover_path')->nullable();
            $table->string('name');
            $table->string('currency', 3)->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
            $table->string('phone')->nullable();
            $table->string('cell')->nullable();
            $table->string('email')->nullable();
            $table->integer('place_id')->nullable();
            $table->string('coordinates')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();

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
        Schema::dropIfExists('branches');
    }
};
