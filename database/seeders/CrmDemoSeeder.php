<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CrmDemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CompanySeeder::class,
            ContactSeeder::class,
            OpportunitySeeder::class,
            QuoteSeeder::class,
            TaskSeeder::class,
            TicketSeeder::class,
            ActivityLogSeeder::class,
        ]);
    }
}
