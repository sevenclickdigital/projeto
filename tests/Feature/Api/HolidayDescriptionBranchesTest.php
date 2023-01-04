<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\HolidayDescription;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HolidayDescriptionBranchesTest extends TestCase
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
    public function it_gets_holiday_description_branches()
    {
        $holidayDescription = HolidayDescription::factory()->create();
        $branch = Branch::factory()->create();

        $holidayDescription->branches()->attach($branch);

        $response = $this->getJson(
            route(
                'api.holiday-descriptions.branches.index',
                $holidayDescription
            )
        );

        $response->assertOk()->assertSee($branch->name);
    }

    /**
     * @test
     */
    public function it_can_attach_branches_to_holiday_description()
    {
        $holidayDescription = HolidayDescription::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->postJson(
            route('api.holiday-descriptions.branches.store', [
                $holidayDescription,
                $branch,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $holidayDescription
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_branches_from_holiday_description()
    {
        $holidayDescription = HolidayDescription::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->deleteJson(
            route('api.holiday-descriptions.branches.store', [
                $holidayDescription,
                $branch,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $holidayDescription
                ->branches()
                ->where('branches.id', $branch->id)
                ->exists()
        );
    }
}
