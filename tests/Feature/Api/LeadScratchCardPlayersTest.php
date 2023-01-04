<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\ScratchCardPlayer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadScratchCardPlayersTest extends TestCase
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
    public function it_gets_lead_scratch_card_players()
    {
        $lead = Lead::factory()->create();
        $scratchCardPlayers = ScratchCardPlayer::factory()
            ->count(2)
            ->create([
                'lead_id' => $lead->id,
            ]);

        $response = $this->getJson(
            route('api.leads.scratch-card-players.index', $lead)
        );

        $response->assertOk()->assertSee($scratchCardPlayers[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_lead_scratch_card_players()
    {
        $lead = Lead::factory()->create();
        $data = ScratchCardPlayer::factory()
            ->make([
                'lead_id' => $lead->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.leads.scratch-card-players.store', $lead),
            $data
        );

        $this->assertDatabaseHas('scratch_card_players', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $scratchCardPlayer = ScratchCardPlayer::latest('id')->first();

        $this->assertEquals($lead->id, $scratchCardPlayer->lead_id);
    }
}
