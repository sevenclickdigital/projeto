<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Holiday;

use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HolidayTest extends TestCase
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
    public function it_gets_holidays_list()
    {
        $holidays = Holiday::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.holidays.index'));

        $response->assertOk()->assertSee($holidays[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_holiday()
    {
        $data = Holiday::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.holidays.store'), $data);

        $this->assertDatabaseHas('holidays', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.holidays.update', $holiday),
            $data
        );

        $data['id'] = $holiday->id;

        $this->assertDatabaseHas('holidays', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_holiday()
    {
        $holiday = Holiday::factory()->create();

        $response = $this->deleteJson(route('api.holidays.destroy', $holiday));

        $this->assertModelMissing($holiday);

        $response->assertNoContent();
    }
}
