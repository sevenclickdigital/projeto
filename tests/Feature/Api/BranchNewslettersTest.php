<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\Newsletter;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchNewslettersTest extends TestCase
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
    public function it_gets_branch_newsletters()
    {
        $branch = Branch::factory()->create();
        $newsletter = Newsletter::factory()->create();

        $branch->newsletters()->attach($newsletter);

        $response = $this->getJson(
            route('api.branches.newsletters.index', $branch)
        );

        $response->assertOk()->assertSee($newsletter->date);
    }

    /**
     * @test
     */
    public function it_can_attach_newsletters_to_branch()
    {
        $branch = Branch::factory()->create();
        $newsletter = Newsletter::factory()->create();

        $response = $this->postJson(
            route('api.branches.newsletters.store', [$branch, $newsletter])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $branch
                ->newsletters()
                ->where('newsletters.id', $newsletter->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_newsletters_from_branch()
    {
        $branch = Branch::factory()->create();
        $newsletter = Newsletter::factory()->create();

        $response = $this->deleteJson(
            route('api.branches.newsletters.store', [$branch, $newsletter])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $branch
                ->newsletters()
                ->where('newsletters.id', $newsletter->id)
                ->exists()
        );
    }
}
