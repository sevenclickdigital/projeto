<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Tenant;
use App\Models\SocialLead;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantSocialLeadsTest extends TestCase
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
    public function it_gets_tenant_social_leads()
    {
        $tenant = Tenant::factory()->create();
        $socialLeads = SocialLead::factory()
            ->count(2)
            ->create([
                'tenant_id' => $tenant->id,
            ]);

        $response = $this->getJson(
            route('api.tenants.social-leads.index', $tenant)
        );

        $response->assertOk()->assertSee($socialLeads[0]->profile_photo_path);
    }

    /**
     * @test
     */
    public function it_stores_the_tenant_social_leads()
    {
        $tenant = Tenant::factory()->create();
        $data = SocialLead::factory()
            ->make([
                'tenant_id' => $tenant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tenants.social-leads.store', $tenant),
            $data
        );

        unset($data['lead_id']);

        $this->assertDatabaseHas('social_leads', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $socialLead = SocialLead::latest('id')->first();

        $this->assertEquals($tenant->id, $socialLead->tenant_id);
    }
}
