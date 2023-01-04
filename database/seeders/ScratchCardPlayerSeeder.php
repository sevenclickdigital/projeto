<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ScratchCardPlayer;

class ScratchCardPlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScratchCardPlayer::factory()
            ->count(5)
            ->create();
    }
}
