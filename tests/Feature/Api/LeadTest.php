<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;

use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadTest extends TestCase
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
    public function it_gets_leads_list()
    {
        $leads = Lead::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.leads.index'));

        $response->assertOk()->assertSee($leads[0]->first_name);
    }

    /**
     * @test
     */
    public function it_stores_the_lead()
    {
        $data = Lead::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.leads.store'), $data);

        $this->assertDatabaseHas('leads', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_lead()
    {
        $lead = Lead::factory()->create();

        $tenant = Tenant::factory()->create();

        $data = [
            'active' => $this->faker->boolean,
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->lastName,
            'gender' => array_rand(array_flip(['male', 'female', 'other'])),
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'birthday' => $this->faker->date,
            'notify_news' => $this->faker->boolean,
            'notify_holiday' => $this->faker->boolean,
            'notify_birthday' => $this->faker->boolean,
            'notify_scratch_card' => $this->faker->boolean,
            'notify_coupon' => $this->faker->boolean,
            'tenant_id' => $tenant->id,
        ];

        $response = $this->putJson(route('api.leads.update', $lead), $data);

        $data['id'] = $lead->id;

        $this->assertDatabaseHas('leads', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_lead()
    {
        $lead = Lead::factory()->create();

        $response = $this->deleteJson(route('api.leads.destroy', $lead));

        $this->assertModelMissing($lead);

        $response->assertNoContent();
    }
}
