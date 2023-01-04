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
        Schema::table('branch_scratch_card', function (Blueprint $table) {
            $table
                ->foreign('branch_id')
                ->references('id')
                ->on('branches')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('scratch_card_id')
                ->references('id')
                ->on('scratch_cards')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branch_scratch_card', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['scratch_card_id']);
        });
    }
};
