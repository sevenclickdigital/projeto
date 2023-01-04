<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\ScratchCardPlayer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantScratchCardPlayersTest extends TestCase
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
    public function it_gets_tenant_scratch_card_players()
    {
        $tenant = Tenant::factory()->create();
        $scratchCardPlayers = ScratchCardPlayer::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.scratch-card-players.index', $tenant)
        );

        $response->assertOk()->assertSee($scratchCardPlayers[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_scratch_card_players()
    {
        $tenant = Tenant::factory()->create();
        $data = ScratchCardPlayer::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.scratch-card-players.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('scratch_card_players', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $scratchCardPlayer = ScratchCardPlayer::latest('id')->first();

        $this->assertEquals($tenant->id, $scratchCardPlayer->tenant_id);
    }
}
