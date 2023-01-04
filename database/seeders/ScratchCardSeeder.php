<?php

namespace Database\Seeders;

use App\Models\ScratchCard;
use Illuminate\Database\Seeder;

class ScratchCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScratchCard::factory()
            ->count(5)
            ->create();
    }
}
