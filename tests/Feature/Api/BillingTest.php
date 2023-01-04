<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Billing;

use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BillingTest extends TestCase
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
    public function it_gets_billings_list()
    {
        $billings = Billing::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.billings.index'));

        $response->assertOk()->assertSee($billings[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_billing()
    {
        $data = Billing::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.billings.store'), $data);

        $this->assertDatabaseHas('billings', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_billing()
    {
        $billing = Billing::factory()->create();

        $tenant = Tenant::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'tenant_id' => $tenant->id,
        ];

        $response = $this->putJson(
            route('api.billings.update', $billing),
            $data
        );

        $data['id'] = $billing->id;

        $this->assertDatabaseHas('billings', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_billing()
    {
        $billing = Billing::factory()->create();

        $response = $this->deleteJson(route('api.billings.destroy', $billing));

        $this->assertModelMissing($billing);

        $response->assertNoContent();
    }
}
