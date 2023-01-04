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
        Schema::create('scratch_card_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description');
            $table->integer('sending_order')->nullable();
            $table->enum('type', ['true', 'false'])->nullable();
            $table->enum('template_type', ['true', 'false'])->nullable();
            $table->string('elements_title')->nullable();
            $table->string('elements_image_url')->nullable();
            $table->string('elements_subtitle')->nullable();
            $table->string('action_type')->nullable();
            $table->string('action_url')->nullable();
            $table
                ->enum('action_messenger_extensions', ['true', 'false'])
                ->nullable();
            $table
                ->enum('action_webview_height_ratio', [
                    'compact',
                    'tall',
                    'full',
                ])
                ->nullable();
            $table->string('buttons_type')->nullable();
            $table->string('buttons_url')->nullable();
            $table->string('buttons_title')->nullable();

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
        Schema::dropIfExists('scratch_card_answers');
    }
};
