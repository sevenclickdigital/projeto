<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Billing;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantBillingsTest extends TestCase
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
    public function it_gets_tenant_billings()
    {
        $tenant = Tenant::factory()->create();
        $billings = Billing::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.billings.index', $tenant)
        );

        $response->assertOk()->assertSee($billings[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_billings()
    {
        $tenant = Tenant::factory()->create();
        $data = Billing::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.billings.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('billings', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $billing = Billing::latest('id')->first();

        $this->assertEquals($tenant->id, $billing->tenant_id);
    }
}
