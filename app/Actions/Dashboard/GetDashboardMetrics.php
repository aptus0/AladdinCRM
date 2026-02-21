<?php

namespace App\Actions\Dashboard;

use App\Enums\OpportunityStage;
use App\Enums\TaskStatus;
use App\Enums\TicketStatus;
use App\Models\ActivityLog;
use App\Models\Opportunity;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\User;

class GetDashboardMetrics
{
    /**
     * @return array<string, mixed>
     */
    public function handle(User $user): array
    {
        $taskQuery = Task::query()
            ->whereDate('due_date', now()->toDateString())
            ->whereIn('status', [TaskStatus::Todo->value, TaskStatus::Doing->value]);

        $ticketQuery = Ticket::query()
            ->whereIn('status', [TicketStatus::Open->value, TicketStatus::Waiting->value]);

        $opportunityQuery = Opportunity::query()
            ->whereNotIn('stage', [OpportunityStage::Won->value, OpportunityStage::Lost->value]);

        $activityQuery = ActivityLog::query()->with('user')->latest('created_at');

        if (! $user->isAdmin()) {
            $taskQuery->where(function ($query) use ($user): void {
                $query->where('created_by', $user->id)
                    ->orWhere('assignee_id', $user->id);
            });

            $ticketQuery->where(function ($query) use ($user): void {
                $query->where('created_by', $user->id)
                    ->orWhere('assigned_to', $user->id);
            });

            $opportunityQuery->where('created_by', $user->id);
            $activityQuery->where('user_id', $user->id);
        }

        return [
            'tasks_due_today' => $taskQuery->count(),
            'open_tickets' => $ticketQuery->count(),
            'pipeline_total' => (float) $opportunityQuery->sum('amount'),
            'recent_activities' => $activityQuery
                ->limit(10)
                ->get()
                ->map(fn (ActivityLog $log): array => [
                    'id' => $log->id,
                    'action' => $log->action,
                    'description' => $log->description,
                    'user' => $log->user?->name,
                    'created_at' => $log->created_at?->toISOString(),
                ])
                ->all(),
        ];
    }
}
