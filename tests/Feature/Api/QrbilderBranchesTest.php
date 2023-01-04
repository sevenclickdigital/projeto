<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\Qrbilder;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QrbilderBranchesTest extends TestCase
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
    public function it_gets_qrbilder_branches()
    {
        $qrbilder = Qrbilder::factory()->create();
        $branch = Branch::factory()->create();

        $qrbilder->branches()->attach($branch);

        $response = $this->getJson(
            route('api.qrbilders.branches.index', $qrbilder)
        );

        $response->assertOk()->assertSee($branch->name);
    }

    /**
     * @test
     */
    public function it_can_attach_branches_to_qrbilder()
    {
        $qrbilder = Qrbilder::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->postJson(
            route('api.qrbilders.branches.store', [$qrbilder, $branch])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $qrbilder
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_branches_from_qrbilder()
    {
        $qrbilder = Qrbilder::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->deleteJson(
            route('api.qrbilders.branches.store', [$qrbilder, $branch])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $qrbilder
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }
}
