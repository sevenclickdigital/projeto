<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\ScratchCard;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchScratchCardsTest extends TestCase
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
    public function it_gets_branch_scratch_cards()
    {
        $branch = Branch::factory()->create();
        $scratchCard = ScratchCard::factory()->create();

        $branch->scratchCards()->attach($scratchCard);

        $response = $this->getJson(
            route('api.branches.scratch-cards.index', $branch)
        );

        $response->assertOk()->assertSee($scratchCard->name);
    }

    /**
     * @test
     */
    public function it_can_attach_scratch_cards_to_branch()
    {
        $branch = Branch::factory()->create();
        $scratchCard = ScratchCard::factory()->create();

        $response = $this->postJson(
            route('api.branches.scratch-cards.store', [$branch, $scratchCard])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $branch
                ->scratchCards()
                ->where('scratch_cards.id', $scratchCard->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_scratch_cards_from_branch()
    {
        $branch = Branch::factory()->create();
        $scratchCard = ScratchCard::factory()->create();

        $response = $this->deleteJson(
            route('api.branches.scratch-cards.store', [$branch, $scratchCard])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $branch
                ->scratchCards()
                ->where('scratch_cards.id', $scratchCard->id)
                ->exists()
        );
    }
}
