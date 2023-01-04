<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Qrbilder;

use App\Models\Tenant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QrbilderTest extends TestCase
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
    public function it_gets_qrbilders_list()
    {
        $qrbilders = Qrbilder::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.qrbilders.index'));

        $response->assertOk()->assertSee($qrbilders[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_qrbilder()
    {
        $data = Qrbilder::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.qrbilders.store'), $data);

        $this->assertDatabaseHas('qrbilders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.qrbilders.update', $qrbilder),
            $data
        );

        $data['id'] = $qrbilder->id;

        $this->assertDatabaseHas('qrbilders', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_qrbilder()
    {
        $qrbilder = Qrbilder::factory()->create();

        $response = $this->deleteJson(
            route('api.qrbilders.destroy', $qrbilder)
        );

        $this->assertModelMissing($qrbilder);

        $response->assertNoContent();
    }
}
