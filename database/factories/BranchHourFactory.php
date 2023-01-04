<?php

namespace Database\Factories;

use App\Models\BranchHour;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchHourFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BranchHour::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'day' => array_rand(
                array_flip([
                    'sunday',
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                ]),
                1
            ),
            'hour_start' => $this->faker->time,
            'hour_end' => $this->faker->time,
            'tenant_id' => \App\Models\Tenant::factory(),
            'branch_id' => \App\Models\Branch::factory(),
        ];
    }
}
