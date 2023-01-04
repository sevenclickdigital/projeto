<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Coupon;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantCouponsTest extends TestCase
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
    public function it_gets_tenant_coupons()
    {
        $tenant = Tenant::factory()->create();
        $coupons = Coupon::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(route('api.tenants.coupons.index', $tenant));

        $response->assertOk()->assertSee($coupons[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_coupons()
    {
        $tenant = Tenant::factory()->create();
        $data = Coupon::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.coupons.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('coupons', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $coupon = Coupon::latest('id')->first();

        $this->assertEquals($tenant->id, $coupon->tenant_id);
    }
}
