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
        Schema::table('holiday_descriptions', function (Blueprint $table) {
            $table
                ->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('holiday_id')
                ->references('id')
                ->on('holidays')
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
        Schema::table('holiday_descriptions', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropForeign(['holiday_id']);
        });
    }
};
