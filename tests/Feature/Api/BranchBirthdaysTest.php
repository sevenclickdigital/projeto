<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\Birthday;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchBirthdaysTest extends TestCase
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
    public function it_gets_branch_birthdays()
    {
        $branch = Branch::factory()->create();
        $birthday = Birthday::factory()->create();

        $branch->birthdays()->attach($birthday);

        $response = $this->getJson(
            route('api.branches.birthdays.index', $branch)
        );

        $response->assertOk()->assertSee($birthday->subject);
    }

    /**
     * @test
     */
    public function it_can_attach_birthdays_to_branch()
    {
        $branch = Branch::factory()->create();
        $birthday = Birthday::factory()->create();

        $response = $this->postJson(
            route('api.branches.birthdays.store', [$branch, $birthday])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $branch
                ->birthdays()
                ->where('birthdays.id', $birthday->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_birthdays_from_branch()
    {
        $branch = Branch::factory()->create();
        $birthday = Birthday::factory()->create();

        $response = $this->deleteJson(
            route('api.branches.birthdays.store', [$branch, $birthday])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $branch
                ->birthdays()
                ->where('birthdays.id', $birthday->id)
                ->exists()
        );
    }
}
