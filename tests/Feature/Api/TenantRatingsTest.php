<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Rating;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantRatingsTest extends TestCase
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
    public function it_gets_tenant_ratings()
    {
        $tenant = Tenant::factory()->create();
        $ratings = Rating::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(route('api.tenants.ratings.index', $tenant));

        $response->assertOk()->assertSee($ratings[0]->award_photo_path);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_ratings()
    {
        $tenant = Tenant::factory()->create();
        $data = Rating::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.ratings.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('ratings', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $rating = Rating::latest('id')->first();

        $this->assertEquals($tenant->id, $rating->tenant_id);
    }
}
