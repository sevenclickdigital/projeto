<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->text,
            'read' => $this->faker->boolean,
            'message_key' => $this->faker->text,
            'sender' => array_rand(array_flip(['user', 'company'])),
            'sender_id' => $this->faker->uuid,
            'receiver_id' => $this->faker->uuid,
            'tenant_id' => \App\Models\Tenant::factory(),
            'social_lead_id' => \App\Models\SocialLead::factory(),
        ];
    }
}
