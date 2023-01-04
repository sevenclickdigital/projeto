<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\RatingGoogleBusiness;

use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RatingGoogleBusinessTest extends TestCase
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
    public function it_gets_rating_google_businesses_list()
    {
        $ratingGoogleBusinesses = RatingGoogleBusiness::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.rating-google-businesses.index'));

        $response->assertOk()->assertSee($ratingGoogleBusinesses[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_rating_google_business()
    {
        $data = RatingGoogleBusiness::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.rating-google-businesses.store'),
            $data
        );

        $this->assertDatabaseHas('rating_google_businesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_rating_google_business()
    {
        $ratingGoogleBusiness = RatingGoogleBusiness::factory()->create();

        $tenant = Tenant::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'text' => $this->faker->text,
            'stars' => array_rand(
                array_flip([
                    'one_star',
                    'two_stars',
                    'three_stars',
                    'four_stars',
                    'five_stars',
                ])
            ),
            'tenant_id' => $tenant->id,
        ];

        $response = $this->putJson(
            route('api.rating-google-businesses.update', $ratingGoogleBusiness),
            $data
        );

        $data['id'] = $ratingGoogleBusiness->id;

        $this->assertDatabaseHas('rating_google_businesses', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_rating_google_business()
    {
        $ratingGoogleBusiness = RatingGoogleBusiness::factory()->create();

        $response = $this->deleteJson(
            route('api.rating-google-businesses.destroy', $ratingGoogleBusiness)
        );

        $this->assertModelMissing($ratingGoogleBusiness);

        $response->assertNoContent();
    }
}
