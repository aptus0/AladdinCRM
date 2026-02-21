<?php

namespace App\Actions\Tasks;

use App\Enums\ActivityAction;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Support\ActivityLogger;
use Illuminate\Support\Facades\DB;

class MoveTaskToColumn
{
    public function handle(Task $task, TaskStatus $status, int $position): Task
    {
        return DB::transaction(function () use ($task, $status, $position): Task {
            $sourceStatus = $task->status;

            $sourceTasks = Task::query()
                ->where('status', $sourceStatus->value)
                ->whereKeyNot($task->id)
                ->orderBy('sort_order')
                ->lockForUpdate()
                ->pluck('id')
                ->all();

            foreach ($sourceTasks as $sourceIndex => $sourceTaskId) {
                Task::query()->whereKey($sourceTaskId)->update(['sort_order' => $sourceIndex]);
            }

            $targetTaskIds = Task::query()
                ->where('status', $status->value)
                ->whereKeyNot($task->id)
                ->orderBy('sort_order')
                ->lockForUpdate()
                ->pluck('id')
                ->all();

            $position = max(0, min($position, count($targetTaskIds)));
            array_splice($targetTaskIds, $position, 0, [$task->id]);

            foreach ($targetTaskIds as $targetIndex => $targetTaskId) {
                if ($targetTaskId === $task->id) {
                    Task::query()->whereKey($task->id)->update([
                        'status' => $status->value,
                        'sort_order' => $targetIndex,
                    ]);

                    continue;
                }

                Task::query()->whereKey($targetTaskId)->update(['sort_order' => $targetIndex]);
            }

            $task->refresh();

            ActivityLogger::logCustom(
                $task,
                ActivityAction::Moved,
                sprintf('Task #%d moved to %s column', $task->id, $task->status->value),
                [
                    'status' => $task->status->value,
                    'position' => $task->sort_order,
                ],
            );

            return $task;
        });
    }
}
