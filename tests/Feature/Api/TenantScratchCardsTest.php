<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\ScratchCard;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantScratchCardsTest extends TestCase
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
    public function it_gets_tenant_scratch_cards()
    {
        $tenant = Tenant::factory()->create();
        $scratchCards = ScratchCard::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.scratch-cards.index', $tenant)
        );

        $response->assertOk()->assertSee($scratchCards[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_scratch_cards()
    {
        $tenant = Tenant::factory()->create();
        $data = ScratchCard::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.scratch-cards.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('scratch_cards', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $scratchCard = ScratchCard::latest('id')->first();

        $this->assertEquals($tenant->id, $scratchCard->tenant_id);
    }
}
