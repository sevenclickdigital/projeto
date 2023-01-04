<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\SocialLead;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadSocialLeadsTest extends TestCase
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
    public function it_gets_lead_social_leads()
    {
        $lead = Lead::factory()->create();
        $socialLeads = SocialLead::factory()
            ->count(2)
            ->create([
                'lead_id' => $lead->id,
            ]);

        $response = $this->getJson(
            route('api.leads.social-leads.index', $lead)
        );

        $response->assertOk()->assertSee($socialLeads[0]->profile_photo_path);
    }

    /**
     * @test
     */
    public function it_stores_the_lead_social_leads()
    {
        $lead = Lead::factory()->create();
        $data = SocialLead::factory()
            ->make([
                'lead_id' => $lead->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.leads.social-leads.store', $lead),
            $data
        );

        unset($data['lead_id']);

        $this->assertDatabaseHas('social_leads', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $socialLead = SocialLead::latest('id')->first();

        $this->assertEquals($lead->id, $socialLead->lead_id);
    }
}
