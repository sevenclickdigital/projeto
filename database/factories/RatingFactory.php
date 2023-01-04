<?php

namespace Database\Factories;

use App\Models\Rating;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'active' => $this->faker->boolean,
            'award_photo_path' => $this->faker->text,
            'subject' => $this->faker->text(255),
            'content' => $this->faker->text,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
