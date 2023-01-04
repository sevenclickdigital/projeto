<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ScratchCardPlayer;

use App\Models\Lead;
use App\Models\Tenant;
use App\Models\ScratchCard;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScratchCardPlayerControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_scratch_card_players()
    {
        $scratchCardPlayers = ScratchCardPlayer::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('scratch-card-players.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_card_players.index')
            ->assertViewHas('scratchCardPlayers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_scratch_card_player()
    {
        $response = $this->get(route('scratch-card-players.create'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_card_players.create');
    }

    /**
     * @test
     */
    public function it_stores_the_scratch_card_player()
    {
        $data = ScratchCardPlayer::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('scratch-card-players.store'), $data);

        $this->assertDatabaseHas('scratch_card_players', $data);

        $scratchCardPlayer = ScratchCardPlayer::latest('id')->first();

        $response->assertRedirect(
            route('scratch-card-players.edit', $scratchCardPlayer)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_scratch_card_player()
    {
        $scratchCardPlayer = ScratchCardPlayer::factory()->create();

        $response = $this->get(
            route('scratch-card-players.show', $scratchCardPlayer)
        );

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_card_players.show')
            ->assertViewHas('scratchCardPlayer');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_scratch_card_player()
    {
        $scratchCardPlayer = ScratchCardPlayer::factory()->create();

        $response = $this->get(
            route('scratch-card-players.edit', $scratchCardPlayer)
        );

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_card_players.edit')
            ->assertViewHas('scratchCardPlayer');
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

        $response = $this->put(
            route('scratch-card-players.update', $scratchCardPlayer),
            $data
        );

        $data['id'] = $scratchCardPlayer->id;

        $this->assertDatabaseHas('scratch_card_players', $data);

        $response->assertRedirect(
            route('scratch-card-players.edit', $scratchCardPlayer)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_scratch_card_player()
    {
        $scratchCardPlayer = ScratchCardPlayer::factory()->create();

        $response = $this->delete(
            route('scratch-card-players.destroy', $scratchCardPlayer)
        );

        $response->assertRedirect(route('scratch-card-players.index'));

        $this->assertModelMissing($scratchCardPlayer);
    }
}
