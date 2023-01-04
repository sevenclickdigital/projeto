<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\CategoryProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryProductBranchesTest extends TestCase
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
    public function it_gets_category_product_branches()
    {
        $categoryProduct = CategoryProduct::factory()->create();
        $branch = Branch::factory()->create();

        $categoryProduct->branches()->attach($branch);

        $response = $this->getJson(
            route('api.category-products.branches.index', $categoryProduct)
        );

        $response->assertOk()->assertSee($branch->name);
    }

    /**
     * @test
     */
    public function it_can_attach_branches_to_category_product()
    {
        $categoryProduct = CategoryProduct::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->postJson(
            route('api.category-products.branches.store', [
                $categoryProduct,
                $branch,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $categoryProduct
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_branches_from_category_product()
    {
        $categoryProduct = CategoryProduct::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->deleteJson(
            route('api.category-products.branches.store', [
                $categoryProduct,
                $branch,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $categoryProduct
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }
}
