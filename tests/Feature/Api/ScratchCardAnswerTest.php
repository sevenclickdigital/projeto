<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ScratchCardAnswer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScratchCardAnswerTest extends TestCase
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
    public function it_gets_scratch_card_answers_list()
    {
        $scratchCardAnswers = ScratchCardAnswer::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.scratch-card-answers.index'));

        $response->assertOk()->assertSee($scratchCardAnswers[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_scratch_card_answer()
    {
        $data = ScratchCardAnswer::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.scratch-card-answers.store'),
            $data
        );

        unset($data['name']);
        unset($data['description']);

        $this->assertDatabaseHas('scratch_card_answers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.scratch-card-answers.update', $scratchCardAnswer),
            $data
        );

        unset($data['name']);
        unset($data['description']);

        $data['id'] = $scratchCardAnswer->id;

        $this->assertDatabaseHas('scratch_card_answers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_scratch_card_answer()
    {
        $scratchCardAnswer = ScratchCardAnswer::factory()->create();

        $response = $this->deleteJson(
            route('api.scratch-card-answers.destroy', $scratchCardAnswer)
        );

        $this->assertModelMissing($scratchCardAnswer);

        $response->assertNoContent();
    }
}
