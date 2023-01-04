<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\CategoryProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryProductProductsTest extends TestCase
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
    public function it_gets_category_product_products()
    {
        $categoryProduct = CategoryProduct::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'category_product_id' => $categoryProduct->id,
            ]);

        $response = $this->getJson(
            route('api.category-products.products.index', $categoryProduct)
        );

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_category_product_products()
    {
        $categoryProduct = CategoryProduct::factory()->create();
        $data = Product::factory()
            ->make([
                'category_product_id' => $categoryProduct->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.category-products.products.store', $categoryProduct),
            $data
        );

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals(
            $categoryProduct->id,
            $product->category_product_id
        );
    }
}
