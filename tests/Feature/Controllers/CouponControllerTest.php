<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Coupon;

use App\Models\Tenant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponControllerTest extends TestCase
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
    public function it_displays_index_view_with_coupons()
    {
        $coupons = Coupon::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('coupons.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.coupons.index')
            ->assertViewHas('coupons');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_coupon()
    {
        $response = $this->get(route('coupons.create'));

        $response->assertOk()->assertViewIs('resources.views.coupons.create');
    }

    /**
     * @test
     */
    public function it_stores_the_coupon()
    {
        $data = Coupon::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('coupons.store'), $data);

        $this->assertDatabaseHas('coupons', $data);

        $coupon = Coupon::latest('id')->first();

        $response->assertRedirect(route('coupons.edit', $coupon));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_coupon()
    {
        $coupon = Coupon::factory()->create();

        $response = $this->get(route('coupons.show', $coupon));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.coupons.show')
            ->assertViewHas('coupon');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_coupon()
    {
        $coupon = Coupon::factory()->create();

        $response = $this->get(route('coupons.edit', $coupon));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.coupons.edit')
            ->assertViewHas('coupon');
    }

    /**
     * @test
     */
    public function it_updates_the_coupon()
    {
        $coupon = Coupon::factory()->create();

        $tenant = Tenant::factory()->create();

        $data = [
            'active' => $this->faker->boolean,
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->sentence(15),
            'code' => $this->faker->text(255),
            'coupon_type' => 'default',
            'limit' => $this->faker->randomNumber(0),
            'start_date' => $this->faker->date,
            'expire_date' => $this->faker->date,
            'min_purchase' => $this->faker->randomNumber(1),
            'max_discount' => $this->faker->randomNumber(1),
            'discount_type' => 'amount',
            'discount' => $this->faker->randomFloat(2, 0, 9999),
            'when_send' => $this->faker->dateTime,
            'tenant_id' => $tenant->id,
        ];

        $response = $this->put(route('coupons.update', $coupon), $data);

        $data['id'] = $coupon->id;

        $this->assertDatabaseHas('coupons', $data);

        $response->assertRedirect(route('coupons.edit', $coupon));
    }

    /**
     * @test
     */
    public function it_deletes_the_coupon()
    {
        $coupon = Coupon::factory()->create();

        $response = $this->delete(route('coupons.destroy', $coupon));

        $response->assertRedirect(route('coupons.index'));

        $this->assertModelMissing($coupon);
    }
}
