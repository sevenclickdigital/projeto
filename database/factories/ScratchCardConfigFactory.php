<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ScratchCardConfig;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScratchCardConfigFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ScratchCardConfig::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Keyword' => $this->faker->text(255),
            'when_send' => array_rand(
                array_flip(['no_send', 'one_week', 'two_weeks', 'one_month']),
                1
            ),
            'winner_photo_path' => $this->faker->text,
            'loser_photo_path' => $this->faker->text,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
