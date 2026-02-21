<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Database\Seeders\Support\CrmSeedData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $usersByEmail = User::query()->get()->keyBy('email');

        foreach (CrmSeedData::companies() as $seedCompany) {
            $owner = $usersByEmail->get($seedCompany['created_by']) ?? $usersByEmail->first();

            if (! $owner) {
                continue;
            }

            Company::query()->updateOrCreate(
                ['name' => $seedCompany['name']],
                [
                    'created_by' => $owner->id,
                    'industry' => $seedCompany['industry'],
                    'phone' => $seedCompany['phone'],
                    'email' => $seedCompany['email'],
                    'website' => $seedCompany['website'],
                    'address' => $seedCompany['address'],
                    'notes' => $seedCompany['notes'],
                ],
            );
        }
    }
}
