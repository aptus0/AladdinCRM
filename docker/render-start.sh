#!/usr/bin/env sh
set -eu

cd /opt/render/project/src

if [ -z "${APP_KEY:-}" ]; then
    echo "APP_KEY is missing. Set APP_KEY in Render environment variables." >&2
    exit 1
fi

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    php artisan migrate --force
fi

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
