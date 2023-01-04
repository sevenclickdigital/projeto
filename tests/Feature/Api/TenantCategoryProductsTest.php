<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\CategoryProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantCategoryProductsTest extends TestCase
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
    public function it_gets_tenant_category_products()
    {
        $tenant = Tenant::factory()->create();
        $categoryProducts = CategoryProduct::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.category-products.index', $tenant)
        );

        $response->assertOk()->assertSee($categoryProducts[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_category_products()
    {
        $tenant = Tenant::factory()->create();
        $data = CategoryProduct::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.category-products.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('category_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $categoryProduct = CategoryProduct::latest('id')->first();

        $this->assertEquals($tenant->id, $categoryProduct->tenant_id);
    }
}
