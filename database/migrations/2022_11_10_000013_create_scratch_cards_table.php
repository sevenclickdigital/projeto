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
        Schema::create('scratch_cards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table
                ->enum('published', ['published', 'draft', 'archived'])
                ->default('draft');
            $table->text('award_photo_path')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('Keyword')->nullable();
            $table->integer('chances_of_winning');
            $table->integer(' play_number');
            $table->string('show_day');
            $table
                ->enum('prize_availability', ['always', 'date'])
                ->default('always');
            $table->date('prize_date_end')->nullable();

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
        Schema::dropIfExists('scratch_cards');
    }
};
