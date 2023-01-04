<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Holiday;
use App\Models\HolidayDescription;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HolidayHolidayDescriptionsTest extends TestCase
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
    public function it_gets_holiday_holiday_descriptions()
    {
        $holiday = Holiday::factory()->create();
        $holidayDescriptions = HolidayDescription::factory()
            ->count(2)
            ->create([
                'holiday_id' => $holiday->id,
            ]);

        $response = $this->getJson(
            route('api.holidays.holiday-descriptions.index', $holiday)
        );

        $response->assertOk()->assertSee($holidayDescriptions[0]->subject);
    }

    /**
     * @test
     */
    public function it_stores_the_holiday_holiday_descriptions()
    {
        $holiday = Holiday::factory()->create();
        $data = HolidayDescription::factory()
            ->make([
                'holiday_id' => $holiday->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.holidays.holiday-descriptions.store', $holiday),
            $data
        );

        $this->assertDatabaseHas('holiday_descriptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $holidayDescription = HolidayDescription::latest('id')->first();

        $this->assertEquals($holiday->id, $holidayDescription->holiday_id);
    }
}
