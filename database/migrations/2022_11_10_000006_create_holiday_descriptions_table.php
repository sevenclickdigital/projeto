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
        Schema::create('holiday_descriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('holiday_id');
            $table->boolean('active')->default(false);
            $table
                ->enum('when_send', [
                    'one_day',
                    'two_days',
                    'three_days',
                    'four_days',
                    'five_days',
                    'one_week',
                    'two_weeks',
                    'one_month',
                    'in_day',
                ])
                ->default('one_day');
            $table->time('time');
            $table->string('subject');
            $table->longText('content');

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
        Schema::dropIfExists('holiday_descriptions');
    }
};
