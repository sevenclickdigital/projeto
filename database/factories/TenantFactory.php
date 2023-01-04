<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'max_lead' => $this->faker->randomNumber(0),
            'max_branch' => $this->faker->randomNumber(0),
            'facebook_page_id' => $this->faker->text,
            'facebook_access_token' => $this->faker->text,
            'instagram_page_id' => $this->faker->text,
            'instagram_access_token' => $this->faker->text,
            'color_primary' => $this->faker->hexcolor,
            'color_secondary' => $this->faker->hexcolor,
            'custom_font' => $this->faker->text(255),
            'participation_terms' => $this->faker->text,
            'privacy' => $this->faker->text,
            'terms_of_use' => $this->faker->text,
        ];
    }
}
