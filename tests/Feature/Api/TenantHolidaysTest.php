<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Holiday;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantHolidaysTest extends TestCase
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
    public function it_gets_tenant_holidays()
    {
        $tenant = Tenant::factory()->create();
        $holidays = Holiday::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.holidays.index', $tenant)
        );

        $response->assertOk()->assertSee($holidays[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_holidays()
    {
        $tenant = Tenant::factory()->create();
        $data = Holiday::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.holidays.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('holidays', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $holiday = Holiday::latest('id')->first();

        $this->assertEquals($tenant->id, $holiday->tenant_id);
    }
}
