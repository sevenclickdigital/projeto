<?php

namespace Database\Seeders;

use App\Models\SocialLead;
use Illuminate\Database\Seeder;

class SocialLeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SocialLead::factory()
            ->count(5)
            ->create();
    }
}
