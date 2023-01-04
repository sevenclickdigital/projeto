<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\HolidayDescription;

use App\Models\Tenant;
use App\Models\Holiday;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HolidayDescriptionTest extends TestCase
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
    public function it_gets_holiday_descriptions_list()
    {
        $holidayDescriptions = HolidayDescription::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.holiday-descriptions.index'));

        $response->assertOk()->assertSee($holidayDescriptions[0]->subject);
    }

    /**
     * @test
     */
    public function it_stores_the_holiday_description()
    {
        $data = HolidayDescription::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.holiday-descriptions.store'),
            $data
        );

        $this->assertDatabaseHas('holiday_descriptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_holiday_description()
    {
        $holidayDescription = HolidayDescription::factory()->create();

        $tenant = Tenant::factory()->create();
        $holiday = Holiday::factory()->create();

        $data = [
            'active' => $this->faker->boolean,
            'when_send' => array_rand(
                array_flip([
                    'one_day',
                    'two_days',
                    'three_days',
                    'four_days',
                    'five_days',
                    'one_week',
                    'two_weeks',
                    'one_month',
                    'in_day',
                ]),
                1
            ),
            'time' => $this->faker->time,
            'subject' => $this->faker->text(255),
            'content' => $this->faker->text,
            'tenant_id' => $tenant->id,
            'holiday_id' => $holiday->id,
        ];

        $response = $this->putJson(
            route('api.holiday-descriptions.update', $holidayDescription),
            $data
        );

        $data['id'] = $holidayDescription->id;

        $this->assertDatabaseHas('holiday_descriptions', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_holiday_description()
    {
        $holidayDescription = HolidayDescription::factory()->create();

        $response = $this->deleteJson(
            route('api.holiday-descriptions.destroy', $holidayDescription)
        );

        $this->assertModelMissing($holidayDescription);

        $response->assertNoContent();
    }
}
