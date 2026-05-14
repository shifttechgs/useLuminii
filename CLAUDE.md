# Luminii CRM — Claude Context

## Project Overview
Laravel 11 + Filament v3 admin panel for a web agency (ShiftTech). The admin panel is branded "Luminii CRM". The public site has a contact form that feeds directly into the CRM.

- Admin panel prefix: `useluminii`
- PHP binary: `/mnt/c/wamp64_3.3.4/bin/php/php8.3.14/php.exe`
- CSS served from: `public/css/crm-design-system.css` (NOT `resources/css/crm.css`)

---

## CRM Architecture

### Unified Leads System
All prospects — whether from the website contact form, a phone call, referral, or manual entry — are a single `Lead` model. There is no split between "website leads" and "manual leads".

- **Model:** `App\Models\Lead`
- **Table:** `leads`
- **Route key:** `lead_id` (e.g. `LEA-A1B2C3D4`) — set via `getRouteKeyName()`
- **Source field:** `website | call | referral | email | social | manual`
- **Status funnel:** New → Contacted → Qualified → Proposal Sent → Converted → Closed
- `services_interested` is cast as `array` (stored as JSON)
- Soft deletes enabled

### Services Single Source of Truth
Services displayed on the public contact form and all CRM dropdowns come from the `business_services` table (`App\Models\BusinessService`). Admins manage services in one place; the website reflects changes automatically.

### Client Dropdown Format
All client `Select` fields across every resource use:
```php
BusinessClient::orderBy('company')->orderBy('firstname')->get()
    ->mapWithKeys(fn ($c) => [
        $c->client_id => ($c->company ? "{$c->company} — " : '') . "{$c->firstname} {$c->lastname}"
    ])
```
Format: **"Acme Corp — John Doe"** (company first). When no company: **"John Doe"**.

---

## Table Design System

### Principle: Action-Oriented Tables
Every CRM table has a **Next Action** badge as the final column. It computes what the user should do next based on record state + age, so the user can scan the list and act without reading multiple columns.

Tables are sorted so the most urgent records appear first (not newest-first).

### Next Action — Leads
```php
Tables\Columns\TextColumn::make('next_action')
    ->label('Next Action')
    ->getStateUsing(function ($record) {
        $days = $record->created_at->diffInDays();
        return match(true) {
            in_array($record->status, ['Converted', 'Closed'])                             => '— Done',
            $record->status === 'New' && $record->priority === 'Urgent'                    => '🔴 Call immediately',
            $record->status === 'New' && $record->priority === 'High'                      => '📞 Call today',
            $record->status === 'New' && $days > 2                                         => '📧 Overdue outreach',
            $record->status === 'New'                                                       => '📧 Reach out',
            $record->status === 'Contacted' && $days > 3                                   => '⏰ Follow up now',
            $record->status === 'Contacted'                                                 => '✔ Qualify lead',
            $record->status === 'Qualified'                                                 => '📄 Send proposal',
            $record->status === 'Proposal Sent' && $record->updated_at->diffInDays() > 5  => '⏰ Chase decision',
            $record->status === 'Proposal Sent'                                            => '⏳ Awaiting decision',
            default                                                                         => '—',
        };
    })
    ->badge()
    ->color(fn ($state) => match(true) {
        str_contains($state, '🔴') || str_contains($state, '⏰') => 'danger',
        str_contains($state, '📞') || str_contains($state, '⏳') => 'warning',
        str_contains($state, '📄') || str_contains($state, '✔')  => 'primary',
        str_contains($state, '📧')                                => 'info',
        default                                                   => 'gray',
    })
```

**Sort:** Urgent → High → Normal → Low, then oldest first (most stale = most at risk):
```php
->modifyQueryUsing(fn ($query) => $query
    ->orderByRaw("FIELD(priority, 'Urgent', 'High', 'Normal', 'Low')")
    ->orderBy('created_at', 'asc')
)
```

### Next Action — Client Requests
State computed from `status` + `updated_at` age:
- New + Urgent → 🔴 Review immediately
- New → 👁 Review request
- InReview + >3 days → ⏰ Send quote now
- InReview → 📄 Prepare quote
- Quoted + >5 days → ⏰ Chase approval
- Quoted → ⏳ Awaiting approval
- Approved → 🚀 Start the job
- Closed → — Closed

**Sort:** priority order, then oldest first.

### Next Action — Clients
State computed from `client_type` + `status` + age:
- Lead + >5 days → ⏰ Contact overdue
- Lead → 📞 Make first contact
- Prospect → 🎯 Qualify prospect
- Client + Active → ✅ Maintain relationship
- Inactive → 💬 Re-engage

**Sort:** Lead → Prospect → Client (most needing attention first), then oldest first.

### Color Convention for Next Action badges
| Color | Meaning |
|-------|---------|
| `danger` (red) | Act now — overdue or urgent |
| `warning` (amber) | In progress — awaiting something |
| `primary` (blue/purple) | Clear next step ready |
| `info` (blue) | Outreach needed |
| `success` (green) | Healthy / complete |
| `gray` | No action needed |

### Standard Table Column Pattern
```php
// ID column
Tables\Columns\TextColumn::make('lead_id')
    ->fontFamily('mono')
    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall)
    ->color('gray')->copyable()->sortable()->searchable()

// Primary record column (name + context as description)
Tables\Columns\TextColumn::make('name')
    ->weight(\Filament\Support\Enums\FontWeight::SemiBold)
    ->description(fn ($record) => $record->company ?: $record->email)

// Contact column (email + phone as description)
Tables\Columns\TextColumn::make('email')
    ->description(fn ($record) => $record->phone ?: null)
    ->copyable()->color('gray')

// Timestamps — relative, small, gray
->since()->color('gray')->size(TextColumnSize::ExtraSmall)
```

### Standard Actions Pattern
```php
// Primary: icon buttons with tooltips
Tables\Actions\ViewAction::make()->iconButton()->tooltip('View'),
Tables\Actions\EditAction::make()->iconButton()->tooltip('Edit'),

// Secondary: ellipsis dropdown for workflow actions
Tables\Actions\ActionGroup::make([...])
    ->icon('heroicon-m-ellipsis-vertical')
    ->tooltip('More'),
```

All tables use `->striped()`.

---

## Key Technical Notes

### MySQL utf8mb4 Key Length
This server has a ~1000 byte index limit. Adding `Schema::defaultStringLength(191)` at the top of migrations prevents `Specified key was too long` errors. Use `string(20)` for ID columns, `string(30)` for status/source columns.

### Pipeline Kanban
- File: `app/Filament/Pages/Pipeline.php` + `resources/views/filament/pages/pipeline.blade.php`
- Queries `Lead` model (not `ClientRequest`)
- Drag-drop via Alpine `@dragover`/`@drop` + Livewire `wire:click`
- Cards show: priority border color, initials avatar, STALE badge (>3 days in New/Contacted), source/priority/budget pills, service chips, quick-move buttons

### Observer
`ContactFormObserver` on `Lead` model (not `ContactFormSubmission`). Registered in `AppServiceProvider`.

### CSS
Never edit `resources/css/crm.css` — it is not compiled or served. All custom styles go in `public/css/crm-design-system.css`.
