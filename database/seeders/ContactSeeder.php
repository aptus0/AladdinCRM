<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use Database\Seeders\Support\CrmSeedData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $usersByEmail = User::query()->get()->keyBy('email');

        foreach (CrmSeedData::contactsByCompany() as $companyName => $contacts) {
            $company = Company::query()->where('name', $companyName)->first();

            if (! $company) {
                continue;
            }

            foreach ($contacts as $seedContact) {
                $owner = $usersByEmail->get($seedContact['created_by']) ?? $usersByEmail->first();

                if (! $owner) {
                    continue;
                }

                Contact::query()->updateOrCreate(
                    [
                        'company_id' => $company->id,
                        'email' => $seedContact['email'],
                    ],
                    [
                        'created_by' => $owner->id,
                        'first_name' => $seedContact['first_name'],
                        'last_name' => $seedContact['last_name'],
                        'phone' => $seedContact['phone'],
                        'title' => $seedContact['title'],
                        'notes' => $seedContact['notes'],
                    ],
                );
            }
        }
    }
}
