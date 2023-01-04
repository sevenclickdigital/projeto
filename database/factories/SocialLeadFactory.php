<?php

namespace Database\Factories;

use App\Models\SocialLead;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocialLeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SocialLead::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'active' => $this->faker->boolean,
            'profile_photo_path' => $this->faker->text,
            'social_id' => $this->faker->text,
            'social_key' => $this->faker->text,
            'social_type' => array_rand(
                array_flip(['instagram', 'facebook', 'whatsapp']),
                1
            ),
            'tenant_id' => \App\Models\Tenant::factory(),
            'lead_id' => \App\Models\Lead::factory(),
        ];
    }
}
