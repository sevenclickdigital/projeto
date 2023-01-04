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
        Schema::create('coupons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->boolean('active')->default(true);
            $table->string('title');
            $table->text('description');
            $table->string('code');
            $table
                ->enum('coupon_type', ['default', 'first_order'])
                ->default('default');
            $table->integer('limit');
            $table->date('start_date');
            $table->date('expire_date');
            $table->decimal('min_purchase');
            $table->decimal('max_discount');
            $table->enum('discount_type', ['amount', 'percent']);
            $table->decimal('discount');
            $table->dateTime('when_send');

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
        Schema::dropIfExists('coupons');
    }
};
