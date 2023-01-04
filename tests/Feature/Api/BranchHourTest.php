<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\BranchHour;

use App\Models\Tenant;
use App\Models\Branch;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchHourTest extends TestCase
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
    public function it_gets_branch_hours_list()
    {
        $branchHours = BranchHour::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.branch-hours.index'));

        $response->assertOk()->assertSee($branchHours[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_branch_hour()
    {
        $data = BranchHour::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.branch-hours.store'), $data);

        $this->assertDatabaseHas('branch_hours', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.branch-hours.update', $branchHour),
            $data
        );

        $data['id'] = $branchHour->id;

        $this->assertDatabaseHas('branch_hours', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_branch_hour()
    {
        $branchHour = BranchHour::factory()->create();

        $response = $this->deleteJson(
            route('api.branch-hours.destroy', $branchHour)
        );

        $this->assertModelMissing($branchHour);

        $response->assertNoContent();
    }
}
