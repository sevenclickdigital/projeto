<?php

namespace Database\Seeders;

use App\Models\Birthday;
use Illuminate\Database\Seeder;

class BirthdaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Birthday::factory()
            ->count(5)
            ->create();
    }
}
