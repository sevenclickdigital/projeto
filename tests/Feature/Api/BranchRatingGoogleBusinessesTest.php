<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\RatingGoogleBusiness;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchRatingGoogleBusinessesTest extends TestCase
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
    public function it_gets_branch_rating_google_businesses()
    {
        $branch = Branch::factory()->create();
        $ratingGoogleBusiness = RatingGoogleBusiness::factory()->create();

        $branch->ratingGoogleBusinesses()->attach($ratingGoogleBusiness);

        $response = $this->getJson(
            route('api.branches.rating-google-businesses.index', $branch)
        );

        $response->assertOk()->assertSee($ratingGoogleBusiness->name);
    }

    /**
     * @test
     */
    public function it_can_attach_rating_google_businesses_to_branch()
    {
        $branch = Branch::factory()->create();
        $ratingGoogleBusiness = RatingGoogleBusiness::factory()->create();

        $response = $this->postJson(
            route('api.branches.rating-google-businesses.store', [
                $branch,
                $ratingGoogleBusiness,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $branch
                ->ratingGoogleBusinesses()
                ->where(
                    'rating_google_businesses.id',
                    $ratingGoogleBusiness->id
                )
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_rating_google_businesses_from_branch()
    {
        $branch = Branch::factory()->create();
        $ratingGoogleBusiness = RatingGoogleBusiness::factory()->create();

        $response = $this->deleteJson(
            route('api.branches.rating-google-businesses.store', [
                $branch,
                $ratingGoogleBusiness,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $branch
                ->ratingGoogleBusinesses()
                ->where(
                    'rating_google_businesses.id',
                    $ratingGoogleBusiness->id
                )
                ->exists()
        );
    }
}
