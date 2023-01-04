<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SocialLead;

use App\Models\Lead;
use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SocialLeadTest extends TestCase
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
    public function it_gets_social_leads_list()
    {
        $socialLeads = SocialLead::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.social-leads.index'));

        $response->assertOk()->assertSee($socialLeads[0]->profile_photo_path);
    }

    /**
     * @test
     */
    public function it_stores_the_social_lead()
    {
        $data = SocialLead::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.social-leads.store'), $data);

        unset($data['lead_id']);

        $this->assertDatabaseHas('social_leads', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_social_lead()
    {
        $socialLead = SocialLead::factory()->create();

        $tenant = Tenant::factory()->create();
        $lead = Lead::factory()->create();

        $data = [
            'active' => $this->faker->boolean,
            'profile_photo_path' => $this->faker->text,
            'social_id' => $this->faker->text,
            'social_key' => $this->faker->text,
            'social_type' => array_rand(
                array_flip(['instagram', 'facebook', 'whatsapp']),
                1
            ),
            'tenant_id' => $tenant->id,
            'lead_id' => $lead->id,
        ];

        $response = $this->putJson(
            route('api.social-leads.update', $socialLead),
            $data
        );

        unset($data['lead_id']);

        $data['id'] = $socialLead->id;

        $this->assertDatabaseHas('social_leads', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_social_lead()
    {
        $socialLead = SocialLead::factory()->create();

        $response = $this->deleteJson(
            route('api.social-leads.destroy', $socialLead)
        );

        $this->assertModelMissing($socialLead);

        $response->assertNoContent();
    }
}
