<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(BillingSeeder::class);
        $this->call(BirthdaySeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(BranchHourSeeder::class);
        $this->call(CategoryProductSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(HolidaySeeder::class);
        $this->call(HolidayDescriptionSeeder::class);
        $this->call(LeadSeeder::class);
        $this->call(MessageSeeder::class);
        $this->call(NewsletterSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(QrbilderSeeder::class);
        $this->call(RatingSeeder::class);
        $this->call(RatingGoogleBusinessSeeder::class);
        $this->call(ScratchCardSeeder::class);
        $this->call(ScratchCardAnswerSeeder::class);
        $this->call(ScratchCardConfigSeeder::class);
        $this->call(ScratchCardPlayerSeeder::class);
        $this->call(SocialLeadSeeder::class);
        $this->call(TenantSeeder::class);
        $this->call(UserSeeder::class);
    }
}
