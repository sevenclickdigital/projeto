<?php

namespace Database\Seeders;

use App\Models\Qrbilder;
use Illuminate\Database\Seeder;

class QrbilderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Qrbilder::factory()
            ->count(5)
            ->create();
    }
}
