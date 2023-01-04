<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\RatingGoogleBusiness;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantRatingGoogleBusinessesTest extends TestCase
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
    public function it_gets_tenant_rating_google_businesses()
    {
        $tenant = Tenant::factory()->create();
        $ratingGoogleBusinesses = RatingGoogleBusiness::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.rating-google-businesses.index', $tenant)
        );

        $response->assertOk()->assertSee($ratingGoogleBusinesses[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_rating_google_businesses()
    {
        $tenant = Tenant::factory()->create();
        $data = RatingGoogleBusiness::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.rating-google-businesses.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('rating_google_businesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $ratingGoogleBusiness = RatingGoogleBusiness::latest('id')->first();

        $this->assertEquals($tenant->id, $ratingGoogleBusiness->tenant_id);
    }
}
