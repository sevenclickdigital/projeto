<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\RatingGoogleBusiness;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RatingGoogleBusinessBranchesTest extends TestCase
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
    public function it_gets_rating_google_business_branches()
    {
        $ratingGoogleBusiness = RatingGoogleBusiness::factory()->create();
        $branch = Branch::factory()->create();

        $ratingGoogleBusiness->branches()->attach($branch);

        $response = $this->getJson(
            route(
                'api.rating-google-businesses.branches.index',
                $ratingGoogleBusiness
            )
        );

        $response->assertOk()->assertSee($branch->name);
    }

    /**
     * @test
     */
    public function it_can_attach_branches_to_rating_google_business()
    {
        $ratingGoogleBusiness = RatingGoogleBusiness::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->postJson(
            route('api.rating-google-businesses.branches.store', [
                $ratingGoogleBusiness,
                $branch,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $ratingGoogleBusiness
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_branches_from_rating_google_business()
    {
        $ratingGoogleBusiness = RatingGoogleBusiness::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->deleteJson(
            route('api.rating-google-businesses.branches.store', [
                $ratingGoogleBusiness,
                $branch,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $ratingGoogleBusiness
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }
}
