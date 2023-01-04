<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\RatingGoogleBusiness;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingGoogleBusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RatingGoogleBusiness::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'text' => $this->faker->text,
            'stars' => array_rand(
                array_flip([
                    'one_star',
                    'two_stars',
                    'three_stars',
                    'four_stars',
                    'five_stars',
                ])
            ),
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
