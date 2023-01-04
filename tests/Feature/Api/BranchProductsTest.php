<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchProductsTest extends TestCase
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
    public function it_gets_branch_products()
    {
        $branch = Branch::factory()->create();
        $product = Product::factory()->create();

        $branch->products()->attach($product);

        $response = $this->getJson(
            route('api.branches.products.index', $branch)
        );

        $response->assertOk()->assertSee($product->name);
    }

    /**
     * @test
     */
    public function it_can_attach_products_to_branch()
    {
        $branch = Branch::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.branches.products.store', [$branch, $product])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $branch
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_products_from_branch()
    {
        $branch = Branch::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.branches.products.store', [$branch, $product])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $branch
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }
}
