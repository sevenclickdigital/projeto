<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ScratchCardConfig;

use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScratchCardConfigTest extends TestCase
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
    public function it_gets_scratch_card_configs_list()
    {
        $scratchCardConfigs = ScratchCardConfig::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.scratch-card-configs.index'));

        $response->assertOk()->assertSee($scratchCardConfigs[0]->Keyword);
    }

    /**
     * @test
     */
    public function it_stores_the_scratch_card_config()
    {
        $data = ScratchCardConfig::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.scratch-card-configs.store'),
            $data
        );

        $this->assertDatabaseHas('scratch_card_configs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.scratch-card-configs.update', $scratchCardConfig),
            $data
        );

        $data['id'] = $scratchCardConfig->id;

        $this->assertDatabaseHas('scratch_card_configs', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_scratch_card_config()
    {
        $scratchCardConfig = ScratchCardConfig::factory()->create();

        $response = $this->deleteJson(
            route('api.scratch-card-configs.destroy', $scratchCardConfig)
        );

        $this->assertModelMissing($scratchCardConfig);

        $response->assertNoContent();
    }
}
