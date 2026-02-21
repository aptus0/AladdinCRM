<?php

namespace Database\Seeders;

use App\Enums\ActivityAction;
use App\Enums\TaskStatus;
use App\Enums\TicketStatus;
use App\Models\ActivityLog;
use App\Models\Opportunity;
use App\Models\Quote;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@aladdincrm.test')->first();
        $staff = User::query()->where('email', 'staff@aladdincrm.test')->first();
        $support = User::query()->where('email', 'support@aladdincrm.test')->first();

        $quote = Quote::query()->orderByDesc('id')->first();
        $task = Task::query()->where('status', TaskStatus::Doing)->orderBy('id')->first();
        $ticket = Ticket::query()->orderByDesc('id')->first();
        $opportunity = Opportunity::query()->where('stage', 'negotiation')->orderBy('id')->first();

        if ($quote && $admin) {
            ActivityLog::query()->updateOrCreate(
                ['description' => sprintf('Quote #%s status changed to %s', $quote->quote_number, $quote->status->value)],
                [
                    'user_id' => $admin->id,
                    'loggable_type' => $quote->getMorphClass(),
                    'loggable_id' => $quote->id,
                    'action' => ActivityAction::StatusChanged->value,
                    'before_values' => ['status' => 'draft'],
                    'after_values' => ['status' => $quote->status->value],
                    'metadata' => ['source' => 'seeder', 'module' => 'quotes'],
                    'created_at' => now()->subMinutes(55),
                ],
            );
        }

        if ($task && $staff) {
            ActivityLog::query()->updateOrCreate(
                ['description' => sprintf('Task #%d moved to %s', $task->id, $task->status->value)],
                [
                    'user_id' => $staff->id,
                    'loggable_type' => $task->getMorphClass(),
                    'loggable_id' => $task->id,
                    'action' => ActivityAction::Moved->value,
                    'before_values' => ['status' => TaskStatus::Todo->value, 'sort_order' => 4],
                    'after_values' => ['status' => $task->status->value, 'sort_order' => $task->sort_order],
                    'metadata' => ['source' => 'seeder', 'module' => 'tasks'],
                    'created_at' => now()->subMinutes(40),
                ],
            );
        }

        if ($ticket && $support) {
            ActivityLog::query()->updateOrCreate(
                ['description' => sprintf('Ticket #%d status updated to %s', $ticket->id, $ticket->status->value)],
                [
                    'user_id' => $support->id,
                    'loggable_type' => $ticket->getMorphClass(),
                    'loggable_id' => $ticket->id,
                    'action' => ActivityAction::StatusChanged->value,
                    'before_values' => ['status' => TicketStatus::Open->value],
                    'after_values' => ['status' => $ticket->status->value],
                    'metadata' => ['source' => 'seeder', 'module' => 'tickets'],
                    'created_at' => now()->subMinutes(22),
                ],
            );
        }

        if ($opportunity && $admin) {
            ActivityLog::query()->updateOrCreate(
                ['description' => sprintf('Opportunity #%d moved to negotiation', $opportunity->id)],
                [
                    'user_id' => $admin->id,
                    'loggable_type' => $opportunity->getMorphClass(),
                    'loggable_id' => $opportunity->id,
                    'action' => ActivityAction::StatusChanged->value,
                    'before_values' => ['stage' => 'proposal'],
                    'after_values' => ['stage' => 'negotiation'],
                    'metadata' => ['source' => 'seeder', 'module' => 'opportunities'],
                    'created_at' => now()->subMinutes(12),
                ],
            );
        }

        if ($quote && $staff) {
            ActivityLog::query()->updateOrCreate(
                ['description' => sprintf('Quote #%s totals recalculated', $quote->quote_number)],
                [
                    'user_id' => $staff->id,
                    'loggable_type' => $quote->getMorphClass(),
                    'loggable_id' => $quote->id,
                    'action' => ActivityAction::Updated->value,
                    'before_values' => ['grand_total' => (float) $quote->grand_total - 1500],
                    'after_values' => ['grand_total' => (float) $quote->grand_total],
                    'metadata' => ['source' => 'seeder', 'module' => 'quotes', 'reason' => 'line item change'],
                    'created_at' => now()->subMinutes(5),
                ],
            );
        }
    }
}
