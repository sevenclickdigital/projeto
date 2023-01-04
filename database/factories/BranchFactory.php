<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'branch_logo_path' => $this->faker->text(255),
            'branch_cover_path' => $this->faker->text(255),
            'name' => $this->faker->name,
            'currency' => $this->faker->currencyCode,
            'description' => $this->faker->sentence(15),
            'slug' => $this->faker->slug,
            'phone' => $this->faker->phoneNumber,
            'cell' => $this->faker->text(255),
            'email' => $this->faker->email,
            'place_id' => $this->faker->randomNumber(0),
            'coordinates' => $this->faker->text(255),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->text(255),
            'country' => $this->faker->country,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
