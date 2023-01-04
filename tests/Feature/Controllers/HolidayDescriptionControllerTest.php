<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\HolidayDescription;

use App\Models\Tenant;
use App\Models\Holiday;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HolidayDescriptionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_holiday_descriptions()
    {
        $holidayDescriptions = HolidayDescription::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('holiday-descriptions.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.holiday_descriptions.index')
            ->assertViewHas('holidayDescriptions');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_holiday_description()
    {
        $response = $this->get(route('holiday-descriptions.create'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.holiday_descriptions.create');
    }

    /**
     * @test
     */
    public function it_stores_the_holiday_description()
    {
        $data = HolidayDescription::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('holiday-descriptions.store'), $data);

        $this->assertDatabaseHas('holiday_descriptions', $data);

        $holidayDescription = HolidayDescription::latest('id')->first();

        $response->assertRedirect(
            route('holiday-descriptions.edit', $holidayDescription)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_holiday_description()
    {
        $holidayDescription = HolidayDescription::factory()->create();

        $response = $this->get(
            route('holiday-descriptions.show', $holidayDescription)
        );

        $response
            ->assertOk()
            ->assertViewIs('resources.views.holiday_descriptions.show')
            ->assertViewHas('holidayDescription');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_holiday_description()
    {
        $holidayDescription = HolidayDescription::factory()->create();

        $response = $this->get(
            route('holiday-descriptions.edit', $holidayDescription)
        );

        $response
            ->assertOk()
            ->assertViewIs('resources.views.holiday_descriptions.edit')
            ->assertViewHas('holidayDescription');
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

        $response = $this->put(
            route('holiday-descriptions.update', $holidayDescription),
            $data
        );

        $data['id'] = $holidayDescription->id;

        $this->assertDatabaseHas('holiday_descriptions', $data);

        $response->assertRedirect(
            route('holiday-descriptions.edit', $holidayDescription)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_holiday_description()
    {
        $holidayDescription = HolidayDescription::factory()->create();

        $response = $this->delete(
            route('holiday-descriptions.destroy', $holidayDescription)
        );

        $response->assertRedirect(route('holiday-descriptions.index'));

        $this->assertModelMissing($holidayDescription);
    }
}
