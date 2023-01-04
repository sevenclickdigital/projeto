<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Holiday;

use App\Models\Tenant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HolidayControllerTest extends TestCase
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
    public function it_displays_index_view_with_holidays()
    {
        $holidays = Holiday::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('holidays.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.holidays.index')
            ->assertViewHas('holidays');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_holiday()
    {
        $response = $this->get(route('holidays.create'));

        $response->assertOk()->assertViewIs('resources.views.holidays.create');
    }

    /**
     * @test
     */
    public function it_stores_the_holiday()
    {
        $data = Holiday::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('holidays.store'), $data);

        $this->assertDatabaseHas('holidays', $data);

        $holiday = Holiday::latest('id')->first();

        $response->assertRedirect(route('holidays.edit', $holiday));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_holiday()
    {
        $holiday = Holiday::factory()->create();

        $response = $this->get(route('holidays.show', $holiday));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.holidays.show')
            ->assertViewHas('holiday');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_holiday()
    {
        $holiday = Holiday::factory()->create();

        $response = $this->get(route('holidays.edit', $holiday));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.holidays.edit')
            ->assertViewHas('holiday');
    }

    /**
     * @test
     */
    public function it_updates_the_holiday()
    {
        $holiday = Holiday::factory()->create();

        $tenant = Tenant::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'date' => $this->faker->date,
            'active' => $this->faker->boolean,
            'custom' => $this->faker->boolean,
            'tenant_id' => $tenant->id,
        ];

        $response = $this->put(route('holidays.update', $holiday), $data);

        $data['id'] = $holiday->id;

        $this->assertDatabaseHas('holidays', $data);

        $response->assertRedirect(route('holidays.edit', $holiday));
    }

    /**
     * @test
     */
    public function it_deletes_the_holiday()
    {
        $holiday = Holiday::factory()->create();

        $response = $this->delete(route('holidays.destroy', $holiday));

        $response->assertRedirect(route('holidays.index'));

        $this->assertModelMissing($holiday);
    }
}
