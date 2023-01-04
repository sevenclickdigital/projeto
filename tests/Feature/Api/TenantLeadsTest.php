<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantLeadsTest extends TestCase
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
    public function it_gets_tenant_leads()
    {
        $tenant = Tenant::factory()->create();
        $leads = Lead::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(route('api.tenants.leads.index', $tenant));

        $response->assertOk()->assertSee($leads[0]->first_name);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_leads()
    {
        $tenant = Tenant::factory()->create();
        $data = Lead::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.leads.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('leads', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $lead = Lead::latest('id')->first();

        $this->assertEquals($tenant->id, $lead->tenant_id);
    }
}
