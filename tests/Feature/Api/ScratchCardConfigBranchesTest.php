<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\ScratchCardConfig;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScratchCardConfigBranchesTest extends TestCase
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
    public function it_gets_scratch_card_config_branches()
    {
        $scratchCardConfig = ScratchCardConfig::factory()->create();
        $branch = Branch::factory()->create();

        $scratchCardConfig->branches()->attach($branch);

        $response = $this->getJson(
            route('api.scratch-card-configs.branches.index', $scratchCardConfig)
        );

        $response->assertOk()->assertSee($branch->name);
    }

    /**
     * @test
     */
    public function it_can_attach_branches_to_scratch_card_config()
    {
        $scratchCardConfig = ScratchCardConfig::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->postJson(
            route('api.scratch-card-configs.branches.store', [
                $scratchCardConfig,
                $branch,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $scratchCardConfig
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_branches_from_scratch_card_config()
    {
        $scratchCardConfig = ScratchCardConfig::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->deleteJson(
            route('api.scratch-card-configs.branches.store', [
                $scratchCardConfig,
                $branch,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $scratchCardConfig
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }
}
