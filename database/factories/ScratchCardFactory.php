<?php

namespace Database\Factories;

use App\Models\ScratchCard;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScratchCardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ScratchCard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'published' => array_rand(
                array_flip(['published', 'draft', 'archived']),
                1
            ),
            'award_photo_path' => $this->faker->text,
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'Keyword' => $this->faker->text(255),
            'chances_of_winning' => $this->faker->randomNumber(0),
            ' play_number' => $this->faker->randomNumber(0),
            'show_day' => $this->faker->text(255),
            'prize_availability' => array_rand(
                array_flip(['always', 'date']),
                1
            ),
            'prize_date_end' => $this->faker->date,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
