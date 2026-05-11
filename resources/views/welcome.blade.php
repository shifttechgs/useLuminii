@extends("layouts.app")

@section('title', 'useLuminii — The Operating System for Service Businesses')
@section('description', 'Stop losing leads. Start closing jobs. useLuminii captures enquiries, sends quotes, manages jobs, and gets you paid — all automated. One flat price. Live in 48 hours.')
@section('keywords', 'service business software, CRM for contractors, job management, quote automation, invoicing, AI receptionist, South Africa')
@section('og_title', 'useLuminii — Built for High-Performing Service Businesses')
@section('og_description', 'From first enquiry to final payment — fully automated. One system. One price. Unlimited team members.')

@push('head-styles')
<style>
/* ================================================================
   PRECIS-INSPIRED DESIGN SYSTEM — useLuminii
   Fonts: Manrope (display) + Inter (body)
   Palette: Black + Teal accent on White/Light backgrounds
   ================================================================ */

@font-face {
    font-family: "Manrope";
    src: url("{{ asset('useluminii/assets/fonts/precis/UXO4O7K2G3HI3D2VKD7UXVJVJD26P4BQ.woff2') }}") format("woff2");
    font-weight: 400; font-style: normal; font-display: swap;
}
@font-face {
    font-family: "Manrope";
    src: url("{{ asset('useluminii/assets/fonts/precis/CIM4KQCLZSMMLWPVH25IDDSTY4ENPHEY.woff2') }}") format("woff2");
    font-weight: 500; font-style: normal; font-display: swap;
}
@font-face {
    font-family: "Manrope";
    src: url("{{ asset('useluminii/assets/fonts/precis/JNU3GNMUBPWW6V6JTED3S27XL5HN7NM5.woff2') }}") format("woff2");
    font-weight: 600; font-style: normal; font-display: swap;
}
@font-face {
    font-family: "Manrope";
    src: url("{{ asset('useluminii/assets/fonts/precis/6P4FPMFQH7CCC7RZ4UU4NKSGJ2RLF7V5.woff2') }}") format("woff2");
    font-weight: 700; font-style: normal; font-display: swap;
}
@font-face {
    font-family: "Manrope";
    src: url("{{ asset('useluminii/assets/fonts/precis/K4ZMLVLHYIFVTTTWGVOTVGOFUUX7NVGI.woff2') }}") format("woff2");
    font-weight: 800; font-style: normal; font-display: swap;
}
@font-face {
    font-family: "Clash Grotesk";
    src: url("{{ asset('useluminii/assets/fonts/precis/KN7DX4F6PXB74R6L2K2Y4NH3CB7FC53Q.woff2') }}") format("woff2");
    font-weight: 600; font-style: normal; font-display: swap;
}
@font-face {
    font-family: "PrecisInter";
    src: url("{{ asset('useluminii/assets/fonts/precis/GrgcKwrN6d3Uz8EwcLHZxwEfC4.woff2') }}") format("woff2");
    font-weight: 400; font-style: normal; font-display: swap;
}
@font-face {
    font-family: "PrecisInter";
    src: url("{{ asset('useluminii/assets/fonts/precis/syRNPWzAMIrcJ3wIlPIP43KjQs.woff2') }}") format("woff2");
    font-weight: 700; font-style: normal; font-display: swap;
}

/* ── TOKENS ── */
:root {
    --ink: #0A0A0A;
    --ink-2: #111111;
    --ink-3: #1C1C1C;
    --muted: #535253;
    --muted-2: #8A8A8A;
    --border: #E5E5E5;
    --border-2: #D0D0D0;
    --bg: #FFFFFF;
    --bg-2: #F7F7F7;
    --bg-3: #F2F2F2;
    --teal: #00E5A0;
    --teal-dark: #00C78A;
    --teal-bg: rgba(0, 229, 160, 0.08);
    --teal-border: rgba(0, 229, 160, 0.25);
    --font-display: "Manrope", "Clash Grotesk", system-ui, sans-serif;
    --font-body: "PrecisInter", "Inter", system-ui, sans-serif;
    --r: 12px;
    --r-lg: 20px;
    --r-pill: 999px;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
    --shadow: 0 4px 16px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.04);
    --shadow-lg: 0 20px 60px rgba(0,0,0,0.12), 0 4px 16px rgba(0,0,0,0.06);
    --shadow-teal: 0 0 40px rgba(0,229,160,0.2);
}

/* ── RESET ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.lp { font-family: var(--font-body); color: var(--ink); background: var(--bg); overflow-x: hidden; }
.lp *, .lp *::before, .lp *::after { font-family: inherit; }
.lp a { text-decoration: none; color: inherit; }
.lp img { max-width: 100%; height: auto; display: block; }
.lp ul { list-style: none; }

.lp-wrap {
    max-width: 1160px;
    margin: 0 auto;
    padding: 0 28px;
}
@media (max-width: 640px) { .lp-wrap { padding: 0 20px; } }

/* ── SECTION BASE ── */
.lp-section {
    padding: 112px 0;
}
@media (max-width: 768px) { .lp-section { padding: 72px 0; } }

.lp-section--gray { background: var(--bg-2); }
.lp-section--dark { background: var(--ink-2); }

.lp-section__label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: var(--font-display);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--teal);
    margin-bottom: 20px;
}
.lp-section__label::before {
    content: '';
    width: 18px;
    height: 2px;
    background: var(--teal);
    border-radius: 2px;
    flex-shrink: 0;
}

.lp-section__h2 {
    font-family: var(--font-display);
    font-size: clamp(32px, 4vw, 52px);
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.03em;
    color: var(--ink);
    margin-bottom: 16px;
}
.lp-section--dark .lp-section__h2 { color: #fff; }

.lp-section__sub {
    font-size: 17px;
    line-height: 1.65;
    color: var(--muted);
    max-width: 520px;
}
.lp-section--dark .lp-section__sub { color: rgba(255,255,255,0.6); }

.lp-section__header { margin-bottom: 64px; }
.lp-section__header--center { text-align: center; }
.lp-section__header--center .lp-section__sub { margin: 0 auto; }
.lp-section__header--center .lp-section__label { display: inline-flex; }

/* ── BUTTONS ── */
.lp-btn {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    font-family: var(--font-display);
    font-size: 15px;
    font-weight: 700;
    border-radius: var(--r-pill);
    padding: 14px 28px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    border: 2px solid transparent;
    white-space: nowrap;
}

.lp-btn--primary {
    background: var(--teal);
    color: var(--ink);
    border-color: var(--teal);
}
.lp-btn--primary:hover {
    background: var(--teal-dark);
    border-color: var(--teal-dark);
    color: var(--ink);
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(0,229,160,0.35);
}

.lp-btn--dark {
    background: var(--ink);
    color: #fff;
    border-color: var(--ink);
}
.lp-btn--dark:hover {
    background: var(--ink-3);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: var(--shadow);
}

.lp-btn--ghost {
    background: transparent;
    color: rgba(255,255,255,0.8);
    border-color: rgba(255,255,255,0.2);
}
.lp-btn--ghost:hover {
    background: rgba(255,255,255,0.08);
    color: #fff;
    border-color: rgba(255,255,255,0.4);
}

.lp-btn--outline {
    background: transparent;
    color: var(--ink);
    border-color: var(--border-2);
}
.lp-btn--outline:hover {
    border-color: var(--ink);
    background: var(--bg-2);
}

.lp-btn--sm { padding: 10px 20px; font-size: 13px; }
.lp-btn--lg { padding: 17px 36px; font-size: 16px; }

/* ── HERO ── */
.lp-hero {
    background: #F5F5F5;
    position: relative;
    overflow: hidden;
    padding: 160px 0 100px;
    text-align: center;
}

.lp-hero__grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(0,0,0,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,0,0,0.03) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none;
}

.lp-hero__glow {
    position: absolute;
    top: -200px;
    left: 50%;
    transform: translateX(-50%);
    width: 800px;
    height: 800px;
    background: radial-gradient(circle, rgba(0,229,160,0.1) 0%, transparent 60%);
    pointer-events: none;
}

.lp-hero__inner {
    position: relative;
    z-index: 2;
}

.lp-hero__badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(0,229,160,0.1);
    border: 1px solid rgba(0,229,160,0.3);
    border-radius: var(--r-pill);
    padding: 7px 16px 7px 10px;
    margin-bottom: 36px;
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 600;
    color: var(--teal-dark);
}

.lp-hero__badge-dot {
    width: 7px;
    height: 7px;
    background: var(--teal);
    border-radius: 50%;
    animation: lp-pulse 2.2s ease-in-out infinite;
    flex-shrink: 0;
}

@keyframes lp-pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.8); }
}

.lp-hero__h1 {
    font-family: var(--font-display);
    font-size: clamp(36px, 5.5vw, 64px);
    font-weight: 800;
    line-height: 1.08;
    letter-spacing: -0.04em;
    color: var(--ink);
    margin-bottom: 24px;
    max-width: 780px;
    margin-left: auto;
    margin-right: auto;
}

.lp-hero__h1 em {
    font-style: normal;
    background: linear-gradient(135deg, var(--teal) 0%, #5EEAD4 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.lp-hero__sub {
    font-size: clamp(16px, 2.2vw, 19px);
    line-height: 1.65;
    color: var(--muted);
    max-width: 540px;
    margin: 0 auto 44px;
}

.lp-hero__ctas {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 60px;
}

.lp-hero__trust {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 32px;
    flex-wrap: wrap;
    padding-top: 28px;
    border-top: 1px solid var(--border);
    margin-bottom: 72px;
}

.lp-hero__trust-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
}
.lp-hero__trust-item i {
    font-size: 16px;
    color: var(--teal);
}

.lp-avatars {
    display: flex;
    align-items: center;
}
.lp-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 2px solid rgb(240, 240, 240);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 800;
    font-family: var(--font-display);
    color: var(--ink);
    margin-left: -8px;
    flex-shrink: 0;
}
.lp-avatar:first-child { margin-left: 0; }

/* Dashboard mockup */
.lp-hero__dashboard {
    max-width: 780px;
    margin: 0 auto;
    background: #1A1A1A;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: var(--r-lg);
    overflow: hidden;
    box-shadow: 0 40px 120px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.04);
}

.lp-dash__bar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    background: #141414;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.lp-dash__dots { display: flex; gap: 6px; }
.lp-dash__dot {
    width: 10px; height: 10px; border-radius: 50%;
}
.lp-dash__dot:nth-child(1) { background: #FF5F57; }
.lp-dash__dot:nth-child(2) { background: #FEBC2E; }
.lp-dash__dot:nth-child(3) { background: #28C840; }
.lp-dash__title {
    flex: 1;
    text-align: center;
    font-size: 12px;
    font-weight: 600;
    color: rgba(255,255,255,0.3);
    font-family: var(--font-display);
    letter-spacing: 0.02em;
}
.lp-dash__badge {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 700;
    color: var(--teal);
    font-family: var(--font-display);
}
.lp-dash__badge::before {
    content: '';
    width: 6px;
    height: 6px;
    background: var(--teal);
    border-radius: 50%;
    animation: lp-pulse 2s ease infinite;
}

.lp-dash__body {
    padding: 20px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}
@media (max-width: 600px) {
    .lp-dash__body { grid-template-columns: repeat(2, 1fr); }
}

.lp-dash__card {
    background: #222222;
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 10px;
    padding: 14px;
}
.lp-dash__card-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.35);
    font-family: var(--font-display);
    margin-bottom: 8px;
}
.lp-dash__card-val {
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    font-family: var(--font-display);
    line-height: 1;
    margin-bottom: 6px;
}
.lp-dash__card-val span { font-size: 13px; font-weight: 600; opacity: 0.5; }
.lp-dash__card-sub {
    font-size: 11px;
    font-weight: 600;
    font-family: var(--font-display);
}
.lp-dash__card-sub.up { color: var(--teal); }
.lp-dash__card-sub.neu { color: rgba(255,255,255,0.4); }

.lp-dash__activity {
    margin: 0 20px 20px;
    background: #1E1E1E;
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 10px;
    overflow: hidden;
}
.lp-dash__activity-head {
    padding: 12px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    font-size: 12px;
    font-weight: 700;
    color: rgba(255,255,255,0.5);
    font-family: var(--font-display);
    letter-spacing: 0.05em;
    text-transform: uppercase;
}
.lp-dash__row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.03);
}
.lp-dash__row:last-child { border-bottom: none; }
.lp-dash__row-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    flex-shrink: 0;
}
.lp-dash__row-icon.teal { background: rgba(0,229,160,0.15); color: var(--teal); }
.lp-dash__row-icon.amber { background: rgba(251,191,36,0.15); color: #FBbf24; }
.lp-dash__row-icon.blue { background: rgba(99,102,241,0.15); color: #818CF8; }
.lp-dash__row-text { flex: 1; }
.lp-dash__row-name {
    font-size: 12px;
    font-weight: 600;
    color: rgba(255,255,255,0.8);
    font-family: var(--font-display);
}
.lp-dash__row-detail {
    font-size: 11px;
    color: rgba(255,255,255,0.3);
    font-family: var(--font-body);
    margin-top: 2px;
}
.lp-dash__row-amt {
    font-size: 13px;
    font-weight: 700;
    color: var(--teal);
    font-family: var(--font-display);
}

/* ── TICKER ── */
.lp-ticker {
    background: var(--bg);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 24px 0;
    display: flex;
    align-items: center;
    gap: 0;
    overflow: hidden;
}

.lp-ticker__label {
    flex-shrink: 0;
    padding: 0 28px;
    font-family: var(--font-display);
    font-size: 14px;
    font-weight: 700;
    letter-spacing: -0.01em;
    text-transform: none;
    color: var(--ink);
    white-space: nowrap;
}

.lp-ticker__wrap {
    position: relative;
    overflow: hidden;
    flex: 1;
    min-width: 0;
}
.lp-ticker__wrap::after {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    right: 0;
    width: 140px;
    z-index: 2;
    pointer-events: none;
    background: linear-gradient(270deg, var(--bg) 0%, transparent 100%);
}

.lp-ticker__track {
    display: flex;
    gap: 0;
    animation: lp-ticker 45s linear infinite;
    width: max-content;
}

.lp-ticker__track:hover { animation-play-state: paused; }

@keyframes lp-ticker {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.lp-ticker__item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0 36px;
    font-family: var(--font-display);
    font-size: 15px;
    font-weight: 700;
    color: var(--ink-3);
    white-space: nowrap;
}
.lp-ticker__item i {
    font-size: 18px;
    color: var(--teal);
}
.lp-ticker__item::after {
    content: '·';
    color: var(--border-2);
    font-size: 20px;
    margin-left: 12px;
}

/* ── SERVICE CARDS ── */
.lp-services__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2px;
    background: var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
}
@media (max-width: 900px) {
    .lp-services__grid { grid-template-columns: 1fr; }
}

.lp-service {
    background: var(--bg);
    padding: 44px 36px;
    transition: background 0.2s;
}
.lp-service:hover { background: var(--bg-2); }

.lp-service__icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: var(--teal);
    background: var(--teal-bg);
    border: 1px solid var(--teal-border);
    margin-bottom: 24px;
}

.lp-service__title {
    font-family: var(--font-display);
    font-size: 20px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 10px;
    letter-spacing: -0.02em;
}

.lp-service__desc {
    font-size: 14px;
    line-height: 1.7;
    color: var(--muted);
    margin-bottom: 28px;
}

.lp-service__features {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.lp-service__feature {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 600;
    color: var(--ink-3);
    font-family: var(--font-display);
}
.lp-service__feature::before {
    content: '';
    width: 6px;
    height: 6px;
    background: var(--teal);
    border-radius: 50%;
    flex-shrink: 0;
}

/* ── HOW IT WORKS ── */

/*
 * 4-cell grid: 2 columns × 2 rows
 * Row 1: [empty]  [intro: + symbol, heading, subtext, button]
 * Row 2: [metrics][steps]
 * This aligns the cards' top edge with the steps' top edge (just below the button).
 */
.lp-hiw__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto auto;
    column-gap: 80px;
    row-gap: 0;
    align-items: start;
}
@media (max-width: 900px) {
    .lp-hiw__grid {
        grid-template-columns: 1fr;
        column-gap: 0;
        row-gap: 48px;
    }
    /* On mobile collapse empty top-left cell */
    .lp-hiw__grid > div:first-child { display: none; }
}

/* Row 1, right: intro block */
.lp-hiw__intro { padding-bottom: 44px; }

/* Row 2, left: metrics — sticky within the section */
.lp-hiw__left { position: sticky; top: 120px; }
@media (max-width: 900px) { .lp-hiw__left { position: static; } }

/* Row 2, right: steps (no extra margin — cards start here too) */
.lp-hiw__right { }

/* Metrics grid */
.lp-hiw__metrics {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.lp-hiw__metric {
    background: var(--bg-2);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 22px 20px 20px;
    display: flex;
    flex-direction: column;
}
.lp-hiw__metric--wide { grid-column: span 2; }

.lp-hiw__metric-val {
    font-family: var(--font-display);
    font-size: 36px;
    font-weight: 800;
    letter-spacing: -0.04em;
    color: var(--ink);
    line-height: 1;
    margin-bottom: 8px;
}
.lp-hiw__metric-label {
    font-family: var(--font-display);
    font-size: 14px;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 10px;
}
.lp-hiw__metric-sub {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.55;
}

/* Intro elements */
.lp-hiw__plus {
    font-size: 18px;
    font-weight: 300;
    color: var(--muted-2);
    line-height: 1;
    margin-bottom: 16px;
    font-family: var(--font-display);
}
.lp-hiw__h2 {
    font-family: var(--font-display);
    font-size: clamp(32px, 4vw, 52px);
    font-weight: 800;
    line-height: 1.08;
    letter-spacing: -0.035em;
    color: var(--ink);
    margin-bottom: 16px;
}
.lp-hiw__h2-muted { color: var(--muted); font-weight: 700; }

.lp-hiw__btn {
    display: inline-flex;
    align-items: center;
    font-family: var(--font-display);
    font-size: 15px;
    font-weight: 700;
    background: var(--ink);
    color: #fff !important;
    border-radius: 10px;
    padding: 14px 26px;
    margin-top: 28px;
    text-decoration: none;
    transition: background 0.2s, transform 0.15s;
    border: none;
    cursor: pointer;
}
.lp-hiw__btn:hover { background: var(--ink-3); transform: translateY(-1px); }

/* Steps */
.lp-hiw__steps {
    display: flex;
    flex-direction: column;
}

/* Each step: connector column (circle + line) sits left of the content */
.lp-hiw__step {
    display: flex;
    align-items: stretch; /* lets connector column fill full step height */
    gap: 20px;
}

/* Connector column: circle stacked above the line */
.lp-hiw__step-connector {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-shrink: 0;
}

/* Dashed circle badge */
.lp-hiw__step-num {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1.5px dashed #d5d5d5;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
}

/* Solid dark line — flex:1 makes it fill the remaining connector height */
.lp-hiw__step-line {
    flex: 1;
    width: 1.5px;
    background: #3a3a3a;
    margin: 5px 0;
    min-height: 20px;
}
/* No line after the last step */
.lp-hiw__step:last-child .lp-hiw__step-line { display: none; }

/* Content sits next to the connector */
.lp-hiw__step-body {
    flex: 1;
    padding-top: 7px;   /* aligns title baseline roughly with circle centre */
    padding-bottom: 8px; /* breathing room before next circle */
}
.lp-hiw__step:last-child .lp-hiw__step-body { padding-bottom: 0; }

.lp-hiw__step-title {
    font-family: var(--font-display);
    font-size: 17px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 6px;
    letter-spacing: -0.02em;
}
.lp-hiw__step-text {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.65;
}

/* ── FEATURES BENTO ── */
.lp-bento {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: auto auto;
    gap: 2px;
    background: var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
}
@media (max-width: 900px) {
    .lp-bento { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 540px) {
    .lp-bento { grid-template-columns: 1fr; }
}

.lp-bento__card {
    background: var(--bg);
    padding: 36px 32px;
    transition: background 0.2s;
    display: flex;
    flex-direction: column;
}
.lp-bento__card:hover { background: var(--bg-2); }
.lp-bento__card--wide {
    grid-column: span 2;
}
.lp-bento__card--dark {
    background: var(--ink-2);
}
.lp-bento__card--dark:hover { background: var(--ink-3); }

@media (max-width: 540px) {
    .lp-bento__card--wide { grid-column: span 1; }
}

.lp-bento__icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 20px;
    flex-shrink: 0;
}
.lp-bento__icon--teal {
    background: var(--teal-bg);
    border: 1px solid var(--teal-border);
    color: var(--teal);
}
.lp-bento__icon--dark {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: #fff;
}

.lp-bento__title {
    font-family: var(--font-display);
    font-size: 17px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 8px;
    letter-spacing: -0.02em;
}
.lp-bento__card--dark .lp-bento__title { color: #fff; }

.lp-bento__body {
    font-size: 13px;
    line-height: 1.7;
    color: var(--muted);
    flex: 1;
}
.lp-bento__card--dark .lp-bento__body { color: rgba(255,255,255,0.45); }

/* ── FEATURE GROUPS (outcome-led) ── */
.lp-feat-group {
    margin-bottom: 56px;
}
.lp-feat-group:last-child { margin-bottom: 0; }

.lp-feat-group__header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
}
.lp-feat-group__icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: var(--teal-bg);
    border: 1px solid var(--teal-border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: var(--teal);
    flex-shrink: 0;
}
.lp-feat-group__title {
    font-family: var(--font-display);
    font-size: 20px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.02em;
    margin-bottom: 2px;
}
.lp-feat-group__sub {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.5;
}

.lp-feat-group__grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 16px;
}

.lp-feat-card {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    transition: all 0.25s;
}
.lp-feat-card:hover {
    border-color: var(--teal-border);
    box-shadow: var(--shadow);
    transform: translateY(-2px);
}
.lp-feat-card > i {
    font-size: 22px;
    color: var(--teal);
    margin-bottom: 4px;
}
.lp-feat-card > strong {
    font-family: var(--font-display);
    font-size: 15px;
    font-weight: 700;
    color: var(--ink);
}
.lp-feat-card > span {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.6;
}

/* ── FEATURE TABS (Precis style) ── */
.lp-ftabs {
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 0;
    background: transparent;
    border: none;
    border-radius: 0;
    overflow: visible;
    min-height: 0;
}
@media (max-width: 768px) {
    .lp-ftabs { grid-template-columns: 1fr; }
}

.lp-ftabs__nav {
    display: flex;
    flex-direction: column;
    gap: 0;
    background: transparent;
    border-right: none;
    padding: 0;
    border-left: 2px solid var(--border);
}
@media (max-width: 768px) {
    .lp-ftabs__nav {
        flex-direction: row;
        border-left: none;
        border-bottom: 2px solid var(--border);
        overflow-x: auto;
        margin-bottom: 24px;
    }
}

.lp-ftabs__btn {
    display: flex;
    align-items: flex-start;
    gap: 0;
    width: 100%;
    padding: 24px 28px;
    border: none;
    background: transparent;
    border-radius: 0;
    cursor: pointer;
    text-align: left;
    transition: all 0.2s;
    position: relative;
    border-left: 3px solid transparent;
    margin-left: -2px;
}
.lp-ftabs__btn i { display: none; }
.lp-ftabs__btn:hover {
    background: var(--bg);
}
.lp-ftabs__btn--active {
    border-left-color: var(--teal);
    background: var(--bg);
}

.lp-ftabs__btn-inner {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.lp-ftabs__btn-inner strong {
    font-family: var(--font-display);
    font-size: 16px;
    font-weight: 700;
    color: var(--ink);
}
.lp-ftabs__btn--active .lp-ftabs__btn-inner strong { color: var(--teal-dark); }
.lp-ftabs__btn-inner span {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.5;
}

.lp-ftabs__panels {
    padding: 0 0 0 40px;
    position: relative;
}
@media (max-width: 768px) { .lp-ftabs__panels { padding: 0; } }

.lp-ftabs__panel {
    display: none;
}
.lp-ftabs__panel--active {
    display: block;
    animation: lp-fadeIn 0.3s ease;
}
@keyframes lp-fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

.lp-ftabs__panel-card {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    padding: 40px 36px;
    box-shadow: var(--shadow);
}

.lp-ftabs__panel-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: var(--teal-bg);
    border: 1px solid var(--teal-border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: var(--teal);
    margin-bottom: 20px;
}

.lp-ftabs__panel-title {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.02em;
    margin-bottom: 8px;
}
.lp-ftabs__panel-sub {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.6;
    margin-bottom: 24px;
}

.lp-ftabs__panel-features {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 28px;
}
.lp-ftabs__feat-row {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 500;
    color: var(--ink-3);
}
.lp-ftabs__feat-row i {
    color: var(--teal);
    font-size: 18px;
    flex-shrink: 0;
}

/* Mini cards grid inside panel */
.lp-ftabs__mini-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 20px;
}
@media (max-width: 540px) { .lp-ftabs__mini-grid { grid-template-columns: 1fr; } }

.lp-ftabs__mini-card {
    background: var(--bg-2);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    transition: all 0.2s;
}
.lp-ftabs__mini-card:hover {
    border-color: var(--teal-border);
    box-shadow: var(--shadow-sm);
    transform: translateY(-1px);
}
.lp-ftabs__mini-card > i {
    font-size: 20px;
    color: var(--teal);
    margin-bottom: 4px;
}
.lp-ftabs__mini-card > strong {
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 700;
    color: var(--ink);
}
.lp-ftabs__mini-card > span {
    font-size: 12px;
    color: var(--muted);
    line-height: 1.5;
}

/* Flow arrow connector */
.lp-ftabs__flow-arrow {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 12px 16px;
    background: var(--teal-bg);
    border: 1px solid var(--teal-border);
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 13px;
    color: var(--muted);
    flex-wrap: wrap;
}
.lp-ftabs__flow-arrow strong {
    font-family: var(--font-display);
    font-weight: 700;
    color: var(--teal-dark);
}

/* ── TESTIMONIALS (Precis: featured + scroll) ── */
.lp-testi__featured {
    background: rgb(232, 232, 232);
    border-radius: var(--r-lg);
    padding: 32px 36px;
    position: relative;
    overflow: hidden;
    margin-bottom: 32px;
}
@media (max-width: 640px) { .lp-testi__featured { padding: 24px 20px; } }

.lp-testi__quote-mark {
    font-family: var(--font-display);
    font-size: 100px;
    font-weight: 800;
    line-height: 0.7;
    color: rgba(0,229,160,0.12);
    position: absolute;
    top: 12px;
    left: 24px;
    pointer-events: none;
}
.lp-testi__big-quote {
    font-family: var(--font-display);
    font-size: clamp(16px, 2vw, 20px);
    font-weight: 600;
    line-height: 1.5;
    color: var(--ink);
    margin: 0 0 20px;
    position: relative;
    z-index: 1;
    font-style: normal;
    max-width: 720px;
}
.lp-testi__featured-bottom {
    display: flex;
    align-items: center;
    gap: 32px;
    flex-wrap: wrap;
}
.lp-testi__result {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 20px;
    background: rgba(0,229,160,0.08);
    border: 1px solid rgba(0,229,160,0.2);
    border-radius: 12px;
    flex-shrink: 0;
}
.lp-testi__result-stat {
    font-family: var(--font-display);
    font-size: 32px;
    font-weight: 800;
    color: var(--teal);
    letter-spacing: -0.03em;
    line-height: 1;
}
.lp-testi__result-label {
    font-size: 12px;
    color: var(--muted);
    line-height: 1.4;
}
.lp-testi__author {
    display: flex;
    align-items: center;
    gap: 12px;
}
.lp-testi__av {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 800;
    flex-shrink: 0;
}
.lp-testi__name {
    font-family: var(--font-display);
    font-size: 14px;
    font-weight: 700;
    color: var(--ink);
}
.lp-testi__biz {
    font-size: 12px;
    color: var(--muted);
    margin-top: 2px;
}
.lp-testi__stars {
    margin-left: 12px;
    font-size: 14px;
    color: #F59E0B;
    letter-spacing: 2px;
}

/* Scrolling ticker */
.lp-testi__scroll {
    overflow: hidden;
    position: relative;
    mask-image: linear-gradient(90deg, transparent, #000 5%, #000 95%, transparent);
    -webkit-mask-image: linear-gradient(90deg, transparent, #000 5%, #000 95%, transparent);
}
.lp-testi__track {
    display: flex;
    gap: 20px;
    animation: lp-testi-scroll 90s linear infinite;
    width: max-content;
}
.lp-testi__track:hover { animation-play-state: paused; }

@keyframes lp-testi-scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.lp-testi__slide {
    background: rgb(232, 232, 232);
    border: 1px solid rgba(0,0,0,0.06);
    border-radius: var(--r-lg);
    padding: 24px;
    min-width: 300px;
    max-width: 340px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex-shrink: 0;
    transition: all 0.25s;
}
.lp-testi__slide:hover {
    border-color: var(--border-2);
    box-shadow: var(--shadow);
    transform: translateY(-2px);
}
.lp-testi__slide-stars {
    font-size: 13px;
    color: #F59E0B;
    letter-spacing: 2px;
}
.lp-testi__slide p {
    font-size: 14px;
    line-height: 1.65;
    color: var(--ink-3);
    font-style: italic;
    margin: 0;
    flex: 1;
}
.lp-testi__slide-author {
    display: flex;
    align-items: center;
    gap: 10px;
    padding-top: 12px;
    border-top: 1px solid var(--border);
}
.lp-testi__slide-author strong {
    display: block;
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 700;
    color: var(--ink);
}
.lp-testi__slide-author span {
    display: block;
    font-size: 11px;
    color: var(--muted-2);
    margin-top: 1px;
}

/* Legacy grid (keep for compat) */
.lp-testi__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
@media (max-width: 900px) {
    .lp-testi__grid { grid-template-columns: 1fr; max-width: 520px; margin: 0 auto; }
}

.lp-tcard {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    padding: 32px 28px;
    display: flex;
    flex-direction: column;
    transition: all 0.25s;
}
.lp-tcard:hover {
    border-color: var(--border-2);
    box-shadow: var(--shadow);
    transform: translateY(-2px);
}

.lp-tcard__stars {
    display: flex;
    gap: 3px;
    margin-bottom: 18px;
}
.lp-tcard__star {
    width: 14px;
    height: 14px;
    fill: #F59E0B;
}

.lp-tcard__quote {
    font-size: 15px;
    line-height: 1.7;
    color: var(--ink-3);
    flex: 1;
    margin-bottom: 24px;
    font-style: italic;
}

.lp-tcard__author {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-top: 20px;
    border-top: 1px solid var(--border);
}
.lp-tcard__av {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-display);
    font-size: 12px;
    font-weight: 800;
    color: var(--ink);
}
.lp-tcard__name {
    font-family: var(--font-display);
    font-size: 14px;
    font-weight: 700;
    color: var(--ink);
}
.lp-tcard__biz {
    font-size: 12px;
    color: var(--muted-2);
    margin-top: 2px;
}

/* ── PRICING ── */
.lp-pricing__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    align-items: start;
}
@media (max-width: 900px) {
    .lp-pricing__grid { grid-template-columns: 1fr; max-width: 440px; margin: 0 auto; }
}

/* Base card */
.lp-pcard {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: box-shadow 0.25s ease, transform 0.25s ease;
}
.lp-pcard:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-3px);
}

/* Featured card — plain white, elevated */
.lp-pcard--featured {
    box-shadow: 0 8px 40px rgba(0,0,0,0.13);
}
.lp-pcard--featured:hover {
    box-shadow: 0 16px 56px rgba(0,0,0,0.18);
    transform: translateY(-5px);
}

/* Most Popular badge */
.lp-pcard__badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: var(--font-display);
    font-size: 12px;
    font-weight: 700;
    background: var(--ink);
    color: #fff;
    padding: 7px 16px;
    border-radius: var(--r-pill);
    margin: 24px 24px 0;
    align-self: flex-start;
    letter-spacing: 0.01em;
}
.lp-pcard__badge-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--teal);
    flex-shrink: 0;
}

/* Card top section */
.lp-pcard__top {
    padding: 28px 28px 24px;
}

.lp-pcard__name {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.03em;
    margin-bottom: 8px;
}

.lp-pcard__desc {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.6;
    margin-bottom: 20px;
}

.lp-pcard__price {
    font-family: var(--font-display);
    font-size: 52px;
    font-weight: 800;
    letter-spacing: -0.04em;
    color: var(--ink);
    line-height: 1;
    display: flex;
    align-items: baseline;
    gap: 4px;
}
.lp-pcard__price sup {
    font-size: 24px;
    font-weight: 700;
    vertical-align: super;
    opacity: 0.55;
    margin-right: 2px;
}
.lp-pcard__period {
    font-size: 15px;
    font-weight: 500;
    color: var(--muted-2);
    letter-spacing: 0;
    margin-left: 4px;
}

/* Features sub-box */
.lp-pcard__features-box {
    margin: 0 16px 16px;
    background: var(--bg-2);
    border-radius: 14px;
    padding: 20px 20px 16px;
    flex: 1;
}
.lp-pcard__features-box--dark {
    background: var(--ink);
}

.lp-pcard__features-label {
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 16px;
}
.lp-pcard__features-box--dark .lp-pcard__features-label {
    color: #fff;
}

.lp-pcard__features {
    display: flex;
    flex-direction: column;
    gap: 11px;
    list-style: none;
}
.lp-pcard__feature {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 500;
    color: var(--ink-3);
    line-height: 1.4;
}
.lp-pcard__features-box--dark .lp-pcard__feature {
    color: rgba(255,255,255,0.75);
}
.lp-pcard__feature i {
    font-size: 17px;
    flex-shrink: 0;
    color: var(--muted-2);
}
.lp-pcard__features-box--dark .lp-pcard__feature i {
    color: var(--teal);
}

/* CTA buttons */
.lp-pcard__cta {
    display: block;
    text-align: center;
    font-family: var(--font-display);
    font-size: 15px;
    font-weight: 700;
    padding: 18px 24px;
    margin: 0 16px 16px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
}
.lp-pcard__cta--dark {
    background: var(--ink);
    color: #fff !important;
}
.lp-pcard__cta--dark:hover {
    background: var(--ink-3);
    color: #fff !important;
}
.lp-pcard__cta--teal {
    background: var(--teal);
    color: var(--ink) !important;
}
.lp-pcard__cta--teal:hover {
    background: var(--teal-dark);
    color: var(--ink) !important;
}

/* Note below grid */
.lp-pricing__note {
    text-align: center;
    margin-top: 40px;
    font-size: 13px;
    color: var(--muted-2);
    font-family: var(--font-display);
    font-weight: 500;
}

/* ── MID CTA ── */
.lp-mcta {
    background: var(--bg);
    position: relative;
    overflow: hidden;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}

/* Subtle dot-grid texture */
.lp-mcta::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(0,0,0,0.055) 1px, transparent 1px);
    background-size: 28px 28px;
    pointer-events: none;
}

/* Soft teal radial glow at centre */
.lp-mcta__glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 720px;
    height: 500px;
    background: radial-gradient(ellipse, rgba(0,229,160,0.08) 0%, transparent 65%);
    pointer-events: none;
}

/* Content */
.lp-mcta__inner {
    position: relative;
    z-index: 1;
    text-align: center;
    padding: 108px 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0;
}

/* Social proof badge */
.lp-mcta__badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--ink);
    color: rgba(255,255,255,0.85);
    padding: 8px 18px;
    border-radius: var(--r-pill);
    font-family: var(--font-display);
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.02em;
    margin-bottom: 32px;
}
.lp-mcta__badge-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--teal);
    flex-shrink: 0;
}

/* Headline */
.lp-mcta__h2 {
    font-family: var(--font-display);
    font-size: clamp(36px, 5vw, 62px);
    font-weight: 800;
    letter-spacing: -0.04em;
    color: var(--ink);
    line-height: 1.05;
    margin-bottom: 20px;
    max-width: 720px;
}

/* Sub-copy */
.lp-mcta__sub {
    font-size: 18px;
    color: var(--muted);
    line-height: 1.65;
    max-width: 500px;
    margin: 0 auto 44px;
}

/* Trust row */
.lp-mcta__trust {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 28px;
    flex-wrap: wrap;
    margin-top: 24px;
}
.lp-mcta__chip {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
}
.lp-mcta__chip i { color: var(--teal); font-size: 15px; }

@media (max-width: 768px) {
    .lp-mcta__inner { padding: 80px 0; }
    .lp-mcta__trust { gap: 16px; }
}

/* ── FAQ ── */

/* 2-column layout: heading left, accordion right */
.lp-faq__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: start;
}
@media (max-width: 900px) {
    .lp-faq__grid { grid-template-columns: 1fr; gap: 48px; }
}

/* Left: sticky heading column */
.lp-faq__left { position: sticky; top: 120px; }
@media (max-width: 900px) { .lp-faq__left { position: static; } }

.lp-faq__plus {
    font-size: 18px;
    font-weight: 300;
    color: var(--muted-2);
    line-height: 1;
    margin-bottom: 20px;
    font-family: var(--font-display);
}
.lp-faq__h2 {
    font-family: var(--font-display);
    font-size: clamp(28px, 3.5vw, 46px);
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.035em;
    color: var(--ink);
    margin-bottom: 16px;
}
.lp-faq__sub {
    font-size: 16px;
    color: var(--muted);
    line-height: 1.65;
    margin-bottom: 32px;
    max-width: 360px;
}
.lp-faq__cta {
    display: inline-flex;
    align-items: center;
    font-family: var(--font-display);
    font-size: 15px;
    font-weight: 700;
    background: var(--ink);
    color: #fff !important;
    border-radius: 10px;
    padding: 14px 26px;
    text-decoration: none;
    transition: background 0.2s, transform 0.15s;
}
.lp-faq__cta:hover { background: var(--ink-3); transform: translateY(-1px); }

/* Right: accordion list */
.lp-faq__list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

/* Each FAQ card */
.lp-faq-item {
    background: var(--bg-2);
    border-radius: 14px;
    overflow: hidden;
}

/* Toggle button row */
.lp-faq-btn {
    width: 100%;
    background: none;
    border: none;
    padding: 20px 20px 20px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    cursor: pointer;
    text-align: left;
    font-family: var(--font-display);
    font-size: 16px;
    font-weight: 700;
    color: var(--ink);
}
.lp-faq-btn:focus { outline: none; }

/* Black circle icon — + rotates to × when open */
.lp-faq-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--ink);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 16px;
    color: #fff;
    transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
}
.lp-faq-item.open .lp-faq-icon { transform: rotate(45deg); }

/* Smooth height reveal */
.lp-faq-body {
    display: grid;
    grid-template-rows: 0fr;
    transition: grid-template-rows 0.35s cubic-bezier(0.22, 1, 0.36, 1);
}
.lp-faq-item.open .lp-faq-body { grid-template-rows: 1fr; }

.lp-faq-body-inner {
    overflow: hidden;
    padding: 0 24px;
    font-size: 15px;
    color: var(--muted);
    line-height: 1.75;
}
.lp-faq-item.open .lp-faq-body-inner { padding: 0 24px 22px; }

/* ── FINAL CTA ── */
.lp-cta {
    background: var(--ink-2);
    position: relative;
    overflow: hidden;
}

/* Subtle dot-grid texture on dark */
.lp-cta::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
    background-size: 28px 28px;
    pointer-events: none;
}

/* Teal glow — more visible on dark bg */
.lp-cta__glow {
    position: absolute;
    bottom: -120px;
    left: -100px;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(0,229,160,0.12) 0%, transparent 65%);
    pointer-events: none;
}

/* 2-column grid: heading left, card right */
.lp-cta__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: start;
    position: relative;
    z-index: 1;
}
@media (max-width: 900px) {
    .lp-cta__grid { grid-template-columns: 1fr; gap: 48px; }
}

/* Left: sticky heading */
.lp-cta__left { position: sticky; top: 120px; }
@media (max-width: 900px) { .lp-cta__left { position: static; } }

.lp-cta__plus {
    font-size: 18px;
    font-weight: 300;
    color: rgba(255,255,255,0.25);
    line-height: 1;
    margin-bottom: 20px;
    font-family: var(--font-display);
}
.lp-cta__h2 {
    font-family: var(--font-display);
    font-size: clamp(28px, 3.5vw, 46px);
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.035em;
    color: #fff;
    margin-bottom: 16px;
}
.lp-cta__sub {
    font-size: 16px;
    color: rgba(255,255,255,0.55);
    line-height: 1.65;
    margin-bottom: 36px;
    max-width: 400px;
}

/* Trust list */
.lp-cta__trust {
    display: flex;
    flex-direction: column;
    gap: 12px;
    list-style: none;
    padding: 0;
    margin: 0;
}
.lp-cta__trust-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--font-display);
    font-size: 14px;
    font-weight: 600;
    color: rgba(255,255,255,0.8);
}
.lp-cta__trust-item i {
    font-size: 17px;
    color: var(--teal);
    flex-shrink: 0;
}

/* Right: CTA card */
.lp-cta__card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04);
}

/* Teal accent line at the top of the card */
.lp-cta__card-accent {
    height: 3px;
    background: var(--teal);
}

.lp-cta__card-body {
    padding: 36px 36px 32px;
}

.lp-cta__card-h3 {
    font-family: var(--font-display);
    font-size: clamp(22px, 2.5vw, 30px);
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.03em;
    line-height: 1.15;
    margin-bottom: 12px;
}
.lp-cta__card-sub {
    font-size: 15px;
    color: var(--muted);
    line-height: 1.65;
    margin-bottom: 28px;
}

.lp-cta__card-btn {
    width: 100%;
    justify-content: center;
    border-radius: 12px !important;
    font-size: 16px !important;
    padding: 18px 28px !important;
    cursor: pointer;
    border: none;
}

.lp-cta__card-note {
    text-align: center;
    font-size: 12px;
    font-family: var(--font-display);
    color: var(--muted-2);
    margin-top: 12px;
    font-weight: 500;
}

.lp-cta__card-divider {
    height: 1px;
    background: var(--border);
    margin: 28px 0;
}

/* Left column contact alternatives (on dark bg) */
.lp-cta__contact-alts {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 36px;
}
.lp-cta__contact-link {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    transition: opacity 0.2s;
}
.lp-cta__contact-link:hover { opacity: 0.8; }

.lp-cta__contact-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(255,255,255,0.12);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    flex-shrink: 0;
}
.lp-cta__contact-icon--wa { background: #25D366; }

.lp-cta__contact-label {
    font-family: var(--font-display);
    font-size: 11px;
    font-weight: 700;
    color: rgba(255,255,255,0.4);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 1px;
}
.lp-cta__contact-val {
    font-family: var(--font-display);
    font-size: 14px;
    font-weight: 700;
    color: rgba(255,255,255,0.85);
}

/* ── CTA BOOKING FORM ── */
.lp-cta__form {
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.lp-cta__form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
@media (max-width: 560px) { .lp-cta__form-row { grid-template-columns: 1fr; } }

.lp-cta__form-field {
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.lp-cta__form-label {
    font-family: var(--font-display);
    font-size: 11px;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.07em;
}
.lp-cta__form-optional {
    font-weight: 400;
    text-transform: none;
    letter-spacing: 0;
    color: var(--muted-2);
}
.lp-cta__form-input {
    width: 100%;
    padding: 10px 13px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-family: var(--font-body);
    font-size: 14px;
    color: var(--ink);
    background: var(--bg-2);
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    -webkit-appearance: none;
    appearance: none;
}
.lp-cta__form-input::placeholder { color: var(--muted-2); }
.lp-cta__form-input:focus {
    border-color: var(--teal);
    box-shadow: 0 0 0 3px rgba(0,229,160,0.12);
    background: #fff;
}
.lp-cta__form-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238A8A8A' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 13px center;
    padding-right: 34px;
    cursor: pointer;
}
.lp-cta__form-input--err { border-color: #EF4444; }
.lp-cta__form-err {
    font-size: 11px;
    color: #EF4444;
    font-family: var(--font-display);
    font-weight: 600;
}

/* Success state */
.lp-cta__success {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    background: var(--teal-bg);
    border: 1px solid var(--teal-border);
    border-radius: 12px;
    padding: 16px 18px;
    margin-bottom: 4px;
}
.lp-cta__success i { font-size: 24px; color: var(--teal); flex-shrink: 0; margin-top: 1px; }
.lp-cta__success strong { display: block; font-family: var(--font-display); font-size: 15px; color: var(--ink); font-weight: 700; margin-bottom: 2px; }
.lp-cta__success span { font-size: 13px; color: var(--muted); line-height: 1.5; }

/* Error alert */
.lp-cta__alert {
    background: #FEE2E2;
    color: #991B1B;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 13px;
    font-family: var(--font-display);
    font-weight: 600;
    margin-bottom: 4px;
}

/* ── NAVBAR ── */
.lp-nav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 100;
    transition: all 0.3s;
}
.lp-nav__inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    height: 68px;
    padding: 0 28px;
    max-width: 1160px;
    margin: 0 auto;
}
.lp-nav--scrolled {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border);
}
.lp-nav__logo {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--font-display);
    font-size: 18px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.03em;
    flex-shrink: 0;
}
.lp-nav--scrolled .lp-nav__logo { color: var(--ink); }
.lp-nav__logo-mark {
    width: 32px;
    height: 32px;
    background: var(--teal);
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: var(--ink);
    font-weight: 900;
    flex-shrink: 0;
}
.lp-nav__links {
    display: flex;
    align-items: center;
    gap: 8px;
}
@media (max-width: 768px) { .lp-nav__links { display: none; } }
.lp-nav__link {
    font-family: var(--font-display);
    font-size: 14px;
    font-weight: 600;
    color: var(--muted);
    padding: 8px 14px;
    border-radius: var(--r-pill);
    transition: all 0.2s;
}
.lp-nav--scrolled .lp-nav__link { color: var(--muted); }
.lp-nav__link:hover {
    color: var(--ink);
    background: rgba(0,0,0,0.04);
}
.lp-nav--scrolled .lp-nav__link:hover {
    color: var(--ink);
    background: var(--bg-2);
}
.lp-nav__right { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
.lp-nav__mobile-btn {
    display: none;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 22px;
    color: var(--ink);
    padding: 4px;
}
.lp-nav--scrolled .lp-nav__mobile-btn { color: var(--ink); }
@media (max-width: 768px) {
    .lp-nav__mobile-btn { display: flex; align-items: center; }
}

/* Mobile menu */
.lp-mobile-menu {
    display: none;
    position: fixed;
    top: 68px;
    left: 0;
    right: 0;
    background: #fff;
    border-bottom: 1px solid var(--border);
    padding: 16px 28px 24px;
    z-index: 99;
    flex-direction: column;
    gap: 6px;
    box-shadow: var(--shadow-lg);
}
.lp-mobile-menu.open { display: flex; }
.lp-mobile-link {
    font-family: var(--font-display);
    font-size: 15px;
    font-weight: 600;
    color: var(--ink);
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
    display: block;
}
.lp-mobile-link:last-child { border-bottom: none; }

/* ── FOOTER ── */
.lp-footer {
    background: var(--bg-2);
    border-top: 1px solid var(--border);
    padding: 72px 0 0;
}
.lp-footer__grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 48px;
    margin-bottom: 64px;
}
@media (max-width: 900px) {
    .lp-footer__grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 540px) {
    .lp-footer__grid { grid-template-columns: 1fr; }
}

.lp-footer__brand { max-width: 280px; }
.lp-footer__logo {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--font-display);
    font-size: 18px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.03em;
    margin-bottom: 16px;
}
.lp-footer__logo-mark {
    width: 30px;
    height: 30px;
    background: var(--teal);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: var(--ink);
    font-weight: 900;
}
.lp-footer__tagline {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.65;
    margin-bottom: 24px;
}
.lp-footer__socials {
    display: flex;
    gap: 8px;
}
.lp-footer__social {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: var(--bg-3);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: var(--muted);
    transition: all 0.2s;
}
.lp-footer__social:hover {
    background: var(--ink);
    border-color: var(--ink);
    color: #fff;
}

.lp-footer__col-title {
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: var(--ink);
    margin-bottom: 20px;
}
.lp-footer__links {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.lp-footer__link {
    font-size: 14px;
    font-weight: 500;
    color: var(--muted);
    transition: color 0.2s;
}
.lp-footer__link:hover { color: var(--ink); }

.lp-footer__bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 24px 0;
    border-top: 1px solid var(--border);
    flex-wrap: wrap;
}
.lp-footer__copy {
    font-size: 13px;
    color: var(--muted-2);
    font-family: var(--font-display);
}
.lp-footer__legal {
    display: flex;
    gap: 20px;
}
.lp-footer__legal a {
    font-size: 13px;
    color: var(--muted-2);
    font-family: var(--font-display);
    transition: color 0.2s;
}
.lp-footer__legal a:hover { color: var(--ink); }

/* ── HERO WORKFLOW STRIP ── */
.lp-hero__workflow {
    margin-bottom: 56px;
    padding: 0 20px;
}
.lp-wf {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1000px;
    margin: 0 auto;
    position: relative;
}
/* Continuous line behind everything */
.lp-wf::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 60px;
    right: 60px;
    height: 1px;
    background: var(--border-2);
    z-index: 0;
}
@media (max-width: 768px) {
    .lp-wf {
        flex-direction: column;
        align-items: stretch;
        gap: 0;
    }
    .lp-wf::before {
        top: 60px;
        bottom: 60px;
        left: 50%;
        right: auto;
        width: 1px;
        height: auto;
    }
}

.lp-wf__card {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    text-align: left;
    gap: 14px;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 18px 24px;
    width: 290px;
    box-shadow: var(--shadow);
    transition: all 0.25s;
}
.lp-wf__card:hover {
    border-color: var(--teal-border);
    box-shadow: var(--shadow-teal);
    transform: translateY(-2px);
}
@media (max-width: 768px) {
    .lp-wf__card {
        width: 100%;
        padding: 16px 20px;
    }
}

.lp-wf__icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--teal-bg);
    border: 1px solid var(--teal-border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: var(--teal);
    flex-shrink: 0;
}
@media (max-width: 768px) {
    .lp-wf__icon { width: 36px; height: 36px; font-size: 16px; }
}

.lp-wf__text {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.lp-wf__text strong {
    font-family: var(--font-display);
    font-size: 15px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.02em;
}
.lp-wf__text span {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.5;
}

.lp-wf__check {
    position: relative;
    z-index: 1;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--teal);
    color: var(--ink);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 800;
    flex-shrink: 0;
    box-shadow: 0 0 0 6px rgb(240, 240, 240), 0 4px 12px rgba(0,229,160,0.3);
}
@media (max-width: 768px) {
    .lp-wf__check {
        width: 28px;
        height: 28px;
        font-size: 12px;
        margin: 12px auto;
        box-shadow: 0 0 0 5px rgb(240, 240, 240), 0 4px 12px rgba(0,229,160,0.3);
    }
}

/* ── HERO SPACER ── */
body { padding-top: 0; }

/* ── DARK BUTTON VARIANT ── */
.lp-btn--dark {
    background: var(--ink);
    color: #fff !important;
    border-color: var(--ink);
}
.lp-btn--dark:hover {
    background: var(--ink-3);
    border-color: var(--ink-3);
    color: #fff !important;
}

/* ── PAIN SECTION ── */
.lp-pain {
    background: var(--bg-2);
    padding: 96px 0;
}
@media (max-width: 768px) { .lp-pain { padding: 64px 0; } }

.lp-pain__layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: start;
}
@media (max-width: 900px) {
    .lp-pain__layout { grid-template-columns: 1fr; gap: 40px; }
}

/* Left column sticks at top:120px — exact Precis behaviour */
.lp-pain__left {
    position: sticky;
    top: 120px;
}
@media (max-width: 900px) {
    .lp-pain__left { position: static; }
}

.lp-pain__plus {
    font-size: 22px;
    font-weight: 300;
    color: var(--muted-2);
    margin-bottom: 24px;
    line-height: 1;
    font-family: var(--font-display);
}

.lp-pain__h2 {
    font-family: var(--font-display);
    font-size: clamp(30px, 3.8vw, 50px);
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.03em;
    color: var(--ink);
    margin-bottom: 20px;
}
.lp-pain__h2 em {
    font-style: normal;
    color: var(--muted);
}

.lp-pain__sub {
    font-size: 15px;
    line-height: 1.65;
    color: var(--muted);
    margin-bottom: 36px;
    max-width: 320px;
}

/* Cards column */
.lp-pain__right {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 8px 0;
}

/* Individual card — hidden by default, revealed by JS */
.lp-pain-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 28px 24px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    align-items: center;
    opacity: 0;
    transform: translateY(44px);
    transition: opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1),
                transform 0.6s cubic-bezier(0.22, 1, 0.36, 1),
                box-shadow 0.25s ease;
    will-change: opacity, transform;
}
.lp-pain-card--visible {
    opacity: 1;
    transform: translateY(0);
}
.lp-pain-card:hover {
    box-shadow: var(--shadow);
}

@media (max-width: 560px) {
    .lp-pain-card { grid-template-columns: 1fr; }
}

.lp-pain-card__title {
    font-family: var(--font-display);
    font-size: 16px;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 10px;
    letter-spacing: -0.02em;
}
.lp-pain-card__body {
    font-size: 14px;
    line-height: 1.65;
    color: var(--muted);
}

/* Visual mockup area */
.lp-pain-card__visual {
    background: var(--bg-2);
    border-radius: 12px;
    padding: 18px 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Card 1: Status rows */
.lp-pain-status-row {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-family: var(--font-display);
    font-weight: 500;
    color: var(--ink-3);
}
.lp-pain-status-row i { font-size: 14px; color: var(--muted-2); flex-shrink: 0; }
.lp-pain-status-row > span:nth-child(2) { flex: 1; }

/* Card 2: Lead rows */
.lp-pain-lead-row {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
    font-family: var(--font-display);
    font-weight: 500;
    color: var(--ink);
}
.lp-pain-lead-row + .lp-pain-lead-row { margin-top: 10px; }
.lp-pain-av {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 800;
    font-family: var(--font-display);
}
.lp-pain-lead-info { flex: 1; display: flex; flex-direction: column; gap: 2px; }
.lp-pain-lead-info small { font-size: 10px; color: var(--muted-2); font-weight: 500; }

/* Pills */
.lp-pain-pill {
    font-size: 10px;
    font-weight: 700;
    font-family: var(--font-display);
    letter-spacing: 0.03em;
    padding: 3px 9px;
    border-radius: 999px;
    white-space: nowrap;
    flex-shrink: 0;
}
.lp-pain-pill--green { background: #D1FAE5; color: #065F46; }
.lp-pain-pill--gray  { background: #F3F4F6; color: #6B7280; }
.lp-pain-pill--red   { background: #FEE2E2; color: #991B1B; }

/* Card 3: Bar chart */
.lp-pain-card__visual--bars { gap: 14px; }
.lp-pain-bar-row { display: flex; flex-direction: column; gap: 6px; }
.lp-pain-bar-row > span {
    font-size: 11px;
    font-family: var(--font-display);
    font-weight: 600;
    color: var(--ink-3);
}
.lp-pain-bar {
    height: 8px;
    background: #E5E7EB;
    border-radius: 4px;
    overflow: hidden;
}
.lp-pain-bar__fill {
    height: 100%;
    background: var(--ink);
    border-radius: 4px;
}

/* Card 4: Disconnected tools */
.lp-pain-card__visual--tools {
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 10px;
    min-height: 84px;
}
.lp-pain-tool {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
    position: relative;
}
.lp-pain-tool-err {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 16px;
    height: 16px;
    background: #EF4444;
    color: #fff;
    border-radius: 50%;
    font-size: 10px;
    font-weight: 900;
    font-style: normal;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
    font-family: var(--font-display);
}
.lp-pain-dashes { display: flex; gap: 4px; align-items: center; }
.lp-pain-dashes span {
    width: 6px;
    height: 2px;
    background: var(--border-2);
    border-radius: 1px;
    display: block;
}
</style>
@endpush

@section('content')
<div class="lp">
    @include('components.hero')
    @include('components.logos')
    @include('components.pain')
    @include('components.how-it-works')
    @include('components.features')
    @include('components.testimonials')
    @include('components.pricing')
    @include('components.faq')
    @include('components.cta')
</div>
@endsection

@push('body-scripts')
<script>
/* Navbar scroll behavior */
(function () {
    var nav = document.querySelector('.lp-nav');
    if (!nav) return;
    function onScroll() {
        if (window.scrollY > 40) nav.classList.add('lp-nav--scrolled');
        else nav.classList.remove('lp-nav--scrolled');
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    /* Mobile menu */
    var btn = document.getElementById('lp-menu-btn');
    var menu = document.getElementById('lp-mobile-menu');
    if (btn && menu) {
        btn.addEventListener('click', function () {
            menu.classList.toggle('open');
        });
        document.addEventListener('click', function (e) {
            if (!nav.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('open');
            }
        });
    }

    /* FAQ */
    document.querySelectorAll('.lp-faq-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = btn.closest('.lp-faq-item');
            var isOpen = item.classList.contains('open');
            document.querySelectorAll('.lp-faq-item.open').forEach(function (i) {
                i.classList.remove('open');
                i.querySelector('.lp-faq-btn').setAttribute('aria-expanded', 'false');
            });
            if (!isOpen) {
                item.classList.add('open');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });

    /* Feature tabs */
    document.querySelectorAll('.lp-ftabs__btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var tab = btn.getAttribute('data-tab');
            var container = btn.closest('.lp-ftabs');
            container.querySelectorAll('.lp-ftabs__btn').forEach(function (b) { b.classList.remove('lp-ftabs__btn--active'); });
            container.querySelectorAll('.lp-ftabs__panel').forEach(function (p) { p.classList.remove('lp-ftabs__panel--active'); });
            btn.classList.add('lp-ftabs__btn--active');
            container.querySelector('[data-panel="' + tab + '"]').classList.add('lp-ftabs__panel--active');
        });
    });

    /* Pain cards — IntersectionObserver reveal, one-by-one (Precis approach) */
    (function () {
        var cards = document.querySelectorAll('.lp-pain-card');
        if (!cards.length) return;

        if (!window.IntersectionObserver) {
            cards.forEach(function (c) { c.classList.add('lp-pain-card--visible'); });
            return;
        }

        /* Stagger delay matching Precis: 0.3-0.4s per card */
        var delays = [0, 100, 200, 300];
        cards.forEach(function (card, i) {
            card.style.transitionDelay = delays[i] + 'ms';
        });

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('lp-pain-card--visible');
                } else if (entry.boundingClientRect.top > 0) {
                    /* Re-hide only when card is below viewport (scrolling back up) */
                    entry.target.classList.remove('lp-pain-card--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -80px 0px'
        });

        cards.forEach(function (c) { io.observe(c); });
    })();
})();
</script>
@endpush
