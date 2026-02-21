<?php

namespace App\Concerns\Activity;

use App\Enums\ActivityAction;
use App\Support\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

trait LogsModelActivity
{
    public static function bootLogsModelActivity(): void
    {
        static::created(function (Model $model): void {
            ActivityLogger::logModelEvent($model, ActivityAction::Created);
        });

        static::updated(function (Model $model): void {
            ActivityLogger::logModelEvent($model, ActivityAction::Updated);
        });

        static::deleted(function (Model $model): void {
            ActivityLogger::logModelEvent($model, ActivityAction::Deleted);
        });
    }
}
