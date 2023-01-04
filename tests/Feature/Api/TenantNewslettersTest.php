<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Newsletter;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantNewslettersTest extends TestCase
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
    public function it_gets_tenant_newsletters()
    {
        $tenant = Tenant::factory()->create();
        $newsletters = Newsletter::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.newsletters.index', $tenant)
        );

        $response->assertOk()->assertSee($newsletters[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_newsletters()
    {
        $tenant = Tenant::factory()->create();
        $data = Newsletter::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.newsletters.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('newsletters', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $newsletter = Newsletter::latest('id')->first();

        $this->assertEquals($tenant->id, $newsletter->tenant_id);
    }
}
