<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductBranchesTest extends TestCase
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
    public function it_gets_product_branches()
    {
        $product = Product::factory()->create();
        $branch = Branch::factory()->create();

        $product->branches()->attach($branch);

        $response = $this->getJson(
            route('api.products.branches.index', $product)
        );

        $response->assertOk()->assertSee($branch->name);
    }

    /**
     * @test
     */
    public function it_can_attach_branches_to_product()
    {
        $product = Product::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->postJson(
            route('api.products.branches.store', [$product, $branch])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_branches_from_product()
    {
        $product = Product::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->deleteJson(
            route('api.products.branches.store', [$product, $branch])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }
}
