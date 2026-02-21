<?php

namespace App\Support;

use App\Enums\ActivityAction;
use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ActivityLogger
{
    public static function logModelEvent(Model $model, ActivityAction $action, array $metadata = []): void
    {
        if ($model instanceof ActivityLog) {
            return;
        }

        $changes = $model->getChanges();
        unset($changes['updated_at']);

        $beforeValues = null;
        $afterValues = null;

        if ($action === ActivityAction::Updated && $changes !== []) {
            $beforeValues = Arr::only($model->getOriginal(), array_keys($changes));
            $afterValues = $changes;
        }

        if ($action === ActivityAction::Deleted) {
            $beforeValues = $model->getOriginal();
        }

        if ($action === ActivityAction::Created) {
            $afterValues = $model->getAttributes();
        }

        ActivityLog::query()->create([
            'user_id' => Auth::id(),
            'loggable_type' => $model->getMorphClass(),
            'loggable_id' => $model->getKey(),
            'action' => $action->value,
            'description' => self::describe($model, $action),
            'before_values' => $beforeValues,
            'after_values' => $afterValues,
            'metadata' => $metadata,
        ]);
    }

    public static function logCustom(Model $model, ActivityAction $action, string $description, array $metadata = []): void
    {
        ActivityLog::query()->create([
            'user_id' => Auth::id(),
            'loggable_type' => $model->getMorphClass(),
            'loggable_id' => $model->getKey(),
            'action' => $action->value,
            'description' => $description,
            'before_values' => null,
            'after_values' => null,
            'metadata' => $metadata,
        ]);
    }

    protected static function describe(Model $model, ActivityAction $action): string
    {
        $modelName = Str::headline(class_basename($model));

        return sprintf('%s #%s %s', $modelName, (string) $model->getKey(), $action->value);
    }
}
