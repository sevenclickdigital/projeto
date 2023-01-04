<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Rating;
use App\Models\Branch;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RatingBranchesTest extends TestCase
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
    public function it_gets_rating_branches()
    {
        $rating = Rating::factory()->create();
        $branch = Branch::factory()->create();

        $rating->branches()->attach($branch);

        $response = $this->getJson(
            route('api.ratings.branches.index', $rating)
        );

        $response->assertOk()->assertSee($branch->name);
    }

    /**
     * @test
     */
    public function it_can_attach_branches_to_rating()
    {
        $rating = Rating::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->postJson(
            route('api.ratings.branches.store', [$rating, $branch])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $rating
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_branches_from_rating()
    {
        $rating = Rating::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->deleteJson(
            route('api.ratings.branches.store', [$rating, $branch])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $rating
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }
}
