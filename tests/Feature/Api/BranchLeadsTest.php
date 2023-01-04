<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\Branch;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchLeadsTest extends TestCase
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
    public function it_gets_branch_leads()
    {
        $branch = Branch::factory()->create();
        $lead = Lead::factory()->create();

        $branch->leads()->attach($lead);

        $response = $this->getJson(route('api.branches.leads.index', $branch));

        $response->assertOk()->assertSee($lead->first_name);
    }

    /**
     * @test
     */
    public function it_can_attach_leads_to_branch()
    {
        $branch = Branch::factory()->create();
        $lead = Lead::factory()->create();

        $response = $this->postJson(
            route('api.branches.leads.store', [$branch, $lead])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $branch
                ->leads()
                ->where('leads.id', $lead->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_leads_from_branch()
    {
        $branch = Branch::factory()->create();
        $lead = Lead::factory()->create();

        $response = $this->deleteJson(
            route('api.branches.leads.store', [$branch, $lead])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $branch
                ->leads()
                ->where('leads.id', $lead->id)
                ->exists()
        );
    }
}
