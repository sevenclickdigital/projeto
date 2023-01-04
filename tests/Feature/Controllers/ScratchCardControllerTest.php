<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ScratchCard;

use App\Models\Tenant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScratchCardControllerTest extends TestCase
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
    public function it_displays_index_view_with_scratch_cards()
    {
        $scratchCards = ScratchCard::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('scratch-cards.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_cards.index')
            ->assertViewHas('scratchCards');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_scratch_card()
    {
        $response = $this->get(route('scratch-cards.create'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_cards.create');
    }

    /**
     * @test
     */
    public function it_stores_the_scratch_card()
    {
        $data = ScratchCard::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('scratch-cards.store'), $data);

        $this->assertDatabaseHas('scratch_cards', $data);

        $scratchCard = ScratchCard::latest('id')->first();

        $response->assertRedirect(route('scratch-cards.edit', $scratchCard));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_scratch_card()
    {
        $scratchCard = ScratchCard::factory()->create();

        $response = $this->get(route('scratch-cards.show', $scratchCard));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_cards.show')
            ->assertViewHas('scratchCard');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_scratch_card()
    {
        $scratchCard = ScratchCard::factory()->create();

        $response = $this->get(route('scratch-cards.edit', $scratchCard));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.scratch_cards.edit')
            ->assertViewHas('scratchCard');
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

        $response = $this->put(
            route('scratch-cards.update', $scratchCard),
            $data
        );

        $data['id'] = $scratchCard->id;

        $this->assertDatabaseHas('scratch_cards', $data);

        $response->assertRedirect(route('scratch-cards.edit', $scratchCard));
    }

    /**
     * @test
     */
    public function it_deletes_the_scratch_card()
    {
        $scratchCard = ScratchCard::factory()->create();

        $response = $this->delete(route('scratch-cards.destroy', $scratchCard));

        $response->assertRedirect(route('scratch-cards.index'));

        $this->assertModelMissing($scratchCard);
    }
}
