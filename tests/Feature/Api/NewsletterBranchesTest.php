<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\Newsletter;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsletterBranchesTest extends TestCase
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
    public function it_gets_newsletter_branches()
    {
        $newsletter = Newsletter::factory()->create();
        $branch = Branch::factory()->create();

        $newsletter->branches()->attach($branch);

        $response = $this->getJson(
            route('api.newsletters.branches.index', $newsletter)
        );

        $response->assertOk()->assertSee($branch->name);
    }

    /**
     * @test
     */
    public function it_can_attach_branches_to_newsletter()
    {
        $newsletter = Newsletter::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->postJson(
            route('api.newsletters.branches.store', [$newsletter, $branch])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $newsletter
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_branches_from_newsletter()
    {
        $newsletter = Newsletter::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->deleteJson(
            route('api.newsletters.branches.store', [$newsletter, $branch])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $newsletter
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }
}
