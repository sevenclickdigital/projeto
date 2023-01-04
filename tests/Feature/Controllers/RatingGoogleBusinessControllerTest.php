<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\RatingGoogleBusiness;

use App\Models\Tenant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RatingGoogleBusinessControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_rating_google_businesses()
    {
        $ratingGoogleBusinesses = RatingGoogleBusiness::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('rating-google-businesses.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.rating_google_businesses.index')
            ->assertViewHas('ratingGoogleBusinesses');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_rating_google_business()
    {
        $response = $this->get(route('rating-google-businesses.create'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.rating_google_businesses.create');
    }

    /**
     * @test
     */
    public function it_stores_the_rating_google_business()
    {
        $data = RatingGoogleBusiness::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('rating-google-businesses.store'), $data);

        $this->assertDatabaseHas('rating_google_businesses', $data);

        $ratingGoogleBusiness = RatingGoogleBusiness::latest('id')->first();

        $response->assertRedirect(
            route('rating-google-businesses.edit', $ratingGoogleBusiness)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_rating_google_business()
    {
        $ratingGoogleBusiness = RatingGoogleBusiness::factory()->create();

        $response = $this->get(
            route('rating-google-businesses.show', $ratingGoogleBusiness)
        );

        $response
            ->assertOk()
            ->assertViewIs('resources.views.rating_google_businesses.show')
            ->assertViewHas('ratingGoogleBusiness');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_rating_google_business()
    {
        $ratingGoogleBusiness = RatingGoogleBusiness::factory()->create();

        $response = $this->get(
            route('rating-google-businesses.edit', $ratingGoogleBusiness)
        );

        $response
            ->assertOk()
            ->assertViewIs('resources.views.rating_google_businesses.edit')
            ->assertViewHas('ratingGoogleBusiness');
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

        $response = $this->put(
            route('rating-google-businesses.update', $ratingGoogleBusiness),
            $data
        );

        $data['id'] = $ratingGoogleBusiness->id;

        $this->assertDatabaseHas('rating_google_businesses', $data);

        $response->assertRedirect(
            route('rating-google-businesses.edit', $ratingGoogleBusiness)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_rating_google_business()
    {
        $ratingGoogleBusiness = RatingGoogleBusiness::factory()->create();

        $response = $this->delete(
            route('rating-google-businesses.destroy', $ratingGoogleBusiness)
        );

        $response->assertRedirect(route('rating-google-businesses.index'));

        $this->assertModelMissing($ratingGoogleBusiness);
    }
}
