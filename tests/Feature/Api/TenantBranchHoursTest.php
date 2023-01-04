<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\BranchHour;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantBranchHoursTest extends TestCase
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
    public function it_gets_tenant_branch_hours()
    {
        $tenant = Tenant::factory()->create();
        $branchHours = BranchHour::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.branch-hours.index', $tenant)
        );

        $response->assertOk()->assertSee($branchHours[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_branch_hours()
    {
        $tenant = Tenant::factory()->create();
        $data = BranchHour::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.branch-hours.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('branch_hours', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $branchHour = BranchHour::latest('id')->first();

        $this->assertEquals($tenant->id, $branchHour->tenant_id);
    }
}
