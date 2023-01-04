<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\ScratchCardConfig;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchScratchCardConfigsTest extends TestCase
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
    public function it_gets_branch_scratch_card_configs()
    {
        $branch = Branch::factory()->create();
        $scratchCardConfig = ScratchCardConfig::factory()->create();

        $branch->scratchCardConfigs()->attach($scratchCardConfig);

        $response = $this->getJson(
            route('api.branches.scratch-card-configs.index', $branch)
        );

        $response->assertOk()->assertSee($scratchCardConfig->Keyword);
    }

    /**
     * @test
     */
    public function it_can_attach_scratch_card_configs_to_branch()
    {
        $branch = Branch::factory()->create();
        $scratchCardConfig = ScratchCardConfig::factory()->create();

        $response = $this->postJson(
            route('api.branches.scratch-card-configs.store', [
                $branch,
                $scratchCardConfig,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $branch
                ->scratchCardConfigs()
                ->where('scratch_card_configs.id', $scratchCardConfig->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_scratch_card_configs_from_branch()
    {
        $branch = Branch::factory()->create();
        $scratchCardConfig = ScratchCardConfig::factory()->create();

        $response = $this->deleteJson(
            route('api.branches.scratch-card-configs.store', [
                $branch,
                $scratchCardConfig,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $branch
                ->scratchCardConfigs()
                ->where('scratch_card_configs.id', $scratchCardConfig->id)
                ->exists()
        );
    }
}
