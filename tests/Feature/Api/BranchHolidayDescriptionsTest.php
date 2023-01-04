<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Branch;
use App\Models\HolidayDescription;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchHolidayDescriptionsTest extends TestCase
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
    public function it_gets_branch_holiday_descriptions()
    {
        $branch = Branch::factory()->create();
        $holidayDescription = HolidayDescription::factory()->create();

        $branch->holidayDescriptions()->attach($holidayDescription);

        $response = $this->getJson(
            route('api.branches.holiday-descriptions.index', $branch)
        );

        $response->assertOk()->assertSee($holidayDescription->subject);
    }

    /**
     * @test
     */
    public function it_can_attach_holiday_descriptions_to_branch()
    {
        $branch = Branch::factory()->create();
        $holidayDescription = HolidayDescription::factory()->create();

        $response = $this->postJson(
            route('api.branches.holiday-descriptions.store', [
                $branch,
                $holidayDescription,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $branch
                ->holidayDescriptions()
                ->where('holiday_descriptions.id', $holidayDescription->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_holiday_descriptions_from_branch()
    {
        $branch = Branch::factory()->create();
        $holidayDescription = HolidayDescription::factory()->create();

        $response = $this->deleteJson(
            route('api.branches.holiday-descriptions.store', [
                $branch,
                $holidayDescription,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $branch
                ->holidayDescriptions()
                ->where('holiday_descriptions.id', $holidayDescription->id)
                ->exists()
        );
    }
}
