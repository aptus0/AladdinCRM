# System Status API

`GET /api/system/status`

Returns application runtime status, license verification result, and version-check metadata in a single response.

## Authentication

- Requires authenticated user session.
- Route is protected by:
  - `auth`
  - `verified`
  - `App\Http\Middleware\EnsureLicenseIsValid`

## Request

```http
GET /api/system/status
Accept: application/json
```

## Success Response (`200 OK`)

```json
{
  "app": {
    "name": "Alladdin CRM",
    "version": "1.0.1",
    "environment": "local"
  },
  "license": {
    "enabled": false,
    "valid": true,
    "enforced": false,
    "source": "disabled",
    "message": "License check disabled.",
    "key_last4": null,
    "checked_at": "2026-02-21T23:10:00+00:00"
  },
  "version": {
    "current_version": "1.0.1",
    "latest_version": null,
    "update_available": false,
    "source": "disabled",
    "message": "Version check URL not configured.",
    "download_url": null,
    "notes_url": null,
    "checked_at": "2026-02-21T23:10:00+00:00"
  }
}
```

## Error Responses

### `401 Unauthorized`

Returned when user is not authenticated.

### `403 Forbidden`

Returned when license enforcement is enabled and verification fails.

```json
{
  "message": "License key not configured."
}
```

## Headers

When request passes middleware checks, response includes:

- `X-App-Version`: current app version
- `X-License-Status`: `valid` or `warning`

## Source References

- Route registration: `routes/web.php`
- Controller: `app/Http/Controllers/Api/SystemStatusController.php`
- Middleware: `app/Http/Middleware/EnsureLicenseIsValid.php`
- License service: `app/Support/License/LicenseVerifier.php`
- Version service: `app/Support/System/VersionChecker.php`
