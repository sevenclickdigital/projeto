<?php

namespace Database\Factories;

use App\Models\Birthday;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BirthdayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Birthday::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'when_send' => array_rand(
                array_flip([
                    'one_day',
                    'two_days',
                    'three_days',
                    'four_days',
                    'five_days',
                    'one_week',
                    'two_weeks',
                    'one_month',
                    'in_day',
                ]),
                1
            ),
            'time' => $this->faker->time,
            'subject' => $this->faker->text(255),
            'content' => $this->faker->text,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
