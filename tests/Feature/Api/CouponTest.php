<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Coupon;

use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponTest extends TestCase
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
    public function it_gets_coupons_list()
    {
        $coupons = Coupon::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.coupons.index'));

        $response->assertOk()->assertSee($coupons[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_coupon()
    {
        $data = Coupon::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.coupons.store'), $data);

        $this->assertDatabaseHas('coupons', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.coupons.update', $coupon), $data);

        $data['id'] = $coupon->id;

        $this->assertDatabaseHas('coupons', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_coupon()
    {
        $coupon = Coupon::factory()->create();

        $response = $this->deleteJson(route('api.coupons.destroy', $coupon));

        $this->assertModelMissing($coupon);

        $response->assertNoContent();
    }
}
