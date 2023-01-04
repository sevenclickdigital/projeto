<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\Qrbilder;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchQrbildersTest extends TestCase
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
    public function it_gets_branch_qrbilders()
    {
        $branch = Branch::factory()->create();
        $qrbilder = Qrbilder::factory()->create();

        $branch->qrbilders()->attach($qrbilder);

        $response = $this->getJson(
            route('api.branches.qrbilders.index', $branch)
        );

        $response->assertOk()->assertSee($qrbilder->name);
    }

    /**
     * @test
     */
    public function it_can_attach_qrbilders_to_branch()
    {
        $branch = Branch::factory()->create();
        $qrbilder = Qrbilder::factory()->create();

        $response = $this->postJson(
            route('api.branches.qrbilders.store', [$branch, $qrbilder])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $branch
                ->qrbilders()
                ->where('qrbilders.id', $qrbilder->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_qrbilders_from_branch()
    {
        $branch = Branch::factory()->create();
        $qrbilder = Qrbilder::factory()->create();

        $response = $this->deleteJson(
            route('api.branches.qrbilders.store', [$branch, $qrbilder])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $branch
                ->qrbilders()
                ->where('qrbilders.id', $qrbilder->id)
                ->exists()
        );
    }
}
