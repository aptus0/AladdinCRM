# Alladdin CRM MVP Blueprint

## Product Definition
Alladdin CRM, kucuk ekiplerin musteri (Company/Contact), firsat (Opportunity), teklif (Quote), gorev (Task/Kanban) ve destek (Ticket) sureclerini tek panelden yonettigi web uygulamasidir.

## Scope Lock

### MVP (Locked)
1. Auth + roles (`admin`, `staff`) + policy based access.
2. Company and Contact management with search/filter/pagination/soft-delete.
3. Opportunity pipeline with stage updates and pipeline summary.
4. Quote + quote items + automatic totals + PDF export endpoint.
5. Task + Kanban move API (`status`, `position`) using async fetch style.
6. Ticket + message thread.
7. Activity log for create/update/delete/move/status events.
8. Dashboard metrics: tasks due today, open tickets, pipeline total, recent activities.

### V2 (Deferred)
- Multi-tenant isolation.
- Workflow automations/reminders.
- File attachments.
- Tagging.
- WhatsApp/SMS integrations.
- Advanced reports and charting.

## Architecture Rules
- Controller is thin, business logic in `Actions`/`Services`.
- Validation in `FormRequest`.
- Authorization in `Policy`.
- Cross-cutting logging in dedicated logger/trait.
- Totals and state transitions run on backend only.
- Multi-record updates wrapped by `DB::transaction()`.

## Locked Decisions
- Roles: `Admin`, `Staff`.
- Opportunity stages: `Lead -> Qualified -> Proposal -> Negotiation -> Won/Lost`.
- Quote currency: `TRY`, `USD`, `EUR`.
- Kanban: only for `Task` (not `Opportunity`).
- No invoicing/payments in MVP, only quote PDF.

## ERD (MVP)
- `users`
  - hasMany `companies`, `contacts`, `opportunities`, `quotes`, `tasks`, `tickets`, `ticket_messages`, `activity_logs`
- `companies`
  - belongsTo `users(created_by)`
  - hasMany `contacts`, `opportunities`, `quotes`, `tasks`, `tickets`
- `contacts`
  - belongsTo `companies`
  - belongsTo `users(created_by)`
- `opportunities`
  - belongsTo `companies`
  - belongsTo `users(created_by)`
  - hasMany `quotes`, `tasks`
- `quotes`
  - belongsTo `companies`
  - belongsTo `opportunities` (nullable)
  - belongsTo `users(created_by)`
  - hasMany `quote_items`
- `tasks`
  - belongsTo `companies` (nullable)
  - belongsTo `opportunities` (nullable)
  - belongsTo `users(created_by)`
  - belongsTo `users(assignee_id)` (nullable)
- `tickets`
  - belongsTo `companies` (nullable)
  - belongsTo `contacts` (nullable)
  - belongsTo `users(created_by)`
  - belongsTo `users(assigned_to)` (nullable)
  - hasMany `ticket_messages`
- `ticket_messages`
  - belongsTo `tickets`
  - belongsTo `users`
- `activity_logs`
  - belongsTo `users` (nullable)
  - morphTo `loggable`

## API Route List (MVP)
Prefixed with `/api`, guarded by `auth + verified`.

- `GET /api/dashboard/metrics`
- `GET /api/companies`, `POST /api/companies`, `GET /api/companies/{company}`, `PUT/PATCH /api/companies/{company}`, `DELETE /api/companies/{company}`
- `GET /api/contacts`, `POST /api/contacts`, `GET /api/contacts/{contact}`, `PUT/PATCH /api/contacts/{contact}`, `DELETE /api/contacts/{contact}`
- `GET /api/opportunities`, `POST /api/opportunities`, `GET /api/opportunities/{opportunity}`, `PUT/PATCH /api/opportunities/{opportunity}`, `DELETE /api/opportunities/{opportunity}`
- `GET /api/opportunities/pipeline-summary`
- `GET /api/quotes`, `POST /api/quotes`, `GET /api/quotes/{quote}`, `PUT/PATCH /api/quotes/{quote}`, `DELETE /api/quotes/{quote}`
- `GET /api/quotes/{quote}/pdf`
- `GET /api/tasks`, `POST /api/tasks`, `GET /api/tasks/{task}`, `PUT/PATCH /api/tasks/{task}`, `DELETE /api/tasks/{task}`
- `POST /api/tasks/{task}/move`
- `GET /api/tickets`, `POST /api/tickets`, `GET /api/tickets/{ticket}`, `PUT/PATCH /api/tickets/{ticket}`, `DELETE /api/tickets/{ticket}`
- `POST /api/tickets/{ticket}/messages`

## Git Convention
Use conventional commits:
- `feat(scope): ...`
- `fix(scope): ...`
- `refactor(scope): ...`
- `test(scope): ...`
- `docs(scope): ...`
- `chore(scope): ...`

Example scopes: `auth`, `companies`, `opportunities`, `quotes`, `tasks`, `tickets`, `api`, `policies`, `ui`.
