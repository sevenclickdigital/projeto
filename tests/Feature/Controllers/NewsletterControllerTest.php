<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Newsletter;

use App\Models\Tenant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsletterControllerTest extends TestCase
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
    public function it_displays_index_view_with_newsletters()
    {
        $newsletters = Newsletter::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('newsletters.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.newsletters.index')
            ->assertViewHas('newsletters');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_newsletter()
    {
        $response = $this->get(route('newsletters.create'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.newsletters.create');
    }

    /**
     * @test
     */
    public function it_stores_the_newsletter()
    {
        $data = Newsletter::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('newsletters.store'), $data);

        $this->assertDatabaseHas('newsletters', $data);

        $newsletter = Newsletter::latest('id')->first();

        $response->assertRedirect(route('newsletters.edit', $newsletter));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_newsletter()
    {
        $newsletter = Newsletter::factory()->create();

        $response = $this->get(route('newsletters.show', $newsletter));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.newsletters.show')
            ->assertViewHas('newsletter');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_newsletter()
    {
        $newsletter = Newsletter::factory()->create();

        $response = $this->get(route('newsletters.edit', $newsletter));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.newsletters.edit')
            ->assertViewHas('newsletter');
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

        $response = $this->put(route('newsletters.update', $newsletter), $data);

        $data['id'] = $newsletter->id;

        $this->assertDatabaseHas('newsletters', $data);

        $response->assertRedirect(route('newsletters.edit', $newsletter));
    }

    /**
     * @test
     */
    public function it_deletes_the_newsletter()
    {
        $newsletter = Newsletter::factory()->create();

        $response = $this->delete(route('newsletters.destroy', $newsletter));

        $response->assertRedirect(route('newsletters.index'));

        $this->assertModelMissing($newsletter);
    }
}
