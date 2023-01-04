<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ScratchCardPlayer;

use App\Models\Lead;
use App\Models\Tenant;
use App\Models\ScratchCard;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScratchCardPlayerTest extends TestCase
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
    public function it_gets_scratch_card_players_list()
    {
        $scratchCardPlayers = ScratchCardPlayer::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.scratch-card-players.index'));

        $response->assertOk()->assertSee($scratchCardPlayers[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_scratch_card_player()
    {
        $data = ScratchCardPlayer::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.scratch-card-players.store'),
            $data
        );

        $this->assertDatabaseHas('scratch_card_players', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_scratch_card_player()
    {
        $scratchCardPlayer = ScratchCardPlayer::factory()->create();

        $tenant = Tenant::factory()->create();
        $scratchCard = ScratchCard::factory()->create();
        $lead = Lead::factory()->create();

        $data = [
            'winner' => $this->faker->boolean,
            'tenant_id' => $tenant->id,
            'scratch_card_id' => $scratchCard->id,
            'lead_id' => $lead->id,
        ];

        $response = $this->putJson(
            route('api.scratch-card-players.update', $scratchCardPlayer),
            $data
        );

        $data['id'] = $scratchCardPlayer->id;

        $this->assertDatabaseHas('scratch_card_players', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_scratch_card_player()
    {
        $scratchCardPlayer = ScratchCardPlayer::factory()->create();

        $response = $this->deleteJson(
            route('api.scratch-card-players.destroy', $scratchCardPlayer)
        );

        $this->assertModelMissing($scratchCardPlayer);

        $response->assertNoContent();
    }
}
