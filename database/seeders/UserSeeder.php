<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Support\CrmSeedData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        foreach (CrmSeedData::users() as $seedUser) {
            User::query()->updateOrCreate(
                ['email' => $seedUser['email']],
                [
                    'name' => $seedUser['name'],
                    'role' => $seedUser['role'],
                    'password' => 'password',
                    'email_verified_at' => now(),
                ],
            );
        }
    }
}
