<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\Rating;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchRatingsTest extends TestCase
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
    public function it_gets_branch_ratings()
    {
        $branch = Branch::factory()->create();
        $rating = Rating::factory()->create();

        $branch->ratings()->attach($rating);

        $response = $this->getJson(
            route('api.branches.ratings.index', $branch)
        );

        $response->assertOk()->assertSee($rating->award_photo_path);
    }

    /**
     * @test
     */
    public function it_can_attach_ratings_to_branch()
    {
        $branch = Branch::factory()->create();
        $rating = Rating::factory()->create();

        $response = $this->postJson(
            route('api.branches.ratings.store', [$branch, $rating])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $branch
                ->ratings()
                ->where('ratings.id', $rating->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_ratings_from_branch()
    {
        $branch = Branch::factory()->create();
        $rating = Rating::factory()->create();

        $response = $this->deleteJson(
            route('api.branches.ratings.store', [$branch, $rating])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $branch
                ->ratings()
                ->where('ratings.id', $rating->id)
                ->exists()
        );
    }
}
