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
        Schema::table('branch_rating', function (Blueprint $table) {
            $table
                ->foreign('branch_id')
                ->references('id')
                ->on('branches')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('rating_id')
                ->references('id')
                ->on('ratings')
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
        Schema::table('branch_rating', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['rating_id']);
        });
    }
};
