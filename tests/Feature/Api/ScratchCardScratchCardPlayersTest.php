<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ScratchCard;
use App\Models\ScratchCardPlayer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScratchCardScratchCardPlayersTest extends TestCase
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
    public function it_gets_scratch_card_scratch_card_players()
    {
        $scratchCard = ScratchCard::factory()->create();
        $scratchCardPlayers = ScratchCardPlayer::factory()
            ->count(2)
            ->create([
                'scratch_card_id' => $scratchCard->id,
            ]);

        $response = $this->getJson(
            route('api.scratch-cards.scratch-card-players.index', $scratchCard)
        );

        $response->assertOk()->assertSee($scratchCardPlayers[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_scratch_card_scratch_card_players()
    {
        $scratchCard = ScratchCard::factory()->create();
        $data = ScratchCardPlayer::factory()
            ->make([
                'scratch_card_id' => $scratchCard->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.scratch-cards.scratch-card-players.store', $scratchCard),
            $data
        );

        $this->assertDatabaseHas('scratch_card_players', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $scratchCardPlayer = ScratchCardPlayer::latest('id')->first();

        $this->assertEquals(
            $scratchCard->id,
            $scratchCardPlayer->scratch_card_id
        );
    }
}
