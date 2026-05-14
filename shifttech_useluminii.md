# ShiftTech — UseLuminii CRM Documentation
> **Project:** Luminii CRM integrated into shifttechgs.com  
> **CRM URL:** `https://shifttechgs.com/useluminii`  
> **Stack:** Laravel 11 · Filament v3 · MySQL · PayPal Orders API · FullCalendar v6  
> **Migrated from:** Angular (frontend) + C# ASP.NET Core (LuminiiApi backend)  
> **Last updated:** April 18, 2026

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Architecture & Tech Stack](#2-architecture--tech-stack)
3. [Module 1 — Authentication & Business Setup](#3-module-1--authentication--business-setup)
4. [Module 2 — Clients & Client Requests](#4-module-2--clients--client-requests)
5. [Module 3 — Quotes & Client Hub (Quotes)](#5-module-3--quotes--client-hub-quotes)
6. [Module 4 — Jobs & Invoices](#6-module-4--jobs--invoices)
7. [Module 5 — Expenses, Pipeline, Team Members & Recurring Invoices](#7-module-5--expenses-pipeline-team-members--recurring-invoices)
8. [Module 6 — Notifications, Activity Log & Dashboard Widgets](#8-module-6--notifications-activity-log--dashboard-widgets)
9. [Module 7 — Job Calendar & PayPal Payments](#9-module-7--job-calendar--paypal-payments)
10. [Database Schema Reference](#10-database-schema-reference)
11. [Scheduled Commands (Cron)](#11-scheduled-commands-cron)
12. [Email Templates](#12-email-templates)
13. [Public Routes (Client Hub)](#13-public-routes-client-hub)
14. [Environment Variables](#14-environment-variables)
15. [Deployment Checklist](#15-deployment-checklist)
16. [Default Login Credentials](#16-default-login-credentials)

---

## 1. Project Overview

UseLuminii is ShiftTech's internal CRM system built directly into the ShiftTech website using **Filament v3** as the admin panel framework. It replaces the original Angular + C# (LuminiiApi) SaaS CRM with a self-hosted, fully integrated Laravel solution.

### What it does
- Manage **clients**, **leads**, and **client requests** from the website contact form
- Create and send **quotes** (PDF + email) — clients can accept/decline via a secure link
- Convert quotes to **jobs**, schedule them on a calendar, assign team members
- Generate **invoices** (PDF + email) — clients can pay online via **PayPal**
- Track **expenses** by category with receipt uploads
- Manage **recurring invoices** that auto-generate on a schedule
- View **financial reports**, revenue vs expenses charts, top clients, pipeline value
- Manage **team members** with email-based invite system
- **In-app notifications** that auto-fire on key business events
- Full **activity audit log** of all actions

---

## 2. Architecture & Tech Stack

```
┌─────────────────────────────────────────────────────────────────┐
│                     shifttechgs.com                             │
│                                                                 │
│  Public Website (Blade + TailwindCSS)    /                      │
│  ├── Home, About, Services, Work, Contact                       │
│  └── Contact Form → CRM Lead capture                           │
│                                                                 │
│  CRM Admin Panel (Filament v3)           /useluminii            │
│  ├── Resources (CRUD)                                           │
│  ├── Custom Pages (Reports, Pipeline, Calendar, Notifications)  │
│  └── Widgets (Dashboard stats, charts, activity feed)          │
│                                                                 │
│  Client Hub (Public, token-based)        /client-hub/...        │
│  ├── Quote viewer + Accept / Decline                            │
│  └── Invoice viewer + PayPal payment                           │
└─────────────────────────────────────────────────────────────────┘
```

### Key Packages
| Package | Version | Purpose |
|---|---|---|
| `filament/filament` | ^3 | Admin panel framework |
| `srmklive/paypal` | ^3.1 | PayPal Orders API v2 |
| `barryvdh/laravel-dompdf` | ^2 | PDF generation for quotes & invoices |
| `laravel/framework` | ^11 | Core framework |

### Directory Structure (CRM-specific)
```
app/
├── Console/Commands/
│   ├── MarkOverdueInvoices.php        # Daily: flags overdue invoices
│   └── ProcessRecurringInvoices.php   # Daily: auto-generates recurring invoices
├── Filament/
│   ├── Pages/
│   │   ├── BusinessSettings.php       # Business profile & banking settings
│   │   ├── JobCalendar.php            # FullCalendar job scheduling
│   │   ├── NotificationsInbox.php     # In-app notification inbox
│   │   ├── Pipeline.php               # Kanban board for client requests
│   │   └── Reports.php                # Financial reports & analytics
│   ├── Resources/
│   │   ├── ClientResource.php
│   │   ├── ClientRequestResource.php
│   │   ├── ContactSubmissionResource.php
│   │   ├── ExpenseResource.php
│   │   ├── InvoiceResource.php
│   │   ├── JobResource.php
│   │   ├── QuoteResource.php
│   │   ├── RecurringInvoiceResource.php
│   │   ├── TeamMemberResource.php
│   │   └── UserResource.php
│   └── Widgets/
│       ├── BusinessActionWidget.php   # "Needs attention" stats
│       ├── CrmStatsOverview.php       # Top-level KPI stats
│       ├── RecentActivityWidget.php   # Activity log feed
│       ├── RevenueChartWidget.php     # Revenue vs expenses chart
│       └── UpcomingJobsWidget.php     # Active/scheduled jobs table
├── Http/Controllers/
│   ├── ClientHubController.php        # Quote/Invoice public view + PayPal
│   ├── InvoicePdfController.php       # PDF download (auth)
│   └── QuotePdfController.php         # PDF download (auth)
├── Mail/
│   ├── ContactFormNotification.php
│   ├── InvoiceMail.php
│   ├── QuoteMail.php
│   └── TeamMemberInvite.php
├── Models/                            # 20 Eloquent models
├── Observers/                         # Auto-fire notifications on model events
└── Services/
    └── NotificationService.php        # Static helpers for in-app notifications
```

---

## 3. Module 1 — Authentication & Business Setup

### Overview
Handles admin login, user roles, and one-time business profile configuration.

### Filament Resource
| Resource | URL | Description |
|---|---|---|
| `UserResource` | `/useluminii/users` | Manage CRM users & roles |

### Filament Page
| Page | URL | Description |
|---|---|---|
| `BusinessSettings` | `/useluminii/business-settings` | Business profile, logo, banking details |

### Database Tables
| Table | Purpose |
|---|---|
| `users` | CRM user accounts (name, email, password, role, business_id, is_active) |
| `business_setup` | Business profile (name, email, phone, address, logo, VAT number, bank details) |

### User Roles
| Role | Access Level |
|---|---|
| `SuperAdmin` | Full access to all modules |
| `Admin` | Full CRM access, no user management |
| `SalesRep` | Clients, quotes, client requests |
| `Technician` | Jobs only |
| `Accountant` | Finance: invoices, expenses, reports |
| `Support` | Read-only access |

### Business Settings Fields
- **Profile:** Business name, trading name, registration number, VAT number, email, phone, address, website, logo
- **Banking:** Bank name, account name, account number, branch code, account type, SWIFT/BIC, payment instructions

### Default Admin Account
> Created by database seeder — change password on first login

```
Email:    admin@shifttechgs.com
Password: ShiftTech@2025!
URL:      /useluminii
```

### Migrations
- `0001_01_01_000000_create_users_table`
- `2026_04_17_000001_create_business_setup_table`
- `2026_04_17_000011_add_crm_fields_to_users_table`
- `2026_04_17_000012_add_banking_to_business_setup`

---

## 4. Module 2 — Clients & Client Requests

### Overview
Full client management — from website leads to active clients — plus a request/enquiry tracking system.

### Filament Resources
| Resource | URL | Description |
|---|---|---|
| `ClientResource` | `/useluminii/clients` | Client CRM with full profile |
| `ClientRequestResource` | `/useluminii/client-requests` | Service requests / enquiries |
| `ContactSubmissionResource` | `/useluminii/contact-submissions` | Website contact form leads |

### Filament Page
| Page | URL | Description |
|---|---|---|
| `Pipeline` | `/useluminii/pipeline` | Kanban board for client requests |

### Client Features
- **Client Types:** Lead → Client → VIP
- **Lead Sources:** Website, Referral, Social Media, Cold Call, Walk-in, Other
- **Fields:** Name, company, email, phone, address, VAT number, notes
- **"Convert to Client"** action on contact form submissions — auto-creates a `BusinessClient` record
- View all quotes, invoices, and jobs linked to a client from the client detail page

### Client Request Pipeline (Kanban)
Drag-and-drop board with 5 columns:

| Column | Meaning |
|---|---|
| 🔘 **New** | Just came in — unreviewed |
| 🟡 **In Review** | Being assessed |
| 🟣 **Quoted** | Quote has been sent |
| 🟢 **Approved** | Quote accepted, ready for job creation |
| ⬛ **Closed** | Completed or not proceeding |

### Contact Form Integration
Website contact form (`/contact`) auto-creates a `ContactFormSubmission` and fires:
- Email notification to admin
- In-app CRM notification (🌐 New Website Lead)
- Activity log entry

### Database Tables
| Table | Key Columns |
|---|---|
| `business_clients` | client_id, firstname, lastname, company, email, phone, client_type, lead_source |
| `client_requests` | request_id, client_id, title, description, status, priority, assessment_notes |
| `contact_form_submissions` | name, email, phone, service, message, status, lead_source |

### Migrations
- `2026_04_17_000002_create_business_clients_table`
- `2026_04_17_000008_create_team_members_table` (includes `client_requests`)
- `2026_04_17_000010_create_contact_form_submissions_table`

---

## 5. Module 3 — Quotes & Client Hub (Quotes)

### Overview
Full quoting system with PDF generation, email delivery, and a secure client-facing portal where clients can accept or decline quotes.

### Filament Resource
| Resource | URL | Description |
|---|---|---|
| `QuoteResource` | `/useluminii/quotes` | Full quote management |

### Quote Workflow
```
Draft → Sent → Accepted → [Job Created]
              ↘ Declined
              ↘ Expired
```

### Quote Features
- **Line items** with description, quantity, unit price and line total (no VAT column)
- **Subtotal / Discount / Grand Total** auto-calculation — VAT is **not charged** (ShiftTech is not yet VAT registered)
- **Required deposit** field
- **Internal notes** (private) + **Client message** (visible to client)
- **Send via email** — attaches PDF, includes "View Quote" button
- **PDF download** — `/useluminii/pdf/quote/{quoteId}` (auth required)
- **Convert to Job** — one-click action creates a linked `Job` record
- **Unique `accepted_token`** — secure URL for client hub

### Client Hub — Quote Viewer
**Public URL:** `/client-hub/quote/{token}`

| Action | Method | Route Name |
|---|---|---|
| View quote | GET | `client-hub.quote` |
| Accept quote | POST | `client-hub.quote.accept` |
| Decline quote | POST | `client-hub.quote.decline` |

When a client **accepts**: status → `Accepted`, timestamp saved, CRM notification fired, activity logged.  
When a client **declines**: status → `Declined`, CRM warning notification fired.

### Email Template
`resources/views/emails/quote.blade.php` — branded HTML email with quote summary, line items, and "View Your Quote" CTA button.

### Database Tables
| Table | Key Columns |
|---|---|
| `quotes` | quote_id, client_id, status, subtotal, total_tax, discount, grand_total, accepted_token, accepted_at |
| `quote_items` | quote_id, description, quantity, unit_price, tax_rate, line_total, sort_order |

### Migration
- `2026_04_17_000004_create_quotes_table`

---

## 6. Module 4 — Jobs & Invoices

### Overview
Job management from creation through completion, plus full invoicing with PDF generation, email delivery, and online payment via PayPal.

### Filament Resources
| Resource | URL | Description |
|---|---|---|
| `JobResource` | `/useluminii/jobs` | Job lifecycle management |
| `InvoiceResource` | `/useluminii/invoices` | Invoice management |

### Job Workflow
```
New → Scheduled → InProgress → Completed
                              ↘ Cancelled
```

### Job Features
- Link to client, quote, and team member
- **Job status** + **Scheduled status** + **Assigned status** tracked separately
- **Job items** (line items for labour/parts)
- **Internal notes** + **Client visible notes**
- **"Create Invoice from Job"** — one-click invoice generation using job items
- **"Schedule Job"** — sends to the Job Calendar

### Invoice Workflow
```
Draft → Sent → PartiallyPaid → Paid
             ↘ Overdue (auto-flagged daily)
             ↘ Cancelled
```

### Invoice Features
- **Line items** with description, quantity, unit price and line total (no VAT column)
- **Subtotal / Discount / Total / Balance** auto-recalculation — VAT is **not charged** (ShiftTech is not yet VAT registered)
- **Record Payment** action — partial or full, updates balance
- **Send via email** — attaches PDF with "View Invoice" and "Pay Now" buttons
- **PDF download** — `/useluminii/pdf/invoice/{invoiceId}` (auth required)
- **Unique `view_token`** — secure URL for client hub
- **PayPal payment** — client pays online, invoice auto-marked as Paid

### Client Hub — Invoice Viewer
**Public URL:** `/client-hub/invoice/{token}`

| Action | Method | Route Name |
|---|---|---|
| View invoice | GET | `client-hub.invoice` |
| Pay via PayPal | GET | `client-hub.payment.checkout` |
| PayPal success callback | GET | `client-hub.payment.success` |

### PayPal Payment Flow
```
Client clicks "Pay with PayPal"
    → Laravel creates PayPal Order (Orders API v2)
    → Redirect to PayPal approval page
    → Client pays (card / PayPal balance / bank)
    → PayPal redirects back to /success
    → Laravel captures payment
    → Invoice marked Paid, activity logged, CRM notification fired
```

> **Currency Note:** PayPal SA processes payments in **USD**. ZAR is not supported for PayPal Checkout. Clients are charged the USD equivalent at the current exchange rate.

### Email Templates
- `resources/views/emails/invoice.blade.php` — invoice email with line items and Pay Now button
- `resources/views/emails/quote.blade.php` — quote email

### Database Tables
| Table | Key Columns |
|---|---|
| `jobs` | job_id, client_id, quote_id, job_title, job_status, scheduled_status, assigned_status, job_date_time |
| `job_items` | job_id, description, quantity, unit_price, line_total |
| `invoices` | invoice_id, client_id, job_id, status, total_amount, balance, paid_at, view_token, paypal_order_id, paypal_capture_id, payment_method |
| `invoice_items` | invoice_id, description, quantity, unit_price, line_total, sort_order |

### Migrations
- `2026_04_17_000005_create_jobs_table`
- `2026_04_17_000006_create_invoices_table`
- `2026_04_18_000005_replace_stripe_with_paypal_on_invoices`

---

## 7. Module 5 — Expenses, Pipeline, Team Members & Recurring Invoices

### Overview
Financial tracking (expenses with categories and receipts), pipeline Kanban board, team member management with email invites, and automated recurring invoice generation.

### Filament Resources
| Resource | URL | Description |
|---|---|---|
| `ExpenseResource` | `/useluminii/expenses` | Expense tracking with categories |
| `RecurringInvoiceResource` | `/useluminii/recurring-invoices` | Recurring invoice schedules |
| `TeamMemberResource` | `/useluminii/team-members` | Team member management & invites |

### Expenses
- **12 default categories** seeded with colours (Advertising & Marketing, Equipment & Tools, Software & Subscriptions, Vehicle & Travel, Office Supplies, Salaries & Wages, Rent & Utilities, Insurance, Professional Fees, Bank & Finance Charges, Repairs & Maintenance, Miscellaneous)
- **Receipt upload** — JPG/PNG/PDF up to 4MB stored in `storage/public/receipts`
- **Recurring expense** flag with recurrence type (Weekly / Monthly / Yearly)
- **Category breakdown** visible in Reports page

### Recurring Invoices
Recurring invoice schedules that automatically generate real invoices on a schedule.

| Frequency | Next invoice generated |
|---|---|
| Weekly | Every 7 days |
| Monthly | Same date each month |
| Quarterly | Every 3 months |
| Annually | Once per year |

**Artisan Command:** `php artisan crm:recurring-invoices`  
**Schedule:** Runs daily at **06:00**  
**On generate:** Creates invoice, copies line items, sends email to client, updates `next_invoice_date` and `invoices_generated` counter.

### Team Members
- Roles: Admin, Sales Rep, Technician, Accountant, Support
- **"Invite New Member"** header action:
  1. Enter name, email, role, job title, phone
  2. System creates `User` account + `TeamMember` record
  3. Temp password generated
  4. Branded invite email sent with login URL + temp password
- **"Resend Invite"** per-row action — regenerates temp password and resends email

### Email Template
`resources/views/emails/team-member-invite.blade.php` — branded invite email with credentials

### Pipeline Kanban Page
`/useluminii/pipeline` — drag-and-drop (or quick-click) Kanban board for `ClientRequest` records.

### Database Tables
| Table | Key Columns |
|---|---|
| `expense_categories` | name, color, sort_order |
| `expenses` | expense_id, category_id, description, vendor, amount, expense_date, is_recurring, recurrence_type, receipt_path |
| `team_members` | user_id, role, job_title, phone, is_active, invited_at, joined_at |
| `recurring_invoices` | recurring_invoice_id, client_id, frequency, total_amount, status, start_date, end_date, next_invoice_date |
| `recurring_invoice_items` | recurring_invoice_id, description, quantity, unit_price, total |

### Seeder
`database/seeders/ExpenseCategorySeeder.php` — run with:
```bash
php artisan db:seed --class=ExpenseCategorySeeder
```

### Migrations
- `2026_04_17_000007_create_expenses_table` (includes `expense_categories`)
- `2026_04_18_000001_create_recurring_invoices_table`
- `2026_04_18_000002_add_sort_order_to_expense_categories`

---

## 8. Module 6 — Notifications, Activity Log & Dashboard Widgets

### Overview
A complete in-app notification system that auto-fires on key business events, a full activity audit trail, and enhanced dashboard widgets that highlight items needing attention.

### Filament Page
| Page | URL | Description |
|---|---|---|
| `NotificationsInbox` | `/useluminii/notifications-inbox` | Full notification inbox |

### Notification Types
| Type | Color | Icon | Example |
|---|---|---|---|
| `success` | Green | ✅ | Invoice paid, quote accepted |
| `warning` | Amber | ⚠️ | Quote declined, job cancelled |
| `danger` | Red | 🔴 | Invoice overdue |
| `info` | Blue | ℹ️ | New website lead, new quote |

### Auto-Fired Notifications (Model Observers)

| Observer | Event | Notification |
|---|---|---|
| `InvoiceObserver` | Invoice created | ℹ️ New invoice |
| `InvoiceObserver` | Status → Paid | ✅ Invoice paid |
| `InvoiceObserver` | Status → Overdue | 🔴 Invoice overdue |
| `QuoteObserver` | Quote created | ℹ️ New quote |
| `QuoteObserver` | Status → Accepted | ✅ Quote accepted |
| `QuoteObserver` | Status → Declined | ⚠️ Quote declined |
| `JobObserver` | Status → Completed | ✅ Job completed |
| `JobObserver` | Status → Cancelled | ⚠️ Job cancelled |
| `ContactFormObserver` | New submission | ℹ️ New website lead |

### Navigation Badge
The **Notifications** menu item shows a red badge with unread count — updates automatically.

### NotificationService (static helpers)
```php
use App\Services\NotificationService;

NotificationService::success('Title', 'Description', '/link');
NotificationService::warning('Title', 'Description', '/link');
NotificationService::danger('Title', 'Description', '/link');
NotificationService::info('Title', 'Description', '/link');
```

### Activity Log
Every significant action is recorded in `activity_logs`:
- Who did it (user)
- What action (created, updated, deleted, sent, paid)
- Which record (entity_type + entity_id)
- Description of what changed
- Optional metadata (JSON)

```php
// Usage anywhere in the app:
ActivityLog::record('paid', 'Invoice', $invoice->invoice_id, 'Invoice paid via PayPal');
```

### Dashboard Widgets

| Widget | Sort | Description |
|---|---|---|
| `CrmStatsOverview` | 1 | Total clients, active jobs, revenue, overdue invoices, open quotes |
| `RevenueChartWidget` | 2 | Line chart: Revenue vs Expenses (last 6 months) |
| `RecentActivityWidget` | 3 | Last 10 activity log entries |
| `BusinessActionWidget` | 4 | **"Needs Attention"** — overdue invoices, jobs without invoice, unassigned jobs, new requests |
| `UpcomingJobsWidget` | 5 | Table of active & scheduled jobs with quick links |

### Artisan Command
| Command | Schedule | Purpose |
|---|---|---|
| `crm:overdue-invoices` | Daily 07:00 | Marks past-due invoices as Overdue, fires danger notification |

### Database Tables
| Table | Key Columns |
|---|---|
| `notifications` | business_id, user_id, title, description, icon, link, type, is_read |
| `activity_logs` | business_id, user_id, action, entity_type, entity_id, description, meta (JSON) |

### Migration
- `2026_04_17_000009_create_notifications_activity_logs_table`

---

## 9. Module 7 — Job Calendar & PayPal Payments

### Overview
A full visual job scheduling calendar powered by FullCalendar v6, and online invoice payment via PayPal Orders API v2.

### Filament Page
| Page | URL | Description |
|---|---|---|
| `JobCalendar` | `/useluminii/job-calendar` | FullCalendar scheduling |

### Job Calendar Features
- **Views:** Month, Week, Day, List
- **Color coded** by job status (Indigo=New, Blue=Scheduled, Amber=InProgress, Green=Completed, Red=Cancelled)
- **Click any event** → popup shows client, assigned team member, status, location, start/end time
- **"Schedule a Job"** header action:
  - Select job from dropdown
  - Assign team member
  - Set job type (Once-off / Recurring)
  - Set start & end date/time
  - Set location
  - Add notes
  - Updates `scheduled_jobs` table AND updates `jobs.job_status`, `jobs.assigned_status`
- **Unscheduled jobs sidebar** — shows all jobs not yet on the calendar
- **This Week / Today** quick stats panel
- **Navigation:** `prev / next / today` buttons + view switcher

### Scheduling Data Model
```
jobs (1) ─── (many) scheduled_jobs
              ├── team_member_id
              ├── job_type (Once-off / Recurring)
              ├── scheduled_date
              ├── scheduled_end
              ├── repeats (Daily / Weekly / Monthly)
              ├── repeat_duration
              └── location
```

### PayPal Payment Integration

**Package:** `srmklive/paypal ^3.1` (Orders API v2)

**Flow:**
```
1. Client opens invoice via /client-hub/invoice/{token}
2. Clicks "Pay with PayPal" button
3. POST /client-hub/invoice/{token}/pay
   → Laravel creates PayPal Order (intent: CAPTURE)
   → paypal_order_id saved to invoice
   → Client redirected to PayPal
4. Client approves payment on PayPal
5. PayPal redirects to /client-hub/invoice/{token}/success?token={ORDER_ID}
6. Laravel calls capturePaymentOrder()
7. If COMPLETED:
   → invoice.status = 'Paid'
   → invoice.paid_at = now()
   → invoice.balance = 0
   → invoice.paypal_capture_id = saved
   → invoice.payment_method = 'PayPal'
   → ActivityLog entry created
   → CRM notification fired
8. Client sees success confirmation on invoice page
```

**Webhook:** `POST /webhooks/paypal` (backup confirmation — CSRF excluded)

### PayPal Configuration
| Setting | Value |
|---|---|
| Currency | USD (ZAR not supported by PayPal Checkout) |
| Mode | `sandbox` (test) or `live` (production) |
| Config file | `config/paypal.php` |

### Invoice PayPal Columns
| Column | Purpose |
|---|---|
| `paypal_order_id` | PayPal Order ID (from createOrder) |
| `paypal_capture_id` | PayPal Capture ID (from capturePaymentOrder) |
| `payment_method` | `EFT` / `PayPal` / `Cash` |

### Database Tables
| Table | Key Columns |
|---|---|
| `scheduled_jobs` | job_id, team_member_id, job_type, scheduled_date, scheduled_end, repeats, repeat_duration, location, status |
| `invoices` | (+ paypal_order_id, paypal_capture_id, payment_method) |

### Migrations
- `2026_04_18_000003_add_columns_to_scheduled_jobs`
- `2026_04_18_000005_replace_stripe_with_paypal_on_invoices`

---

## 10. Database Schema Reference

### Complete Table List
| # | Table | Module | Records |
|---|---|---|---|
| 1 | `users` | M1 | CRM user accounts |
| 2 | `business_setup` | M1 | Business profile & banking (1 row) |
| 3 | `business_clients` | M2 | Clients & leads |
| 4 | `business_services` | M1 | Service catalogue |
| 5 | `client_requests` | M2 | Service requests / enquiries |
| 6 | `contact_form_submissions` | M2 | Website contact form leads |
| 7 | `quotes` | M3 | Quote headers |
| 8 | `quote_items` | M3 | Quote line items |
| 9 | `jobs` | M4 | Job records |
| 10 | `job_items` | M4 | Job line items |
| 11 | `invoices` | M4 | Invoice headers |
| 12 | `invoice_items` | M4 | Invoice line items |
| 13 | `expense_categories` | M5 | Expense category lookup |
| 14 | `expenses` | M5 | Business expense records |
| 15 | `team_members` | M5 | Team member profiles |
| 16 | `recurring_invoices` | M5 | Recurring invoice schedules |
| 17 | `recurring_invoice_items` | M5 | Recurring invoice line items |
| 18 | `notifications` | M6 | In-app notification records |
| 19 | `activity_logs` | M6 | Full audit trail |
| 20 | `scheduled_jobs` | M7 | Job calendar entries |

---

## 11. Scheduled Commands (Cron)

Configured in `bootstrap/app.php` via `->withSchedule()`.

| Command | Schedule | What it does |
|---|---|---|
| `crm:recurring-invoices` | Daily **06:00** | Checks all Active recurring invoice schedules, generates real invoices for those due, sends client emails, updates `next_invoice_date` |
| `crm:overdue-invoices` | Daily **07:00** | Finds all `Sent`/`PartiallyPaid` invoices past their `due_date`, marks them `Overdue`, fires a danger CRM notification |

### Setting up the Cron (Production)
Add this single cron entry to your server's crontab:
```bash
* * * * * cd /path/to/shifttech_new_site && php artisan schedule:run >> /dev/null 2>&1
```

### Run manually
```bash
php artisan crm:recurring-invoices
php artisan crm:overdue-invoices
```

---

## 12. Email Templates

All email templates are in `resources/views/emails/` and use inline Tailwind/CSS for compatibility.

| Template | Mail Class | Triggered by |
|---|---|---|
| `emails/quote.blade.php` | `QuoteMail` | Send Quote action in `QuoteResource` |
| `emails/invoice.blade.php` | `InvoiceMail` | Send Invoice action in `InvoiceResource` + recurring invoices |
| `emails/team-member-invite.blade.php` | `TeamMemberInvite` | Invite New Member + Resend Invite actions |
| `emails/contact-form.blade.php` | `ContactFormNotification` | Website contact form submission |

### Mail Configuration (`.env`)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com       # or your SMTP host
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@shifttechgs.com
MAIL_FROM_NAME="ShiftTech"
```

---

## 13. Public Routes (Client Hub)

These routes require **no authentication** — secured by unique token in the URL.

| Method | URL | Action |
|---|---|---|
| GET | `/client-hub/quote/{token}` | View quote (client portal) |
| POST | `/client-hub/quote/{token}/accept` | Accept quote |
| POST | `/client-hub/quote/{token}/decline` | Decline quote |
| GET | `/client-hub/invoice/{token}` | View invoice (client portal) |
| GET | `/client-hub/invoice/{token}/pay` | Initiate PayPal checkout |
| GET | `/client-hub/invoice/{token}/success` | PayPal success callback (capture) |
| POST | `/webhooks/paypal` | PayPal webhook (IPN backup) |

### Token Security
- **Quote token:** `accepted_token` — UUID, set on quote creation
- **Invoice token:** `view_token` — UUID, set on invoice creation
- Tokens are single-use for actions (accept/decline) and cannot be guessed

---

## 14. Environment Variables

### Required
```env
APP_NAME="ShiftTech CRM"
APP_URL=https://shifttechgs.com
APP_ENV=production
APP_KEY=base64:...

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shifttech_crm
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@shifttechgs.com
MAIL_FROM_NAME="ShiftTech"

# PayPal
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_CLIENT_SECRET=your_paypal_client_secret
PAYPAL_MODE=live     # sandbox | live
```

### Optional
```env
# Google reCAPTCHA (contact form anti-spam)
RECAPTCHA_SITE_KEY=
RECAPTCHA_SECRET_KEY=

# WhatsApp notifications (if enabled)
WHATSAPP_API_KEY=
WHATSAPP_PHONE_ID=
```

---

## 15. Deployment Checklist

### Before going live
- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Run `php artisan key:generate`
- [ ] Set all database credentials
- [ ] Configure SMTP mail settings and test email delivery
- [ ] Set `PAYPAL_MODE=live` and add real PayPal credentials
- [ ] Register PayPal webhook URL: `https://shifttechgs.com/webhooks/paypal`
- [ ] Run `php artisan migrate --force`
- [ ] Run `php artisan db:seed --force` (seeds admin user + expense categories + services)
- [ ] Run `php artisan storage:link` (for receipt file uploads)
- [ ] Run `php artisan optimize` (cache config, routes, views)
- [ ] Set up cron job for `php artisan schedule:run`
- [ ] Change default admin password after first login

### Useful Artisan Commands
```bash
php artisan migrate --force                        # Run pending migrations
php artisan db:seed --force                        # Seed default data
php artisan db:seed --class=ExpenseCategorySeeder  # Re-seed expense categories
php artisan storage:link                           # Link storage for file uploads
php artisan optimize                               # Cache everything for production
php artisan optimize:clear                         # Clear all caches
php artisan route:list --path=useluminii           # List all CRM routes
php artisan schedule:list                          # Show scheduled commands
php artisan crm:recurring-invoices                 # Run manually
php artisan crm:overdue-invoices                   # Run manually
```

---

## 16. Default Login Credentials

> ⚠️ **Change these immediately after first login.**

| Field | Value |
|---|---|
| **URL** | `https://shifttechgs.com/useluminii` |
| **Email** | `admin@shifttechgs.com` |
| **Password** | `ShiftTech@2025!` |
| **Role** | SuperAdmin |

---

## Changelog

| Date | Module | Change |
|---|---|---|
| 2026-04-17 | M1–M4 | Initial migration from Angular/C# — Auth, Clients, Quotes, Jobs, Invoices |
| 2026-04-17 | M5 | Expenses, Pipeline Kanban, Team Members, Recurring Invoices |
| 2026-04-18 | M6 | Notifications system, Activity Log observers, enhanced dashboard widgets |
| 2026-04-18 | M7 | Job Calendar (FullCalendar v6), PayPal Checkout (replaced Stripe — not supported in SA) |
| 2026-04-18 | All | **VAT removed** — ShiftTech not yet VAT registered. Tax rate set to 0 across all quotes, invoices, PDF templates, and client hub views. Will be re-enabled upon SARS VAT registration. |

---

## ⚠️ VAT Status Note

> **ShiftTech General Solutions is not currently VAT registered with SARS.**

All quotes and invoices are issued **excluding VAT**. The following changes reflect this:

- `tax_rate` on all line items defaults to `0` and is **hidden** from forms and PDFs
- `total_tax` is always `0` and not displayed on client-facing documents
- PDF invoice title changed from **"TAX INVOICE"** to **"INVOICE"**
- VAT row removed from all quote/invoice totals sections (Filament forms, client hub views, PDFs, emails)
- `business_setup.default_tax_rate` set to `0`

**When ShiftTech becomes VAT registered:**
1. Update `default_tax_rate` to `15` in Business Settings (`/useluminii/business-settings`)
2. Re-add `tax_rate` field to `QuoteResource` and `InvoiceResource` line item repeaters
3. Restore `total_tax` to totals sections in both resources
4. Restore VAT row in PDF templates (`resources/views/pdf/invoice.blade.php`, `quote.blade.php`)
5. Change PDF invoice title back to "TAX INVOICE"
6. Update `recalculateTotals()` in `Quote` and `Invoice` models to include `$totalTax` calculation

---

*Built by ShiftTech · Powered by Laravel + Filament*





