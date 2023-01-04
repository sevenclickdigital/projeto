<?php

namespace Database\Seeders;

use App\Models\BranchHour;
use Illuminate\Database\Seeder;

class BranchHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BranchHour::factory()
            ->count(5)
            ->create();
    }
}
