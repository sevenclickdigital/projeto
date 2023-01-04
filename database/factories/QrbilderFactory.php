<?php

namespace Database\Factories;

use App\Models\Qrbilder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class QrbilderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Qrbilder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug,
            'bilder_photo_path' => $this->faker->text,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
