<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Branch;

use App\Models\Tenant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_branches()
    {
        $branches = Branch::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('branches.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.branches.index')
            ->assertViewHas('branches');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_branch()
    {
        $response = $this->get(route('branches.create'));

        $response->assertOk()->assertViewIs('resources.views.branches.create');
    }

    /**
     * @test
     */
    public function it_stores_the_branch()
    {
        $data = Branch::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('branches.store'), $data);

        $this->assertDatabaseHas('branches', $data);

        $branch = Branch::latest('id')->first();

        $response->assertRedirect(route('branches.edit', $branch));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_branch()
    {
        $branch = Branch::factory()->create();

        $response = $this->get(route('branches.show', $branch));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.branches.show')
            ->assertViewHas('branch');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_branch()
    {
        $branch = Branch::factory()->create();

        $response = $this->get(route('branches.edit', $branch));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.branches.edit')
            ->assertViewHas('branch');
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

        $response = $this->put(route('branches.update', $branch), $data);

        $data['id'] = $branch->id;

        $this->assertDatabaseHas('branches', $data);

        $response->assertRedirect(route('branches.edit', $branch));
    }

    /**
     * @test
     */
    public function it_deletes_the_branch()
    {
        $branch = Branch::factory()->create();

        $response = $this->delete(route('branches.destroy', $branch));

        $response->assertRedirect(route('branches.index'));

        $this->assertModelMissing($branch);
    }
}
