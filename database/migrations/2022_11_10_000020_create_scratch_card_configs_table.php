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
        Schema::create('scratch_card_configs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->string('Keyword');
            $table
                ->enum('when_send', [
                    'no_send',
                    'one_week',
                    'two_weeks',
                    'one_month',
                ])
                ->default('one_month');
            $table->text('winner_photo_path');
            $table->text('loser_photo_path');

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
        Schema::dropIfExists('scratch_card_configs');
    }
};
