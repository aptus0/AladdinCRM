<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Opportunity;
use App\Models\User;
use Database\Seeders\Support\CrmSeedData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpportunitySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $usersByEmail = User::query()->get()->keyBy('email');

        foreach (CrmSeedData::opportunitiesByCompany() as $companyName => $opportunities) {
            $company = Company::query()->where('name', $companyName)->first();

            if (! $company) {
                continue;
            }

            foreach ($opportunities as $seedOpportunity) {
                $owner = $usersByEmail->get($seedOpportunity['created_by']) ?? $usersByEmail->first();

                if (! $owner) {
                    continue;
                }

                Opportunity::query()->updateOrCreate(
                    [
                        'company_id' => $company->id,
                        'title' => $seedOpportunity['title'],
                    ],
                    [
                        'created_by' => $owner->id,
                        'stage' => $seedOpportunity['stage'],
                        'amount' => $seedOpportunity['amount'],
                        'close_date' => now()->addDays($seedOpportunity['close_in_days'])->toDateString(),
                        'notes' => $seedOpportunity['notes'],
                    ],
                );
            }
        }
    }
}
