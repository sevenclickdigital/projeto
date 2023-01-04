<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\ScratchCardConfig;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantScratchCardConfigsTest extends TestCase
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
    public function it_gets_tenant_scratch_card_configs()
    {
        $tenant = Tenant::factory()->create();
        $scratchCardConfigs = ScratchCardConfig::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.scratch-card-configs.index', $tenant)
        );

        $response->assertOk()->assertSee($scratchCardConfigs[0]->Keyword);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_scratch_card_configs()
    {
        $tenant = Tenant::factory()->create();
        $data = ScratchCardConfig::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.scratch-card-configs.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('scratch_card_configs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $scratchCardConfig = ScratchCardConfig::latest('id')->first();

        $this->assertEquals($tenant->id, $scratchCardConfig->tenant_id);
    }
}
