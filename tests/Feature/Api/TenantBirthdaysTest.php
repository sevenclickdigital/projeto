<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Birthday;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantBirthdaysTest extends TestCase
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
    public function it_gets_tenant_birthdays()
    {
        $tenant = Tenant::factory()->create();
        $birthdays = Birthday::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.birthdays.index', $tenant)
        );

        $response->assertOk()->assertSee($birthdays[0]->subject);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_birthdays()
    {
        $tenant = Tenant::factory()->create();
        $data = Birthday::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.birthdays.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('birthdays', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $birthday = Birthday::latest('id')->first();

        $this->assertEquals($tenant->id, $birthday->tenant_id);
    }
}
