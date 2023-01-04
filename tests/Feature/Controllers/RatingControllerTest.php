<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Rating;

use App\Models\Tenant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RatingControllerTest extends TestCase
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
    public function it_displays_index_view_with_ratings()
    {
        $ratings = Rating::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('ratings.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.ratings.index')
            ->assertViewHas('ratings');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_rating()
    {
        $response = $this->get(route('ratings.create'));

        $response->assertOk()->assertViewIs('resources.views.ratings.create');
    }

    /**
     * @test
     */
    public function it_stores_the_rating()
    {
        $data = Rating::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('ratings.store'), $data);

        $this->assertDatabaseHas('ratings', $data);

        $rating = Rating::latest('id')->first();

        $response->assertRedirect(route('ratings.edit', $rating));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_rating()
    {
        $rating = Rating::factory()->create();

        $response = $this->get(route('ratings.show', $rating));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.ratings.show')
            ->assertViewHas('rating');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_rating()
    {
        $rating = Rating::factory()->create();

        $response = $this->get(route('ratings.edit', $rating));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.ratings.edit')
            ->assertViewHas('rating');
    }

    /**
     * @test
     */
    public function it_updates_the_rating()
    {
        $rating = Rating::factory()->create();

        $tenant = Tenant::factory()->create();

        $data = [
            'active' => $this->faker->boolean,
            'award_photo_path' => $this->faker->text,
            'subject' => $this->faker->text(255),
            'content' => $this->faker->text,
            'tenant_id' => $tenant->id,
        ];

        $response = $this->put(route('ratings.update', $rating), $data);

        $data['id'] = $rating->id;

        $this->assertDatabaseHas('ratings', $data);

        $response->assertRedirect(route('ratings.edit', $rating));
    }

    /**
     * @test
     */
    public function it_deletes_the_rating()
    {
        $rating = Rating::factory()->create();

        $response = $this->delete(route('ratings.destroy', $rating));

        $response->assertRedirect(route('ratings.index'));

        $this->assertModelMissing($rating);
    }
}
