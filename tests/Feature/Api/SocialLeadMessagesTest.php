<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Message;
use App\Models\SocialLead;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SocialLeadMessagesTest extends TestCase
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
    public function it_gets_social_lead_messages()
    {
        $socialLead = SocialLead::factory()->create();
        $messages = Message::factory()
            ->count(2)
            ->create([
                'social_lead_id' => $socialLead->id,
            ]);

        $response = $this->getJson(
            route('api.social-leads.messages.index', $socialLead)
        );

        $response->assertOk()->assertSee($messages[0]->message_key);
    }

    /**
     * @test
     */
    public function it_stores_the_social_lead_messages()
    {
        $socialLead = SocialLead::factory()->create();
        $data = Message::factory()
            ->make([
                'social_lead_id' => $socialLead->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.social-leads.messages.store', $socialLead),
            $data
        );

        unset($data['social_lead_id']);

        $this->assertDatabaseHas('messages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $message = Message::latest('id')->first();

        $this->assertEquals($socialLead->id, $message->social_lead_id);
    }
}
