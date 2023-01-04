<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\BranchHour;

use App\Models\Tenant;
use App\Models\Branch;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchHourControllerTest extends TestCase
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
    public function it_displays_index_view_with_branch_hours()
    {
        $branchHours = BranchHour::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('branch-hours.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.branch_hours.index')
            ->assertViewHas('branchHours');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_branch_hour()
    {
        $response = $this->get(route('branch-hours.create'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.branch_hours.create');
    }

    /**
     * @test
     */
    public function it_stores_the_branch_hour()
    {
        $data = BranchHour::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('branch-hours.store'), $data);

        $this->assertDatabaseHas('branch_hours', $data);

        $branchHour = BranchHour::latest('id')->first();

        $response->assertRedirect(route('branch-hours.edit', $branchHour));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_branch_hour()
    {
        $branchHour = BranchHour::factory()->create();

        $response = $this->get(route('branch-hours.show', $branchHour));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.branch_hours.show')
            ->assertViewHas('branchHour');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_branch_hour()
    {
        $branchHour = BranchHour::factory()->create();

        $response = $this->get(route('branch-hours.edit', $branchHour));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.branch_hours.edit')
            ->assertViewHas('branchHour');
    }

    /**
     * @test
     */
    public function it_updates_the_branch_hour()
    {
        $branchHour = BranchHour::factory()->create();

        $tenant = Tenant::factory()->create();
        $branch = Branch::factory()->create();

        $data = [
            'day' => array_rand(
                array_flip([
                    'sunday',
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                ]),
                1
            ),
            'hour_start' => $this->faker->time,
            'hour_end' => $this->faker->time,
            'tenant_id' => $tenant->id,
            'branch_id' => $branch->id,
        ];

        $response = $this->put(
            route('branch-hours.update', $branchHour),
            $data
        );

        $data['id'] = $branchHour->id;

        $this->assertDatabaseHas('branch_hours', $data);

        $response->assertRedirect(route('branch-hours.edit', $branchHour));
    }

    /**
     * @test
     */
    public function it_deletes_the_branch_hour()
    {
        $branchHour = BranchHour::factory()->create();

        $response = $this->delete(route('branch-hours.destroy', $branchHour));

        $response->assertRedirect(route('branch-hours.index'));

        $this->assertModelMissing($branchHour);
    }
}
