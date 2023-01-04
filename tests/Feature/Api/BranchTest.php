<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;

use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchTest extends TestCase
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
    public function it_gets_branches_list()
    {
        $branches = Branch::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.branches.index'));

        $response->assertOk()->assertSee($branches[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_branch()
    {
        $data = Branch::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.branches.store'), $data);

        $this->assertDatabaseHas('branches', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_branch()
    {
        $branch = Branch::factory()->create();

        $tenant = Tenant::factory()->create();

        $data = [
            'branch_logo_path' => $this->faker->text(255),
            'branch_cover_path' => $this->faker->text(255),
            'name' => $this->faker->name,
            'currency' => $this->faker->currencyCode,
            'description' => $this->faker->sentence(15),
            'slug' => $this->faker->slug,
            'phone' => $this->faker->phoneNumber,
            'cell' => $this->faker->text(255),
            'email' => $this->faker->email,
            'place_id' => $this->faker->randomNumber(0),
            'coordinates' => $this->faker->text(255),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->text(255),
            'country' => $this->faker->country,
            'tenant_id' => $tenant->id,
        ];

        $response = $this->putJson(
            route('api.branches.update', $branch),
            $data
        );

        $data['id'] = $branch->id;

        $this->assertDatabaseHas('branches', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_branch()
    {
        $branch = Branch::factory()->create();

        $response = $this->deleteJson(route('api.branches.destroy', $branch));

        $this->assertModelMissing($branch);

        $response->assertNoContent();
    }
}
