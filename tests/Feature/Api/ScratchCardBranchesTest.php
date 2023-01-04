<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\ScratchCard;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScratchCardBranchesTest extends TestCase
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
    public function it_gets_scratch_card_branches()
    {
        $scratchCard = ScratchCard::factory()->create();
        $branch = Branch::factory()->create();

        $scratchCard->branches()->attach($branch);

        $response = $this->getJson(
            route('api.scratch-cards.branches.index', $scratchCard)
        );

        $response->assertOk()->assertSee($branch->name);
    }

    /**
     * @test
     */
    public function it_can_attach_branches_to_scratch_card()
    {
        $scratchCard = ScratchCard::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->postJson(
            route('api.scratch-cards.branches.store', [$scratchCard, $branch])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $scratchCard
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_branches_from_scratch_card()
    {
        $scratchCard = ScratchCard::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->deleteJson(
            route('api.scratch-cards.branches.store', [$scratchCard, $branch])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $scratchCard
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }
}
