# Open Source Strategy

## Recommended Model

- **Core**: Open source (`MIT`)
- **Premium Modules**: Private repository + optional license key flow

This gives strong portfolio visibility while keeping monetization path for V2.

## What MIT Covers

- Anyone can use, fork, and modify code.
- Copyright and license notice must stay.
- No warranty.

## Practical Protections

- Keep the product name and logo as trademarked brand assets (outside MIT scope).
- Maintain release tags and release notes.
- Use integrity snapshot/check commands for internal deployment verification.

## Technical Controls Included

- `EnsureLicenseIsValid` middleware (optional, env driven)
- `/api/system/status` endpoint
- Version checker service
- Integrity snapshot/check commands

