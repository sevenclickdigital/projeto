<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lead::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'active' => $this->faker->boolean,
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->lastName,
            'gender' => array_rand(array_flip(['male', 'female', 'other'])),
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'birthday' => $this->faker->date,
            'notify_news' => $this->faker->boolean,
            'notify_holiday' => $this->faker->boolean,
            'notify_birthday' => $this->faker->boolean,
            'notify_scratch_card' => $this->faker->boolean,
            'notify_coupon' => $this->faker->boolean,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
