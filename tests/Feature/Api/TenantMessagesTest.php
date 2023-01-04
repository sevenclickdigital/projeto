<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Message;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantMessagesTest extends TestCase
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
    public function it_gets_tenant_messages()
    {
        $tenant = Tenant::factory()->create();
        $messages = Message::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.messages.index', $tenant)
        );

        $response->assertOk()->assertSee($messages[0]->message_key);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_messages()
    {
        $tenant = Tenant::factory()->create();
        $data = Message::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.messages.store', $tenant),
            $data
        );

        unset($data['social_lead_id']);

        $this->assertDatabaseHas('messages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $message = Message::latest('id')->first();

        $this->assertEquals($tenant->id, $message->tenant_id);
    }
}
