<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RatingGoogleBusiness;

class RatingGoogleBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RatingGoogleBusiness::factory()
            ->count(5)
            ->create();
    }
}
