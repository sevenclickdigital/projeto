<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Rating;

use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RatingTest extends TestCase
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
    public function it_gets_ratings_list()
    {
        $ratings = Rating::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.ratings.index'));

        $response->assertOk()->assertSee($ratings[0]->award_photo_path);
    }

    /**
     * @test
     */
    public function it_stores_the_rating()
    {
        $data = Rating::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.ratings.store'), $data);

        $this->assertDatabaseHas('ratings', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.ratings.update', $rating), $data);

        $data['id'] = $rating->id;

        $this->assertDatabaseHas('ratings', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_rating()
    {
        $rating = Rating::factory()->create();

        $response = $this->deleteJson(route('api.ratings.destroy', $rating));

        $this->assertModelMissing($rating);

        $response->assertNoContent();
    }
}
