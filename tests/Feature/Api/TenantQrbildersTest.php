<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Qrbilder;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantQrbildersTest extends TestCase
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
    public function it_gets_tenant_qrbilders()
    {
        $tenant = Tenant::factory()->create();
        $qrbilders = Qrbilder::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.qrbilders.index', $tenant)
        );

        $response->assertOk()->assertSee($qrbilders[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_qrbilders()
    {
        $tenant = Tenant::factory()->create();
        $data = Qrbilder::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.qrbilders.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('qrbilders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $qrbilder = Qrbilder::latest('id')->first();

        $this->assertEquals($tenant->id, $qrbilder->tenant_id);
    }
}
