<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Branch;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantBranchesTest extends TestCase
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
    public function it_gets_tenant_branches()
    {
        $tenant = Tenant::factory()->create();
        $branches = Branch::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.branches.index', $tenant)
        );

        $response->assertOk()->assertSee($branches[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_branches()
    {
        $tenant = Tenant::factory()->create();
        $data = Branch::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.branches.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('branches', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $branch = Branch::latest('id')->first();

        $this->assertEquals($tenant->id, $branch->tenant_id);
    }
}
