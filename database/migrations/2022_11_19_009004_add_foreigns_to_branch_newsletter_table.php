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
        Schema::table('branch_newsletter', function (Blueprint $table) {
            $table
                ->foreign('branch_id')
                ->references('id')
                ->on('branches')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('newsletter_id')
                ->references('id')
                ->on('newsletters')
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
        Schema::table('branch_newsletter', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['newsletter_id']);
        });
    }
};
