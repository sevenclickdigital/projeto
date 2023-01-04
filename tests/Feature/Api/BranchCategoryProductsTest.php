<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\CategoryProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchCategoryProductsTest extends TestCase
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
    public function it_gets_branch_category_products()
    {
        $branch = Branch::factory()->create();
        $categoryProduct = CategoryProduct::factory()->create();

        $branch->categoryProducts()->attach($categoryProduct);

        $response = $this->getJson(
            route('api.branches.category-products.index', $branch)
        );

        $response->assertOk()->assertSee($categoryProduct->name);
    }

    /**
     * @test
     */
    public function it_can_attach_category_products_to_branch()
    {
        $branch = Branch::factory()->create();
        $categoryProduct = CategoryProduct::factory()->create();

        $response = $this->postJson(
            route('api.branches.category-products.store', [
                $branch,
                $categoryProduct,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $branch
                ->categoryProducts()
                ->where('category_products.id', $categoryProduct->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_category_products_from_branch()
    {
        $branch = Branch::factory()->create();
        $categoryProduct = CategoryProduct::factory()->create();

        $response = $this->deleteJson(
            route('api.branches.category-products.store', [
                $branch,
                $categoryProduct,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $branch
                ->categoryProducts()
                ->where('category_products.id', $categoryProduct->id)
                ->exists()
        );
    }
}
