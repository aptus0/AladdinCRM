# Deploy to Render

This repo includes a Docker-based Render setup:

- [`render.yaml`](../render.yaml)
- [`Dockerfile`](../Dockerfile)
- [`docker/render-start.sh`](../docker/render-start.sh)

## 1) Create services from Blueprint

1. Open Render Dashboard: <https://dashboard.render.com>
2. Click `New +` -> `Blueprint`.
3. Select this repository (`aptus0/AladdinCRM`) and branch (`main`).
4. Render will detect `render.yaml` and create:
   - `aladdincrm-web` (web service)
   - `aladdincrm-db` (PostgreSQL)

## 2) Required environment variables

Set these in `aladdincrm-web` -> `Environment`:

- `APP_URL=https://<your-render-service>.onrender.com`
- `APP_KEY=<output of php artisan key:generate --show>`

Generate key locally:

```bash
php artisan key:generate --show
```

Use the full value (starts with `base64:`).

## 3) Verify deploy

After deploy:

- Open `https://<your-render-service>.onrender.com/up`
- Expected response: HTTP `200`

## Notes

- `RUN_MIGRATIONS=true` is enabled by default and runs migrations at startup.
- Logs go to Render logs via `LOG_CHANNEL=stderr`.
- Queue is set to `sync` to avoid needing a separate worker service.
- If you use external database firewall rules, allow Render egress ranges you shared:
  - `74.220.48.0/24`
  - `74.220.56.0/24`
