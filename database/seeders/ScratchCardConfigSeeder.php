<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ScratchCardConfig;

class ScratchCardConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScratchCardConfig::factory()
            ->count(5)
            ->create();
    }
}
