<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Message;

use App\Models\Tenant;
use App\Models\SocialLead;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageControllerTest extends TestCase
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
    public function it_displays_index_view_with_messages()
    {
        $messages = Message::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('messages.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.messages.index')
            ->assertViewHas('messages');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_message()
    {
        $response = $this->get(route('messages.create'));

        $response->assertOk()->assertViewIs('resources.views.messages.create');
    }

    /**
     * @test
     */
    public function it_stores_the_message()
    {
        $data = Message::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('messages.store'), $data);

        unset($data['social_lead_id']);

        $this->assertDatabaseHas('messages', $data);

        $message = Message::latest('id')->first();

        $response->assertRedirect(route('messages.edit', $message));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_message()
    {
        $message = Message::factory()->create();

        $response = $this->get(route('messages.show', $message));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.messages.show')
            ->assertViewHas('message');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_message()
    {
        $message = Message::factory()->create();

        $response = $this->get(route('messages.edit', $message));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.messages.edit')
            ->assertViewHas('message');
    }

    /**
     * @test
     */
    public function it_updates_the_message()
    {
        $message = Message::factory()->create();

        $tenant = Tenant::factory()->create();
        $socialLead = SocialLead::factory()->create();

        $data = [
            'text' => $this->faker->text,
            'read' => $this->faker->boolean,
            'message_key' => $this->faker->text,
            'sender' => array_rand(array_flip(['user', 'company'])),
            'sender_id' => $this->faker->uuid,
            'receiver_id' => $this->faker->uuid,
            'tenant_id' => $tenant->id,
            'social_lead_id' => $socialLead->id,
        ];

        $response = $this->put(route('messages.update', $message), $data);

        unset($data['social_lead_id']);

        $data['id'] = $message->id;

        $this->assertDatabaseHas('messages', $data);

        $response->assertRedirect(route('messages.edit', $message));
    }

    /**
     * @test
     */
    public function it_deletes_the_message()
    {
        $message = Message::factory()->create();

        $response = $this->delete(route('messages.destroy', $message));

        $response->assertRedirect(route('messages.index'));

        $this->assertModelMissing($message);
    }
}
