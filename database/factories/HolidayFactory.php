<?php

namespace Database\Factories;

use App\Models\Holiday;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class HolidayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Holiday::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'date' => $this->faker->date,
            'active' => $this->faker->boolean,
            'custom' => $this->faker->boolean,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
