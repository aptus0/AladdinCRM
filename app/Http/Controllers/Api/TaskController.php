<?php

namespace App\Http\Controllers\Api;

use App\Actions\Tasks\MoveTaskToColumn;
use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\MoveTaskRequest;
use App\Http\Requests\Api\Task\StoreTaskRequest;
use App\Http\Requests\Api\Task\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $tasks = Task::query()
            ->with(['assignee:id,name', 'company:id,name'])
            ->when(
                ! $user->isAdmin(),
                fn ($query) => $query->where(function ($inner) use ($user): void {
                    $inner->where('created_by', $user->id)
                        ->orWhere('assignee_id', $user->id);
                }),
            )
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where('status', (string) $request->string('status')),
            )
            ->when(
                $request->filled('assignee_id'),
                fn ($query) => $query->where('assignee_id', (int) $request->integer('assignee_id')),
            )
            ->orderBy('status')
            ->orderBy('sort_order')
            ->get();

        if ($request->boolean('grouped')) {
            return response()->json([
                TaskStatus::Todo->value => $tasks->where('status', TaskStatus::Todo->value)->values(),
                TaskStatus::Doing->value => $tasks->where('status', TaskStatus::Doing->value)->values(),
                TaskStatus::Done->value => $tasks->where('status', TaskStatus::Done->value)->values(),
            ]);
        }

        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::query()->create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
            'status' => $request->input('status', TaskStatus::Todo->value),
            'sort_order' => ((int) Task::query()
                ->where('status', $request->input('status', TaskStatus::Todo->value))
                ->max('sort_order')) + 1,
        ]);

        return response()->json($task->load(['assignee:id,name', 'company:id,name']), 201);
    }

    public function show(Task $task): JsonResponse
    {
        return response()->json($task->load(['assignee:id,name', 'company:id,name']));
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $task->update($request->validated());

        return response()->json($task->fresh()->load(['assignee:id,name', 'company:id,name']));
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }

    public function move(Task $task, MoveTaskRequest $request, MoveTaskToColumn $moveTaskToColumn): JsonResponse
    {
        $this->authorize('update', $task);

        $updated = $moveTaskToColumn->handle(
            $task,
            TaskStatus::from((string) $request->string('status')),
            (int) $request->integer('position'),
        );

        return response()->json($updated->load(['assignee:id,name', 'company:id,name']));
    }
}
