<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Billing;

use App\Models\Tenant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BillingControllerTest extends TestCase
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
    public function it_displays_index_view_with_billings()
    {
        $billings = Billing::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('billings.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.billings.index')
            ->assertViewHas('billings');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_billing()
    {
        $response = $this->get(route('billings.create'));

        $response->assertOk()->assertViewIs('resources.views.billings.create');
    }

    /**
     * @test
     */
    public function it_stores_the_billing()
    {
        $data = Billing::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('billings.store'), $data);

        $this->assertDatabaseHas('billings', $data);

        $billing = Billing::latest('id')->first();

        $response->assertRedirect(route('billings.edit', $billing));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_billing()
    {
        $billing = Billing::factory()->create();

        $response = $this->get(route('billings.show', $billing));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.billings.show')
            ->assertViewHas('billing');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_billing()
    {
        $billing = Billing::factory()->create();

        $response = $this->get(route('billings.edit', $billing));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.billings.edit')
            ->assertViewHas('billing');
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

        $response = $this->put(route('billings.update', $billing), $data);

        $data['id'] = $billing->id;

        $this->assertDatabaseHas('billings', $data);

        $response->assertRedirect(route('billings.edit', $billing));
    }

    /**
     * @test
     */
    public function it_deletes_the_billing()
    {
        $billing = Billing::factory()->create();

        $response = $this->delete(route('billings.destroy', $billing));

        $response->assertRedirect(route('billings.index'));

        $this->assertModelMissing($billing);
    }
}
