<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\Branch;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadBranchesTest extends TestCase
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
    public function it_gets_lead_branches()
    {
        $lead = Lead::factory()->create();
        $branch = Branch::factory()->create();

        $lead->branches()->attach($branch);

        $response = $this->getJson(route('api.leads.branches.index', $lead));

        $response->assertOk()->assertSee($branch->name);
    }

    /**
     * @test
     */
    public function it_can_attach_branches_to_lead()
    {
        $lead = Lead::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->postJson(
            route('api.leads.branches.store', [$lead, $branch])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $lead
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_branches_from_lead()
    {
        $lead = Lead::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->deleteJson(
            route('api.leads.branches.store', [$lead, $branch])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $lead
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }
}
