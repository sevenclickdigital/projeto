<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ScratchCardPlayer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScratchCardPlayerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ScratchCardPlayer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'winner' => $this->faker->boolean,
            'tenant_id' => \App\Models\Tenant::factory(),
            'scratch_card_id' => \App\Models\ScratchCard::factory(),
            'lead_id' => \App\Models\Lead::factory(),
        ];
    }
}
