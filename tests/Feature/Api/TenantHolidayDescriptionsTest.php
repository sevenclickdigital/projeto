<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\HolidayDescription;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantHolidayDescriptionsTest extends TestCase
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
    public function it_gets_tenant_holiday_descriptions()
    {
        $tenant = Tenant::factory()->create();
        $holidayDescriptions = HolidayDescription::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.holiday-descriptions.index', $tenant)
        );

        $response->assertOk()->assertSee($holidayDescriptions[0]->subject);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_holiday_descriptions()
    {
        $tenant = Tenant::factory()->create();
        $data = HolidayDescription::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.holiday-descriptions.store', $tenant),
            $data
        );

        $this->assertDatabaseHas('holiday_descriptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $holidayDescription = HolidayDescription::latest('id')->first();

        $this->assertEquals($tenant->id, $holidayDescription->tenant_id);
    }
}
