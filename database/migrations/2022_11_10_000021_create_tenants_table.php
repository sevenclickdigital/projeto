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
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('max_lead')->nullable();
            $table->integer('max_branch')->nullable();
            $table->text('facebook_page_id')->nullable();
            $table->longText('facebook_access_token')->nullable();
            $table->text('instagram_page_id')->nullable();
            $table->longText('instagram_access_token')->nullable();
            $table->string('color_primary', 9)->nullable();
            $table->string('color_secondary', 9)->nullable();
            $table->string('custom_font')->nullable();
            $table->longText('participation_terms')->nullable();
            $table->longText('privacy')->nullable();
            $table->longText('terms_of_use')->nullable();

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
        Schema::dropIfExists('tenants');
    }
};
