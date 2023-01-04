<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ScratchCardAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScratchCardAnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ScratchCardAnswer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'sending_order' => $this->faker->randomNumber(0),
            'type' => 'true',
            'template_type' => 'true',
            'elements_title' => $this->faker->sentence(10),
            'elements_subtitle' => $this->faker->text(255),
            'action_type' => $this->faker->text(255),
            'action_url' => $this->faker->url,
            'action_messenger_extensions' => 'true',
            'action_webview_height_ratio' => 'compact',
            'buttons_type' => $this->faker->text(255),
            'buttons_url' => $this->faker->text(255),
            'buttons_title' => $this->faker->text(255),
        ];
    }
}
