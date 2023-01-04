<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ScratchCard;

use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScratchCardTest extends TestCase
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
    public function it_gets_scratch_cards_list()
    {
        $scratchCards = ScratchCard::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.scratch-cards.index'));

        $response->assertOk()->assertSee($scratchCards[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_scratch_card()
    {
        $data = ScratchCard::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.scratch-cards.store'), $data);

        $this->assertDatabaseHas('scratch_cards', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_scratch_card()
    {
        $scratchCard = ScratchCard::factory()->create();

        $tenant = Tenant::factory()->create();

        $data = [
            'published' => array_rand(
                array_flip(['published', 'draft', 'archived']),
                1
            ),
            'award_photo_path' => $this->faker->text,
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'Keyword' => $this->faker->text(255),
            'chances_of_winning' => $this->faker->randomNumber(0),
            ' play_number' => $this->faker->randomNumber(0),
            'show_day' => $this->faker->text(255),
            'prize_availability' => array_rand(
                array_flip(['always', 'date']),
                1
            ),
            'prize_date_end' => $this->faker->date,
            'tenant_id' => $tenant->id,
        ];

        $response = $this->putJson(
            route('api.scratch-cards.update', $scratchCard),
            $data
        );

        $data['id'] = $scratchCard->id;

        $this->assertDatabaseHas('scratch_cards', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_scratch_card()
    {
        $scratchCard = ScratchCard::factory()->create();

        $response = $this->deleteJson(
            route('api.scratch-cards.destroy', $scratchCard)
        );

        $this->assertModelMissing($scratchCard);

        $response->assertNoContent();
    }
}
