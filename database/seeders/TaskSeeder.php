<?php

namespace Database\Seeders;

use App\Enums\OpportunityStage;
use App\Enums\TaskStatus;
use App\Models\Company;
use App\Models\Opportunity;
use App\Models\Task;
use App\Models\User;
use Database\Seeders\Support\CrmSeedData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $usersByEmail = User::query()->get()->keyBy('email');
        $assignees = [
            $usersByEmail->get('staff@aladdincrm.test'),
            $usersByEmail->get('support@aladdincrm.test'),
            $usersByEmail->get('sales@aladdincrm.test'),
            $usersByEmail->get('ops@aladdincrm.test'),
        ];

        $assignees = array_values(array_filter($assignees));
        if ($assignees === []) {
            return;
        }

        $statusOrder = [
            TaskStatus::Todo->value => 1,
            TaskStatus::Doing->value => 1,
            TaskStatus::Done->value => 1,
        ];

        $opportunities = Opportunity::query()
            ->with('company')
            ->orderBy('id')
            ->get();

        foreach ($opportunities as $index => $opportunity) {
            $status = $this->statusFromStage($opportunity->stage);
            $assignee = $assignees[$index % count($assignees)];
            $title = sprintf('%s | %s takip gorevi', $opportunity->company?->name ?? 'Company', $opportunity->title);
            $dueDate = $opportunity->close_date
                ? $opportunity->close_date->copy()->subDays(2)->toDateString()
                : now()->addDays(7)->toDateString();

            Task::query()->updateOrCreate(
                [
                    'company_id' => $opportunity->company_id,
                    'opportunity_id' => $opportunity->id,
                    'title' => $title,
                ],
                [
                    'created_by' => $opportunity->created_by,
                    'assignee_id' => $assignee->id,
                    'description' => 'Firsat kapanisina kadar musteri iletisimi ve ic takip gorevi.',
                    'due_date' => $dueDate,
                    'status' => $status,
                    'sort_order' => $statusOrder[$status->value]++,
                ],
            );
        }

        foreach (CrmSeedData::extraTasks() as $taskIndex => $extraTask) {
            $company = Company::query()->where('name', $extraTask['company'])->first();
            $creator = $usersByEmail->get($extraTask['created_by']);
            $assignee = $usersByEmail->get($extraTask['assignee']);

            if (! $company || ! $creator || ! $assignee) {
                continue;
            }

            Task::query()->updateOrCreate(
                [
                    'company_id' => $company->id,
                    'opportunity_id' => null,
                    'title' => $extraTask['title'],
                ],
                [
                    'created_by' => $creator->id,
                    'assignee_id' => $assignee->id,
                    'description' => $extraTask['description'],
                    'due_date' => now()->addDays($extraTask['due_in_days'])->toDateString(),
                    'status' => $extraTask['status'],
                    'sort_order' => $statusOrder[$extraTask['status']->value]++,
                ],
            );
        }
    }

    private function statusFromStage(OpportunityStage $stage): TaskStatus
    {
        return match ($stage) {
            OpportunityStage::Lead => TaskStatus::Todo,
            OpportunityStage::Qualified, OpportunityStage::Proposal, OpportunityStage::Negotiation => TaskStatus::Doing,
            OpportunityStage::Won, OpportunityStage::Lost => TaskStatus::Done,
        };
    }
}
