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
        Schema::table('scratch_card_players', function (Blueprint $table) {
            $table
                ->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('scratch_card_id')
                ->references('id')
                ->on('scratch_cards')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('lead_id')
                ->references('id')
                ->on('leads')
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
        Schema::table('scratch_card_players', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropForeign(['scratch_card_id']);
            $table->dropForeign(['lead_id']);
        });
    }
};
