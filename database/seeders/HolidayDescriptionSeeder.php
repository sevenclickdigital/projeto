<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HolidayDescription;

class HolidayDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HolidayDescription::factory()
            ->count(5)
            ->create();
    }
}
