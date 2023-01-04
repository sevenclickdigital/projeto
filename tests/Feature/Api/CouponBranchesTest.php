<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Coupon;
use App\Models\Branch;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponBranchesTest extends TestCase
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
    public function it_gets_coupon_branches()
    {
        $coupon = Coupon::factory()->create();
        $branch = Branch::factory()->create();

        $coupon->branches()->attach($branch);

        $response = $this->getJson(
            route('api.coupons.branches.index', $coupon)
        );

        $response->assertOk()->assertSee($branch->name);
    }

    /**
     * @test
     */
    public function it_can_attach_branches_to_coupon()
    {
        $coupon = Coupon::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->postJson(
            route('api.coupons.branches.store', [$coupon, $branch])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $coupon
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_branches_from_coupon()
    {
        $coupon = Coupon::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->deleteJson(
            route('api.coupons.branches.store', [$coupon, $branch])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $coupon
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }
}
