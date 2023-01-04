<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\Coupon;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchCouponsTest extends TestCase
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
    public function it_gets_branch_coupons()
    {
        $branch = Branch::factory()->create();
        $coupon = Coupon::factory()->create();

        $branch->coupons()->attach($coupon);

        $response = $this->getJson(
            route('api.branches.coupons.index', $branch)
        );

        $response->assertOk()->assertSee($coupon->title);
    }

    /**
     * @test
     */
    public function it_can_attach_coupons_to_branch()
    {
        $branch = Branch::factory()->create();
        $coupon = Coupon::factory()->create();

        $response = $this->postJson(
            route('api.branches.coupons.store', [$branch, $coupon])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $branch
                ->coupons()
                ->where('coupons.id', $coupon->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_coupons_from_branch()
    {
        $branch = Branch::factory()->create();
        $coupon = Coupon::factory()->create();

        $response = $this->deleteJson(
            route('api.branches.coupons.store', [$branch, $coupon])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $branch
                ->coupons()
                ->where('coupons.id', $coupon->id)
                ->exists()
        );
    }
}
