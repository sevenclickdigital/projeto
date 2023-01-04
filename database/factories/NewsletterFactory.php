<?php

namespace Database\Factories;

use App\Models\Newsletter;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Newsletter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'active' => $this->faker->boolean,
            'sent' => $this->faker->boolean,
            'date' => $this->faker->date,
            'time' => $this->faker->time,
            'subject' => $this->faker->text(255),
            'content' => $this->faker->text,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
