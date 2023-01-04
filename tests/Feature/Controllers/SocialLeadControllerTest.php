<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SocialLead;

use App\Models\Lead;
use App\Models\Tenant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SocialLeadControllerTest extends TestCase
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
    public function it_displays_index_view_with_social_leads()
    {
        $socialLeads = SocialLead::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('social-leads.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.social_leads.index')
            ->assertViewHas('socialLeads');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_social_lead()
    {
        $response = $this->get(route('social-leads.create'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.social_leads.create');
    }

    /**
     * @test
     */
    public function it_stores_the_social_lead()
    {
        $data = SocialLead::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('social-leads.store'), $data);

        unset($data['lead_id']);

        $this->assertDatabaseHas('social_leads', $data);

        $socialLead = SocialLead::latest('id')->first();

        $response->assertRedirect(route('social-leads.edit', $socialLead));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_social_lead()
    {
        $socialLead = SocialLead::factory()->create();

        $response = $this->get(route('social-leads.show', $socialLead));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.social_leads.show')
            ->assertViewHas('socialLead');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_social_lead()
    {
        $socialLead = SocialLead::factory()->create();

        $response = $this->get(route('social-leads.edit', $socialLead));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.social_leads.edit')
            ->assertViewHas('socialLead');
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

        $response = $this->put(
            route('social-leads.update', $socialLead),
            $data
        );

        unset($data['lead_id']);

        $data['id'] = $socialLead->id;

        $this->assertDatabaseHas('social_leads', $data);

        $response->assertRedirect(route('social-leads.edit', $socialLead));
    }

    /**
     * @test
     */
    public function it_deletes_the_social_lead()
    {
        $socialLead = SocialLead::factory()->create();

        $response = $this->delete(route('social-leads.destroy', $socialLead));

        $response->assertRedirect(route('social-leads.index'));

        $this->assertModelMissing($socialLead);
    }
}
