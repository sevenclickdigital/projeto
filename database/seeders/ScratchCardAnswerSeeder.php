<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ScratchCardAnswer;

class ScratchCardAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScratchCardAnswer::factory()
            ->count(5)
            ->create();
    }
}
