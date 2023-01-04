<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ScratchCardConfig;

use App\Models\Tenant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScratchCardConfigControllerTest extends TestCase
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
    public function it_displays_index_view_with_scratch_card_configs()
    {
        $scratchCardConfigs = ScratchCardConfig::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('scratch-card-configs.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_card_configs.index')
            ->assertViewHas('scratchCardConfigs');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_scratch_card_config()
    {
        $response = $this->get(route('scratch-card-configs.create'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_card_configs.create');
    }

    /**
     * @test
     */
    public function it_stores_the_scratch_card_config()
    {
        $data = ScratchCardConfig::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('scratch-card-configs.store'), $data);

        $this->assertDatabaseHas('scratch_card_configs', $data);

        $scratchCardConfig = ScratchCardConfig::latest('id')->first();

        $response->assertRedirect(
            route('scratch-card-configs.edit', $scratchCardConfig)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_scratch_card_config()
    {
        $scratchCardConfig = ScratchCardConfig::factory()->create();

        $response = $this->get(
            route('scratch-card-configs.show', $scratchCardConfig)
        );

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_card_configs.show')
            ->assertViewHas('scratchCardConfig');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_scratch_card_config()
    {
        $scratchCardConfig = ScratchCardConfig::factory()->create();

        $response = $this->get(
            route('scratch-card-configs.edit', $scratchCardConfig)
        );

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_card_configs.edit')
            ->assertViewHas('scratchCardConfig');
    }

    /**
     * @test
     */
    public function it_updates_the_scratch_card_config()
    {
        $scratchCardConfig = ScratchCardConfig::factory()->create();

        $tenant = Tenant::factory()->create();

        $data = [
            'Keyword' => $this->faker->text(255),
            'when_send' => array_rand(
                array_flip(['no_send', 'one_week', 'two_weeks', 'one_month']),
                1
            ),
            'winner_photo_path' => $this->faker->text,
            'loser_photo_path' => $this->faker->text,
            'tenant_id' => $tenant->id,
        ];

        $response = $this->put(
            route('scratch-card-configs.update', $scratchCardConfig),
            $data
        );

        $data['id'] = $scratchCardConfig->id;

        $this->assertDatabaseHas('scratch_card_configs', $data);

        $response->assertRedirect(
            route('scratch-card-configs.edit', $scratchCardConfig)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_scratch_card_config()
    {
        $scratchCardConfig = ScratchCardConfig::factory()->create();

        $response = $this->delete(
            route('scratch-card-configs.destroy', $scratchCardConfig)
        );

        $response->assertRedirect(route('scratch-card-configs.index'));

        $this->assertModelMissing($scratchCardConfig);
    }
}
