# Luminii CRM — Design System

Stripe-level design language. Every decision made here should feel calm,
precise, and premium. When in doubt: add whitespace, reduce color, simplify.

---

## 1. Design Philosophy

| Principle | What it means in practice |
|-----------|--------------------------|
| **Restraint** | One accent color. No decorative elements. Remove, don't add. |
| **Whitespace** | Breathe. Generous padding creates premium feel. |
| **Hierarchy** | Size and weight communicate importance — not color. |
| **Consistency** | Same radius, same shadow, same spacing everywhere. |
| **Speed** | Transitions 100–200ms. Fast enough to feel instant, slow enough to feel smooth. |

---

## 2. Color Tokens

All defined as CSS custom properties in `public/css/crm-design-system.css`.

### Sidebar
| Token | Value | Usage |
|-------|-------|-------|
| `--crm-sidebar` | `#0a1628` | Sidebar background |
| `--crm-sidebar-border` | `rgba(255,255,255,0.07)` | Sidebar dividers |
| `--crm-sidebar-text` | `rgba(255,255,255,0.58)` | Inactive nav labels |
| `--crm-sidebar-active` | `rgba(255,255,255,0.11)` | Active nav item bg |
| `--crm-sidebar-hover` | `rgba(255,255,255,0.06)` | Nav item hover bg |

### Surfaces
| Token | Value | Usage |
|-------|-------|-------|
| `--crm-bg` | `#f4f6f9` | Page/body background |
| `--crm-surface` | `#ffffff` | Cards, widgets, panels |
| `--crm-border` | `#e4e9f0` | Component borders |
| `--crm-border-subtle` | `#eef1f6` | Table row dividers, internal separators |

### Typography
| Token | Value | Usage |
|-------|-------|-------|
| `--crm-text-1` | `#0d1b2e` | Primary text, headings, values |
| `--crm-text-2` | `#5a6a7e` | Secondary text, labels, descriptions |
| `--crm-text-3` | `#8898aa` | Muted/placeholder text, metadata |

### Brand & Status
| Token | Value | Usage |
|-------|-------|-------|
| `--crm-accent` | `#635bff` | Focus rings on inputs only |
| `--crm-accent-hover` | `#5147e8` | — |
| `--crm-yellow` | `#FFD60A` | Active nav icon, card hover accent, logo wordmark |
| `--crm-btn-primary` | `#0a1628` | Primary button background (sidebar navy) |
| `--crm-btn-primary-hover` | `#0f2040` | Primary button hover |
| Danger | `Rose` (Filament) | Errors, overdue, critical |
| Warning | `Amber` (Filament) | Attention needed, pending |
| Success | `Emerald` (Filament) | Completed, paid, healthy |
| Info | `Blue` (Filament) | Informational, scheduled |

### Shadows
| Token | Value | Usage |
|-------|-------|-------|
| `--crm-shadow-xs` | `0 1px 2px rgba(13,27,46,0.04)` | Default card/widget shadow |
| `--crm-shadow-sm` | `0 1px 3px + 0 1px 2px rgba(...)` | Slightly elevated components |
| `--crm-shadow-md` | `0 4px 16px + 0 2px 4px rgba(...)` | Dropdowns, hover states |
| `--crm-shadow-lg` | `0 8px 32px + 0 4px 8px rgba(...)` | Modals, floating panels |

---

## 3. Typography

**Font:** Inter (loaded via Google Fonts in AdminPanelProvider)

| Role | Size | Weight | Letter Spacing | Usage |
|------|------|--------|----------------|-------|
| Page heading | `1.3125rem` / ~21px | `700` | `-0.03em` | Page titles |
| Section heading | `0.9375rem` / 15px | `620` | `-0.02em` | Widget/card titles |
| Stat value | `2.125rem` / 34px | `680` | `-0.04em` | KPI numbers on dashboard |
| Body / table cell | `0.875rem` / 14px | `400` | — | General content |
| Label | `0.8125rem` / 13px | `550` | `0.005em` | Form labels, table headers |
| Caption / muted | `0.8125rem` / 13px | `400` | — | Descriptions, metadata |
| Table header | `0.75rem` / 12px | `600` | `0.05em` | Uppercase column headers |
| Badge | `0.6875rem` / 11px | `600` | `0.025em` | Status badges |
| Sidebar group label | `0.6875rem` / 11px | `600` | `0.07em` | Nav group headings (uppercase) |
| Sidebar nav item | `0.8438rem` / ~13.5px | `450` | — | Inactive nav items |

---

## 4. Spacing System (8px grid)

| Step | Value | Usage |
|------|-------|-------|
| 1 | `4px` | Icon gaps, micro spacing |
| 2 | `8px` | Inline gaps, badge padding |
| 3 | `12px` | Sidebar nav item padding |
| 4 | `16px` | Card internal gaps |
| 5 | `20px` | Widget/section padding (compact) |
| 6 | `24px` | Card/section padding (standard) |
| 7 | `32px` | Page section gaps |
| 8 | `48px` | Empty state padding |

---

## 5. Border Radius

| Token | Value | Usage |
|-------|-------|-------|
| `--crm-radius-sm` | `6px` | Buttons, inputs, badges, nav items |
| `--crm-radius` | `8px` | Dropdowns, small cards |
| `--crm-radius-lg` | `12px` | Stat cards, tables, main widgets |
| `--crm-radius-xl` | `16px` | Modals, large panels |

---

## 6. Component Reference

### Sidebar
- Background: `--crm-sidebar` (`#0a1628`)
- Logo: `luminii_dark.png` with `mix-blend-mode: screen` (removes baked-in bg)
- Nav groups: `0.6875rem` uppercase labels, `rgba(255,255,255,0.32)` color
- Nav items: `7px 8px` padding, `6px` radius, 120ms hover transition
- Active item: `rgba(255,255,255,0.11)` bg + white text + accent-colored icon
- Scrollbar: `4px` width, `rgba(255,255,255,0.12)` thumb

### Stat Overview Cards (`.fi-wi-stats-overview-stat`)
- Background: white surface with `1px var(--crm-border)` border
- Shadow: `--crm-shadow-xs` default → `--crm-shadow-md` on hover
- Hover: `translateY(-1px)` lift + deeper shadow
- Label: `0.8125rem`, `--crm-text-2`
- Value: `2.125rem`, weight `680`, `--crm-text-1`, tabular nums
- Top accent line: `2px` gradient fades in on hover

### Tables (`.fi-ta-*`)
- Container: `12px` radius, `--crm-border`, `--crm-shadow-xs`
- Header bg: `#fafbfd`, text uppercase `0.75rem`
- Row min-height: `52px`
- Row divider: `--crm-border-subtle` (not `--crm-border` — lighter)
- Row hover: `#f8f9fc`

### Buttons (`.fi-btn`)
- Radius: `6px`
- Font: `0.875rem`, weight `500`
- **Primary: `#0a1628` (sidebar navy)** — consistent with the navigation, not the purple accent
- Primary hover: `#0f2040` + `rgba(10,22,40,0.30)` depth shadow
- Gray/outline hover: `--crm-bg` fill + `#c4cdd8` border
- Transition: `150ms cubic-bezier(0.16,1,0.3,1)`

### Form Inputs
- Border: `--crm-border`
- Focus: border → `--crm-accent` + `0 0 0 3px rgba(99,91,255,0.10)` ring
- Font: `0.875rem`, `--crm-text-1`
- Placeholder: `--crm-text-3`

### Modals
- Radius: `16px`
- Footer background: `#fafbfd` (slightly off-white, not full white)
- Shadow: `--crm-shadow-lg`

---

## 7. CSS File Location & Loading

**File:** `public/css/crm-design-system.css`

**How it loads:** Injected via `PanelsRenderHook::STYLES_AFTER` in
`app/Providers/Filament/AdminPanelProvider.php`. This ensures the stylesheet
loads **after** all Filament styles, so overrides work without specificity hacks.

```php
->renderHook(
    PanelsRenderHook::STYLES_AFTER,
    fn (): HtmlString => new HtmlString(
        '<link rel="stylesheet" href="' . asset('css/crm-design-system.css') . '?v=' . filemtime(public_path('css/crm-design-system.css')) . '" />'
    )
)
```

The `?v=` cache-buster uses the file's modification timestamp — no manual
version bumping needed.

---

## 8. Adding New Styles

**Rule:** Always add to `crm-design-system.css`, never inline styles on
components unless it's a one-off exception (like the logo blend mode).

**Override strategy:**
- Target Filament's `fi-*` CSS classes
- Use `!important` only when overriding a Tailwind utility class
- Group rules under their section comment (`/* SIDEBAR */`, `/* TABLES */`, etc.)

**When adding a new component:**
1. Identify its Filament CSS class (inspect → look for `fi-*`)
2. Add a new section in the CSS file under the appropriate heading
3. Document the class name and usage in this file under Section 6

---

## 9. Logo Usage

The sidebar logo is built as **pure HTML/CSS** — not an image file. This gives
pixel-perfect rendering at any resolution, full color control, and no dependency
on PNG artifacts or blend mode tricks.

**Current implementation** (`resources/views/filament/brand.blade.php`):

```html
<div style="display:flex;align-items:center;gap:0;user-select:none;line-height:1;">
    <!-- "use" — muted white, regular weight -->
    <span style="font-family:'Inter',sans-serif;font-size:1.1875rem;font-weight:400;
                 color:rgba(255,255,255,0.52);letter-spacing:-0.025em;">use</span>
    <!-- "Luminii" — full white, semibold -->
    <span style="font-family:'Inter',sans-serif;font-size:1.1875rem;font-weight:650;
                 color:#ffffff;letter-spacing:-0.03em;">Luminii</span>
    <!-- Yellow .com badge -->
    <span style="display:inline-flex;align-items:center;justify-content:center;
                 width:22px;height:22px;background:#FFD60A;border-radius:50%;
                 margin-left:4px;flex-shrink:0;">
        <span style="font-family:'Inter',sans-serif;font-size:6.5px;font-weight:800;
                     color:#0a1628;letter-spacing:-0.01em;line-height:1;">.com</span>
    </span>
</div>
```

**Design decisions:**
- `use` is weight `400` at `rgba(255,255,255,0.50)` — intentionally quiet so `Luminii` is the anchor
- `Luminii` is weight `700` in `#FFD60A` (brand yellow) — punches against the dark navy, creates instant brand recognition
- `.com` dot is a frosted circle (`rgba(255,255,255,0.12)` fill + subtle border) with muted white text — present but not competing
- Navy sidebar + yellow wordmark = the full brand palette in a single mark
- Uses Inter (already loaded by the panel) — no extra font requests

**PNG files are kept as fallbacks:**

| File | Background | If ever needed for |
|------|-----------|--------|
| `luminii_dark.png` | Baked-in navy | Email templates, PDFs, external use |
| `luminii_light.png` | Transparent, dark text | Light-bg marketing pages |

---

## 10. What NOT to Do

- Do not use `border-radius` values outside the token set
- Do not use more than one accent color per page
- Do not use `box-shadow` values not in the token set
- Do not add animations longer than `300ms`
- Do not use `text-transform: uppercase` for body text — only for metadata/labels
- Do not add borders to elements that already communicate structure via whitespace
- Do not use pure black (`#000000`) for text — use `--crm-text-1` (`#0d1b2e`)
- Do not add gradient fills to UI surfaces — reserved for accent lines only
