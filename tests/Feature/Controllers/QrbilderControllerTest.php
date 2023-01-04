<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Qrbilder;

use App\Models\Tenant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QrbilderControllerTest extends TestCase
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
    public function it_displays_index_view_with_qrbilders()
    {
        $qrbilders = Qrbilder::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('qrbilders.index'));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.qrbilders.index')
            ->assertViewHas('qrbilders');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_qrbilder()
    {
        $response = $this->get(route('qrbilders.create'));

        $response->assertOk()->assertViewIs('resources.views.qrbilders.create');
    }

    /**
     * @test
     */
    public function it_stores_the_qrbilder()
    {
        $data = Qrbilder::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('qrbilders.store'), $data);

        $this->assertDatabaseHas('qrbilders', $data);

        $qrbilder = Qrbilder::latest('id')->first();

        $response->assertRedirect(route('qrbilders.edit', $qrbilder));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_qrbilder()
    {
        $qrbilder = Qrbilder::factory()->create();

        $response = $this->get(route('qrbilders.show', $qrbilder));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.qrbilders.show')
            ->assertViewHas('qrbilder');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_qrbilder()
    {
        $qrbilder = Qrbilder::factory()->create();

        $response = $this->get(route('qrbilders.edit', $qrbilder));

        $response
            ->assertOk()
            ->assertViewIs('resources.views.qrbilders.edit')
            ->assertViewHas('qrbilder');
    }

    /**
     * @test
     */
    public function it_updates_the_qrbilder()
    {
        $qrbilder = Qrbilder::factory()->create();

        $tenant = Tenant::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug,
            'bilder_photo_path' => $this->faker->text,
            'tenant_id' => $tenant->id,
        ];

        $response = $this->put(route('qrbilders.update', $qrbilder), $data);

        $data['id'] = $qrbilder->id;

        $this->assertDatabaseHas('qrbilders', $data);

        $response->assertRedirect(route('qrbilders.edit', $qrbilder));
    }

    /**
     * @test
     */
    public function it_deletes_the_qrbilder()
    {
        $qrbilder = Qrbilder::factory()->create();

        $response = $this->delete(route('qrbilders.destroy', $qrbilder));

        $response->assertRedirect(route('qrbilders.index'));

        $this->assertModelMissing($qrbilder);
    }
}
