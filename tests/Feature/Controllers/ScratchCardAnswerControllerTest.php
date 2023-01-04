<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ScratchCardAnswer;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScratchCardAnswerControllerTest extends TestCase
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
    public function it_displays_index_view_with_scratch_card_answers()
    {
        $scratchCardAnswers = ScratchCardAnswer::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('scratch-card-answers.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_card_answers.index')
            ->assertViewHas('scratchCardAnswers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_scratch_card_answer()
    {
        $response = $this->get(route('scratch-card-answers.create'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_card_answers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_scratch_card_answer()
    {
        $data = ScratchCardAnswer::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('scratch-card-answers.store'), $data);

        unset($data['name']);
        unset($data['description']);

        $this->assertDatabaseHas('scratch_card_answers', $data);

        $scratchCardAnswer = ScratchCardAnswer::latest('id')->first();

        $response->assertRedirect(
            route('scratch-card-answers.edit', $scratchCardAnswer)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_scratch_card_answer()
    {
        $scratchCardAnswer = ScratchCardAnswer::factory()->create();

        $response = $this->get(
            route('scratch-card-answers.show', $scratchCardAnswer)
        );

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_card_answers.show')
            ->assertViewHas('scratchCardAnswer');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_scratch_card_answer()
    {
        $scratchCardAnswer = ScratchCardAnswer::factory()->create();

        $response = $this->get(
            route('scratch-card-answers.edit', $scratchCardAnswer)
        );

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_card_answers.edit')
            ->assertViewHas('scratchCardAnswer');
    }

    /**
     * @test
     */
    public function it_updates_the_scratch_card_answer()
    {
        $scratchCardAnswer = ScratchCardAnswer::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'sending_order' => $this->faker->randomNumber(0),
            'type' => 'true',
            'template_type' => 'true',
            'elements_title' => $this->faker->sentence(10),
            'elements_subtitle' => $this->faker->text(255),
            'action_type' => $this->faker->text(255),
            'action_url' => $this->faker->url,
            'action_messenger_extensions' => 'true',
            'action_webview_height_ratio' => 'compact',
            'buttons_type' => $this->faker->text(255),
            'buttons_url' => $this->faker->text(255),
            'buttons_title' => $this->faker->text(255),
        ];

        $response = $this->put(
            route('scratch-card-answers.update', $scratchCardAnswer),
            $data
        );

        unset($data['name']);
        unset($data['description']);

        $data['id'] = $scratchCardAnswer->id;

        $this->assertDatabaseHas('scratch_card_answers', $data);

        $response->assertRedirect(
            route('scratch-card-answers.edit', $scratchCardAnswer)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_scratch_card_answer()
    {
        $scratchCardAnswer = ScratchCardAnswer::factory()->create();

        $response = $this->delete(
            route('scratch-card-answers.destroy', $scratchCardAnswer)
        );

        $response->assertRedirect(route('scratch-card-answers.index'));

        $this->assertModelMissing($scratchCardAnswer);
    }
}
