<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Message;

use App\Models\Tenant;
use App\Models\SocialLead;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_messages_list()
    {
        $messages = Message::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.messages.index'));

        $response->assertOk()->assertSee($messages[0]->message_key);
    }

    /**
     * @test
     */
    public function it_stores_the_message()
    {
        $data = Message::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.messages.store'), $data);

        unset($data['social_lead_id']);

        $this->assertDatabaseHas('messages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_message()
    {
        $message = Message::factory()->create();

        $tenant = Tenant::factory()->create();
        $socialLead = SocialLead::factory()->create();

        $data = [
            'text' => $this->faker->text,
            'read' => $this->faker->boolean,
            'message_key' => $this->faker->text,
            'sender' => array_rand(array_flip(['user', 'company'])),
            'sender_id' => $this->faker->uuid,
            'receiver_id' => $this->faker->uuid,
            'tenant_id' => $tenant->id,
            'social_lead_id' => $socialLead->id,
        ];

        $response = $this->putJson(
            route('api.messages.update', $message),
            $data
        );

        unset($data['social_lead_id']);

        $data['id'] = $message->id;

        $this->assertDatabaseHas('messages', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_message()
    {
        $message = Message::factory()->create();

        $response = $this->deleteJson(route('api.messages.destroy', $message));

        $this->assertModelMissing($message);

        $response->assertNoContent();
    }
}
