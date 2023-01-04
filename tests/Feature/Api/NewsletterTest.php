<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Newsletter;

use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsletterTest extends TestCase
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
    public function it_gets_newsletters_list()
    {
        $newsletters = Newsletter::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.newsletters.index'));

        $response->assertOk()->assertSee($newsletters[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_newsletter()
    {
        $data = Newsletter::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.newsletters.store'), $data);

        $this->assertDatabaseHas('newsletters', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_newsletter()
    {
        $newsletter = Newsletter::factory()->create();

        $tenant = Tenant::factory()->create();

        $data = [
            'active' => $this->faker->boolean,
            'sent' => $this->faker->boolean,
            'date' => $this->faker->date,
            'time' => $this->faker->time,
            'subject' => $this->faker->text(255),
            'content' => $this->faker->text,
            'tenant_id' => $tenant->id,
        ];

        $response = $this->putJson(
            route('api.newsletters.update', $newsletter),
            $data
        );

        $data['id'] = $newsletter->id;

        $this->assertDatabaseHas('newsletters', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_newsletter()
    {
        $newsletter = Newsletter::factory()->create();

        $response = $this->deleteJson(
            route('api.newsletters.destroy', $newsletter)
        );

        $this->assertModelMissing($newsletter);

        $response->assertNoContent();
    }
}
