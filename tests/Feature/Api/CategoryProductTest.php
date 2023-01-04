<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\CategoryProduct;

use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryProductTest extends TestCase
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
    public function it_gets_category_products_list()
    {
        $categoryProducts = CategoryProduct::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.category-products.index'));

        $response->assertOk()->assertSee($categoryProducts[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_category_product()
    {
        $data = CategoryProduct::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.category-products.store'),
            $data
        );

        $this->assertDatabaseHas('category_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_category_product()
    {
        $categoryProduct = CategoryProduct::factory()->create();

        $tenant = Tenant::factory()->create();

        $data = [
            'active' => $this->faker->boolean,
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'category_photo_path' => $this->faker->text,
            'tenant_id' => $tenant->id,
        ];

        $response = $this->putJson(
            route('api.category-products.update', $categoryProduct),
            $data
        );

        $data['id'] = $categoryProduct->id;

        $this->assertDatabaseHas('category_products', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_category_product()
    {
        $categoryProduct = CategoryProduct::factory()->create();

        $response = $this->deleteJson(
            route('api.category-products.destroy', $categoryProduct)
        );

        $this->assertModelMissing($categoryProduct);

        $response->assertNoContent();
    }
}
