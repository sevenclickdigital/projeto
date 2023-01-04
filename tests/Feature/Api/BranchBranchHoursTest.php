<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\BranchHour;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchBranchHoursTest extends TestCase
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
    public function it_gets_branch_branch_hours()
    {
        $branch = Branch::factory()->create();
        $branchHours = BranchHour::factory()
            ->count(2)
            ->create([
                'branch_id' => $branch->id,
            ]);

        $response = $this->getJson(
            route('api.branches.branch-hours.index', $branch)
        );

        $response->assertOk()->assertSee($branchHours[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_branch_branch_hours()
    {
        $branch = Branch::factory()->create();
        $data = BranchHour::factory()
            ->make([
                'branch_id' => $branch->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.branches.branch-hours.store', $branch),
            $data
        );

        $this->assertDatabaseHas('branch_hours', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $branchHour = BranchHour::latest('id')->first();

        $this->assertEquals($branch->id, $branchHour->branch_id);
    }
}
