<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'active' => $this->faker->boolean,
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->sentence(15),
            'code' => $this->faker->text(255),
            'coupon_type' => 'default',
            'limit' => $this->faker->randomNumber(0),
            'start_date' => $this->faker->date,
            'expire_date' => $this->faker->date,
            'min_purchase' => $this->faker->randomNumber(1),
            'max_discount' => $this->faker->randomNumber(1),
            'discount_type' => 'amount',
            'discount' => $this->faker->randomFloat(2, 0, 9999),
            'when_send' => $this->faker->dateTime,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
