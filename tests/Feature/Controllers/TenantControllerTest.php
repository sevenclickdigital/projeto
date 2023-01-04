<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Tenant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_tenants()
    {
        $tenants = Tenant::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('tenants.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.tenants.index')
            ->assertViewHas('tenants');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_tenant()
    {
        $response = $this->get(route('tenants.create'));

        $response->assertOk()->assertViewIs('resources.views.tenants.create');
    }

    /**
     * @test
     */
    public function it_stores_the_tenant()
    {
        $data = Tenant::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('tenants.store'), $data);

        $this->assertDatabaseHas('tenants', $data);

        $tenant = Tenant::latest('id')->first();

        $response->assertRedirect(route('tenants.edit', $tenant));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_tenant()
    {
        $tenant = Tenant::factory()->create();

        $response = $this->get(route('tenants.show', $tenant));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.tenants.show')
            ->assertViewHas('tenant');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_tenant()
    {
        $tenant = Tenant::factory()->create();

        $response = $this->get(route('tenants.edit', $tenant));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.tenants.edit')
            ->assertViewHas('tenant');
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

        $response = $this->put(route('tenants.update', $tenant), $data);

        $data['id'] = $tenant->id;

        $this->assertDatabaseHas('tenants', $data);

        $response->assertRedirect(route('tenants.edit', $tenant));
    }

    /**
     * @test
     */
    public function it_deletes_the_tenant()
    {
        $tenant = Tenant::factory()->create();

        $response = $this->delete(route('tenants.destroy', $tenant));

        $response->assertRedirect(route('tenants.index'));

        $this->assertModelMissing($tenant);
    }
}
