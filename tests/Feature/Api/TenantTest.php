<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantTest extends TestCase
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
    public function it_gets_tenants_list()
    {
        $tenants = Tenant::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.tenants.index'));

        $response->assertOk()->assertSee($tenants[0]->facebook_page_id);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant()
    {
        $data = Tenant::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.tenants.store'), $data);

        $this->assertDatabaseHas('tenants', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_tenant()
    {
        $tenant = Tenant::factory()->create();

        $data = [
            'max_lead' => $this->faker->randomNumber(0),
            'max_branch' => $this->faker->randomNumber(0),
            'facebook_page_id' => $this->faker->text,
            'facebook_access_token' => $this->faker->text,
            'instagram_page_id' => $this->faker->text,
            'instagram_access_token' => $this->faker->text,
            'color_primary' => $this->faker->hexcolor,
            'color_secondary' => $this->faker->hexcolor,
            'custom_font' => $this->faker->text(255),
            'participation_terms' => $this->faker->text,
            'privacy' => $this->faker->text,
            'terms_of_use' => $this->faker->text,
        ];

        $response = $this->putJson(route('api.tenants.update', $tenant), $data);

        $data['id'] = $tenant->id;

        $this->assertDatabaseHas('tenants', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_tenant()
    {
        $tenant = Tenant::factory()->create();

        $response = $this->deleteJson(route('api.tenants.destroy', $tenant));

        $this->assertModelMissing($tenant);

        $response->assertNoContent();
    }
}
