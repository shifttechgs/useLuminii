@extends("layouts.useluminii_master")

@section('title', 'useLuminii — The All-In-One System for High-Performing Service Businesses')
@section('description', 'Stop running your service business on WhatsApp and spreadsheets. useLuminii captures leads, sends quotes, manages jobs, and collects payments — all in one connected system.')
@section('keywords', 'service business software, CRM for contractors, job management, quote automation, invoicing, AI receptionist, South Africa business software, field service management')
@section('og_title', 'useLuminii — Built for High-Performing Service Businesses')
@section('og_description', 'Capture leads. Send quotes. Manage jobs. Get paid. All automated. One flat price. Unlimited team members.')
@section('twitter_title', 'useLuminii — Your Business Operating System')
@section('twitter_description', 'From first enquiry to final payment — fully automated. Built for South African service businesses.')

@push('head-styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
<style>
/* =======================================================
   LUMINII — PRECIS-INSPIRED DESIGN SYSTEM
   Light, clean, editorial. Premium SaaS aesthetic.
   ======================================================= */

:root {
    --lp-font: 'Plus Jakarta Sans', sans-serif;

    /* Backgrounds */
    --lp-cream:      #F7F5F0;
    --lp-white:      #FFFFFF;
    --lp-dark:       #0B0B14;
    --lp-dark-2:     #141420;

    /* Text */
    --lp-ink:        #0B0B14;
    --lp-ink-2:      #3A3A4E;
    --lp-ink-3:      #6B6E80;
    --lp-ink-4:      #9EA3B0;
    --lp-text-inv:   #F2F2EE;
    --lp-text-inv-2: rgba(242,242,238,0.55);

    /* Accent */
    --lp-teal:       #00A48C;
    --lp-teal-bg:    rgba(0,164,140,0.08);
    --lp-teal-bd:    rgba(0,164,140,0.22);

    /* Structure */
    --lp-border:     rgba(11,11,20,0.09);
    --lp-border-2:   rgba(11,11,20,0.15);
    --lp-shadow:     0 1px 2px rgba(11,11,20,0.04), 0 4px 20px rgba(11,11,20,0.07);
    --lp-shadow-hover: 0 2px 6px rgba(11,11,20,0.06), 0 16px 48px rgba(11,11,20,0.11);
    --lp-r:          12px;
    --lp-r-lg:       20px;
    --lp-r-pill:     999px;
    --lp-sp:         100px;
    --lp-sp-sm:      64px;
}

@media (max-width: 768px) {
    :root { --lp-sp: 64px; --lp-sp-sm: 48px; }
}

/* ── Base ────────────────────────────────── */
.lp-section { padding: var(--lp-sp) 0; }
.lp-section-sm { padding: var(--lp-sp-sm) 0; }
.lp-bg-cream { background: var(--lp-cream); }
.lp-bg-white { background: var(--lp-white); }
.lp-bg-dark  { background: var(--lp-dark); }

.lp-section *,
.lp-section-sm * {
    font-family: var(--lp-font);
}

/* ── Eyebrow ─────────────────────────────── */
.lp-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--lp-ink-3);
    margin-bottom: 20px;
}
.lp-eyebrow--teal { color: var(--lp-teal); }
.lp-eyebrow__dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--lp-teal);
    flex-shrink: 0;
}

/* ── Headings ────────────────────────────── */
.lp-h1 {
    font-size: clamp(38px, 5.5vw, 68px);
    font-weight: 800;
    line-height: 1.06;
    letter-spacing: -0.03em;
    color: var(--lp-ink);
    margin: 0 0 20px;
}
.lp-h2 {
    font-size: clamp(30px, 4vw, 50px);
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.025em;
    color: var(--lp-ink);
    margin: 0 0 16px;
}
.lp-h2--inv { color: var(--lp-text-inv); }
.lp-h3 {
    font-size: 18px;
    font-weight: 700;
    line-height: 1.3;
    letter-spacing: -0.01em;
    color: var(--lp-ink);
    margin: 0 0 10px;
}
.lp-h3--inv { color: var(--lp-text-inv); }
.lp-lead {
    font-size: clamp(16px, 1.8vw, 18px);
    font-weight: 400;
    line-height: 1.75;
    color: var(--lp-ink-3);
    margin: 0 0 36px;
}
.lp-lead--inv { color: var(--lp-text-inv-2); }
.lp-body {
    font-size: 15px;
    line-height: 1.7;
    color: var(--lp-ink-3);
    margin: 0;
}
.lp-body--inv { color: var(--lp-text-inv-2); }

/* ── Buttons ─────────────────────────────── */
.lp-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: var(--lp-font);
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    border-radius: var(--lp-r-pill);
    padding: 13px 28px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.lp-btn:hover { text-decoration: none; transform: translateY(-1px); }
.lp-btn:active { transform: translateY(0); }

/* Dark (primary) */
.lp-btn-ink {
    background: var(--lp-ink);
    color: #fff;
}
.lp-btn-ink:hover { background: #1a1a2e; color: #fff; box-shadow: 0 8px 24px rgba(11,11,20,0.2); }

/* Teal (featured) */
.lp-btn-teal {
    background: var(--lp-teal);
    color: #fff;
}
.lp-btn-teal:hover { background: #009478; color: #fff; box-shadow: 0 8px 24px rgba(0,164,140,0.3); }

/* Ghost / outlined */
.lp-btn-ghost {
    background: transparent;
    color: var(--lp-ink-2);
    border: 1.5px solid var(--lp-border-2);
}
.lp-btn-ghost:hover { border-color: var(--lp-ink); color: var(--lp-ink); background: rgba(11,11,20,0.03); }

/* Ghost on dark bg */
.lp-btn-ghost-inv {
    background: transparent;
    color: var(--lp-text-inv);
    border: 1.5px solid rgba(255,255,255,0.2);
}
.lp-btn-ghost-inv:hover { border-color: rgba(255,255,255,0.5); background: rgba(255,255,255,0.05); color: #fff; }

/* Text link */
.lp-btn-text {
    background: none;
    border: none;
    color: var(--lp-ink-3);
    padding: 13px 0;
    font-size: 15px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: color 0.2s, gap 0.2s;
    cursor: pointer;
    text-decoration: none;
}
.lp-btn-text:hover { color: var(--lp-ink); gap: 10px; text-decoration: none; }

.lp-btn-lg { padding: 16px 36px; font-size: 16px; }

/* ── Teal underline accent ───────────────── */
.lp-u {
    position: relative;
    display: inline-block;
}
.lp-u::after {
    content: '';
    position: absolute;
    bottom: 4px; left: 0; right: 0;
    height: 3px;
    background: var(--lp-teal);
    border-radius: 2px;
    opacity: 0.5;
}

/* ── Tag pill ────────────────────────────── */
.lp-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 600;
    border-radius: var(--lp-r-pill);
    padding: 5px 14px;
    background: var(--lp-teal-bg);
    color: var(--lp-teal);
    border: 1px solid var(--lp-teal-bd);
}
.lp-tag__dot { width:5px; height:5px; border-radius:50%; background:currentColor; animation: lp-blink 2s ease-in-out infinite; }
@keyframes lp-blink { 0%,100%{opacity:1} 50%{opacity:.3} }

/* ── Section separator ───────────────────── */
.lp-rule {
    height: 1px;
    background: var(--lp-border);
    border: none; margin: 0;
}
.lp-rule--inv { background: rgba(255,255,255,0.07); }

/* =======================================================
   HERO
   ======================================================= */
.lp-hero {
    background: var(--lp-cream);
    padding: 80px 0 0;
    position: relative;
    overflow: hidden;
}
.lp-hero__top {
    text-align: center;
    max-width: 780px;
    margin: 0 auto;
    padding: 0 20px 60px;
    position: relative;
    z-index: 2;
}
.lp-hero__ctas {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 36px;
}
.lp-hero__note {
    margin-top: 20px;
    font-size: 13px;
    color: var(--lp-ink-4);
}
.lp-hero__note span { margin: 0 8px; }

/* Browser mockup */
.lp-mock {
    max-width: 960px;
    margin: 0 auto;
    background: var(--lp-white);
    border-radius: var(--lp-r-lg) var(--lp-r-lg) 0 0;
    border: 1px solid var(--lp-border-2);
    border-bottom: none;
    box-shadow: 0 -4px 0 rgba(11,11,20,0.04), 0 24px 80px rgba(11,11,20,0.12);
    overflow: hidden;
    position: relative;
    z-index: 2;
}
.lp-mock__bar {
    background: #F0EEE9;
    border-bottom: 1px solid var(--lp-border);
    padding: 10px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.lp-mock__dots { display: flex; gap: 6px; }
.lp-mock__dot { width: 10px; height: 10px; border-radius: 50%; }
.lp-mock__dot:nth-child(1) { background: #FF5F57; }
.lp-mock__dot:nth-child(2) { background: #FEBC2E; }
.lp-mock__dot:nth-child(3) { background: #28C840; }
.lp-mock__url {
    flex: 1;
    text-align: center;
    font-size: 12px;
    font-weight: 500;
    color: var(--lp-ink-3);
    background: var(--lp-white);
    border-radius: 6px;
    padding: 4px 12px;
    border: 1px solid var(--lp-border);
}
.lp-mock__body {
    padding: 28px;
    background: var(--lp-white);
    min-height: 320px;
}

/* Dashboard inside mockup */
.lp-dash__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
}
.lp-dash__title {
    font-size: 16px;
    font-weight: 700;
    color: var(--lp-ink);
}
.lp-dash__date {
    font-size: 12px;
    color: var(--lp-ink-4);
}
.lp-dash__stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 24px;
}
@media (max-width: 576px) { .lp-dash__stats { grid-template-columns: repeat(2, 1fr); } }
.lp-dash__stat {
    background: var(--lp-cream);
    border: 1px solid var(--lp-border);
    border-radius: var(--lp-r);
    padding: 16px;
}
.lp-dash__stat-val {
    font-size: 24px;
    font-weight: 800;
    color: var(--lp-ink);
    letter-spacing: -0.02em;
    line-height: 1;
    display: block;
    margin-bottom: 4px;
}
.lp-dash__stat-lbl {
    font-size: 11px;
    font-weight: 500;
    color: var(--lp-ink-4);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.lp-dash__stat--teal .lp-dash__stat-val { color: var(--lp-teal); }

.lp-dash__feed { display: flex; flex-direction: column; gap: 10px; }
.lp-dash__item {
    display: flex;
    align-items: center;
    gap: 12px;
    background: var(--lp-cream);
    border: 1px solid var(--lp-border);
    border-radius: var(--lp-r);
    padding: 12px 16px;
}
.lp-dash__icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}
.lp-dash__icon--lead   { background: rgba(99,102,241,0.1); color: #6366F1; }
.lp-dash__icon--quote  { background: rgba(245,158,11,0.1);  color: #F59E0B; }
.lp-dash__icon--paid   { background: rgba(0,164,140,0.1);   color: var(--lp-teal); }
.lp-dash__item-text { flex: 1; }
.lp-dash__item-title { font-size: 13px; font-weight: 600; color: var(--lp-ink); }
.lp-dash__item-sub   { font-size: 11px; color: var(--lp-ink-4); margin-top: 1px; }
.lp-dash__item-badge {
    font-size: 11px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    white-space: nowrap;
}
.lp-dash__item-badge--new  { background: rgba(99,102,241,0.1); color: #6366F1; }
.lp-dash__item-badge--sent { background: rgba(245,158,11,0.1); color: #D97706; }
.lp-dash__item-badge--paid { background: rgba(0,164,140,0.1); color: var(--lp-teal); }

/* =======================================================
   STATS BAR
   ======================================================= */
.lp-stats-bar {
    background: var(--lp-dark);
    padding: 40px 0;
    border-top: 1px solid rgba(255,255,255,0.04);
}
.lp-stats-bar__inner {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
}
@media (max-width: 768px) { .lp-stats-bar__inner { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .lp-stats-bar__inner { grid-template-columns: 1fr; } }
.lp-stat-item {
    text-align: center;
    padding: 16px 24px;
    border-right: 1px solid rgba(255,255,255,0.06);
}
.lp-stat-item:last-child { border-right: none; }
@media (max-width: 768px) {
    .lp-stat-item:nth-child(2) { border-right: none; }
    .lp-stat-item { border-bottom: 1px solid rgba(255,255,255,0.06); }
    .lp-stat-item:nth-last-child(-n+2) { border-bottom: none; }
}
.lp-stat-item__num {
    display: block;
    font-family: var(--lp-font);
    font-size: 36px;
    font-weight: 800;
    color: var(--lp-text-inv);
    letter-spacing: -0.03em;
    line-height: 1;
    margin-bottom: 6px;
}
.lp-stat-item__num em { font-style: normal; color: var(--lp-teal); }
.lp-stat-item__lbl {
    font-size: 13px;
    font-weight: 400;
    color: var(--lp-text-inv-2);
}

/* =======================================================
   PAIN SECTION
   ======================================================= */
.lp-pain__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-top: 56px;
}
@media (max-width: 992px) { .lp-pain__grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 576px) { .lp-pain__grid { grid-template-columns: 1fr; } }

.lp-pain-card {
    background: var(--lp-white);
    border: 1px solid var(--lp-border);
    border-radius: var(--lp-r-lg);
    padding: 32px 28px;
    transition: box-shadow 0.25s ease, transform 0.25s ease;
}
.lp-pain-card:hover {
    box-shadow: var(--lp-shadow-hover);
    transform: translateY(-3px);
}
.lp-pain-card__num {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--lp-ink-4);
    margin-bottom: 16px;
    display: block;
}
.lp-pain-card__icon {
    font-size: 28px;
    color: var(--lp-ink-3);
    margin-bottom: 16px;
    display: block;
}
.lp-pain-card__title {
    font-size: 16px;
    font-weight: 700;
    color: var(--lp-ink);
    margin-bottom: 10px;
    line-height: 1.35;
}
.lp-pain-card__body {
    font-size: 14px;
    color: var(--lp-ink-3);
    line-height: 1.65;
    margin: 0;
}

/* =======================================================
   PROCESS (HOW IT WORKS)
   ======================================================= */
.lp-process__steps {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 0;
    margin-top: 64px;
    position: relative;
}
@media (max-width: 992px) { .lp-process__steps { grid-template-columns: 1fr; gap: 0; } }

.lp-process__step {
    position: relative;
    padding: 0 24px 0 0;
}
@media (max-width: 992px) {
    .lp-process__step {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        padding: 0 0 40px;
    }
    .lp-process__step:last-child { padding-bottom: 0; }
}

/* Horizontal connecting line */
.lp-process__step::after {
    content: '';
    position: absolute;
    top: 24px;
    right: 0;
    width: calc(100% - 48px);
    height: 1px;
    background: var(--lp-border-2);
    left: 48px;
    pointer-events: none;
}
.lp-process__step:last-child::after { display: none; }
@media (max-width: 992px) {
    .lp-process__step::after {
        top: 24px;
        left: 23px;
        width: 1px;
        height: calc(100% - 48px);
        right: auto;
    }
    .lp-process__step:last-child::after { display: none; }
}

.lp-process__num {
    width: 48px; height: 48px;
    border-radius: 50%;
    background: var(--lp-ink);
    color: #fff;
    font-size: 16px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    flex-shrink: 0;
    position: relative;
    z-index: 2;
}
.lp-process__num--teal { background: var(--lp-teal); }
@media (max-width: 992px) { .lp-process__num { margin-bottom: 0; } }

.lp-process__content {}
.lp-process__label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--lp-teal);
    margin-bottom: 8px;
    display: block;
}
.lp-process__title {
    font-size: 16px;
    font-weight: 700;
    color: var(--lp-ink);
    margin-bottom: 8px;
    line-height: 1.3;
}
.lp-process__body {
    font-size: 13px;
    color: var(--lp-ink-3);
    line-height: 1.65;
}

/* =======================================================
   SYSTEM (TWO-PART)
   ======================================================= */
.lp-system-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 56px;
}
@media (max-width: 768px) { .lp-system-grid { grid-template-columns: 1fr; } }

.lp-system-card {
    background: var(--lp-white);
    border: 1px solid var(--lp-border);
    border-radius: var(--lp-r-lg);
    padding: 40px 36px;
    transition: box-shadow 0.25s, transform 0.25s;
}
.lp-system-card:hover { box-shadow: var(--lp-shadow-hover); transform: translateY(-3px); }
.lp-system-card--dark {
    background: var(--lp-ink);
    border-color: transparent;
}

.lp-system-card__part {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--lp-teal);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.lp-system-card__part--inv { color: rgba(0,164,140,0.8); }
.lp-system-card__part__line {
    flex: 0 0 24px;
    height: 1px;
    background: var(--lp-teal-bd);
}

.lp-system-card__icon {
    font-size: 36px;
    color: var(--lp-ink-3);
    margin-bottom: 20px;
    display: block;
}
.lp-system-card--dark .lp-system-card__icon { color: rgba(255,255,255,0.3); }

.lp-system-card__title {
    font-size: 22px;
    font-weight: 800;
    letter-spacing: -0.015em;
    color: var(--lp-ink);
    margin-bottom: 10px;
    line-height: 1.25;
}
.lp-system-card--dark .lp-system-card__title { color: var(--lp-text-inv); }
.lp-system-card__body {
    font-size: 14px;
    color: var(--lp-ink-3);
    line-height: 1.7;
    margin-bottom: 28px;
}
.lp-system-card--dark .lp-system-card__body { color: var(--lp-text-inv-2); }

.lp-check-list {
    list-style: none;
    padding: 0; margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.lp-check-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 500;
    color: var(--lp-ink-2);
}
.lp-check-list li i { color: var(--lp-teal); font-size: 16px; flex-shrink: 0; }
.lp-check-list--inv li { color: rgba(242,242,238,0.75); }

/* =======================================================
   FEATURE PILLARS
   ======================================================= */
.lp-pillars-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-top: 56px;
}
@media (max-width: 768px) { .lp-pillars-grid { grid-template-columns: 1fr; } }

.lp-pillar {
    background: var(--lp-white);
    border: 1px solid var(--lp-border);
    border-radius: var(--lp-r-lg);
    padding: 40px 36px;
    position: relative;
    overflow: hidden;
    transition: box-shadow 0.25s, transform 0.25s;
}
.lp-pillar:hover { box-shadow: var(--lp-shadow-hover); transform: translateY(-3px); }
.lp-pillar::before {
    content: attr(data-num);
    position: absolute;
    top: -16px; right: 24px;
    font-family: var(--lp-font);
    font-size: 100px;
    font-weight: 800;
    color: rgba(11,11,20,0.025);
    line-height: 1;
    pointer-events: none;
    user-select: none;
}
.lp-pillar__icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    background: var(--lp-cream);
    border: 1px solid var(--lp-border-2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: var(--lp-ink-2);
    margin-bottom: 24px;
}
.lp-pillar__title {
    font-size: 20px;
    font-weight: 800;
    letter-spacing: -0.015em;
    color: var(--lp-ink);
    margin-bottom: 10px;
    line-height: 1.2;
}
.lp-pillar__sub {
    font-size: 14px;
    color: var(--lp-ink-3);
    line-height: 1.7;
    margin-bottom: 28px;
}
.lp-pillar__list {
    list-style: none;
    padding: 0; margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.lp-pillar__list li {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 13px;
    font-weight: 500;
    color: var(--lp-ink-3);
}
.lp-pillar__list li::before {
    content: '';
    width: 5px; height: 5px;
    border-radius: 50%;
    background: var(--lp-teal);
    flex-shrink: 0;
    margin-top: 6px;
}

/* =======================================================
   COMPARISON
   ======================================================= */
.lp-compare-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 56px;
}
@media (max-width: 768px) { .lp-compare-grid { grid-template-columns: 1fr; } }

.lp-compare-side {
    background: var(--lp-white);
    border: 1px solid var(--lp-border);
    border-radius: var(--lp-r-lg);
    padding: 36px 32px;
}
.lp-compare-side--dark {
    background: var(--lp-ink);
    border-color: transparent;
}
.lp-compare-side__label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--lp-ink-4);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.lp-compare-side__label--inv { color: rgba(255,255,255,0.35); }
.lp-compare-side__title {
    font-size: 20px;
    font-weight: 800;
    color: var(--lp-ink);
    margin-bottom: 28px;
    line-height: 1.25;
}
.lp-compare-side--dark .lp-compare-side__title { color: var(--lp-text-inv); }

.lp-compare-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 11px 0;
    border-bottom: 1px solid var(--lp-border);
    font-size: 14px;
}
.lp-compare-row:last-of-type { border-bottom: none; }
.lp-compare-side--dark .lp-compare-row { border-color: rgba(255,255,255,0.06); }
.lp-compare-row__tool { color: var(--lp-ink-2); }
.lp-compare-side--dark .lp-compare-row__tool { color: rgba(255,255,255,0.55); }
.lp-compare-row__cost { font-weight: 700; color: #DC2626; }
.lp-compare-side--dark .lp-compare-row__cost { color: rgba(255,255,255,0.9); font-weight: 600; }
.lp-compare-row__check { color: var(--lp-teal); font-size: 16px; }

.lp-compare-total {
    margin-top: 20px;
    padding: 16px 20px;
    border-radius: var(--lp-r);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.lp-compare-total--bad { background: rgba(220,38,38,0.06); border: 1px solid rgba(220,38,38,0.12); }
.lp-compare-total--good { background: var(--lp-teal-bg); border: 1px solid var(--lp-teal-bd); }
.lp-compare-total__lbl { font-size: 13px; font-weight: 500; color: var(--lp-ink-3); }
.lp-compare-total--good .lp-compare-total__lbl { color: rgba(255,255,255,0.6); }
.lp-compare-total__amt { font-size: 22px; font-weight: 800; letter-spacing: -0.02em; }
.lp-compare-total--bad  .lp-compare-total__amt { color: #DC2626; }
.lp-compare-total--good .lp-compare-total__amt { color: var(--lp-teal); }

.lp-compare-notes {
    list-style: none;
    padding: 0; margin: 20px 0 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.lp-compare-notes li {
    font-size: 13px;
    color: var(--lp-ink-3);
    display: flex;
    align-items: center;
    gap: 8px;
}
.lp-compare-notes--inv li { color: rgba(255,255,255,0.55); }
.lp-compare-notes li i { font-size: 14px; }

/* =======================================================
   PRICING
   ======================================================= */
.lp-pricing-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-top: 56px;
    align-items: start;
}
@media (max-width: 992px) { .lp-pricing-grid { grid-template-columns: 1fr; max-width: 480px; } }

.lp-price-card {
    background: var(--lp-white);
    border: 1px solid var(--lp-border);
    border-radius: var(--lp-r-lg);
    padding: 36px 32px;
    position: relative;
    transition: box-shadow 0.25s, transform 0.25s;
}
.lp-price-card:hover { box-shadow: var(--lp-shadow-hover); transform: translateY(-3px); }
.lp-price-card--pop {
    background: var(--lp-ink);
    border-color: transparent;
    padding-top: 24px;
}
.lp-price-card--pop:hover { box-shadow: 0 2px 6px rgba(11,11,20,0.2), 0 20px 60px rgba(11,11,20,0.35); }

.lp-price-card__badge {
    display: inline-flex;
    align-items: center;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    background: var(--lp-teal);
    color: #fff;
    padding: 5px 14px;
    border-radius: var(--lp-r-pill);
    margin-bottom: 20px;
}
.lp-price-card__name {
    font-size: 15px;
    font-weight: 700;
    color: var(--lp-ink);
    margin-bottom: 6px;
}
.lp-price-card--pop .lp-price-card__name { color: rgba(255,255,255,0.7); }
.lp-price-card__desc {
    font-size: 13px;
    color: var(--lp-ink-3);
    line-height: 1.55;
    margin-bottom: 28px;
}
.lp-price-card--pop .lp-price-card__desc { color: rgba(255,255,255,0.45); }

.lp-price-card__price-wrap { margin-bottom: 28px; padding-bottom: 24px; border-bottom: 1px solid var(--lp-border); }
.lp-price-card--pop .lp-price-card__price-wrap { border-color: rgba(255,255,255,0.08); }
.lp-price-card__amount {
    font-size: 46px;
    font-weight: 800;
    letter-spacing: -0.04em;
    color: var(--lp-ink);
    line-height: 1;
    display: flex;
    align-items: flex-start;
    gap: 3px;
}
.lp-price-card--pop .lp-price-card__amount { color: var(--lp-text-inv); }
.lp-price-card__curr { font-size: 20px; font-weight: 700; margin-top: 8px; }
.lp-price-card__period {
    font-size: 13px;
    color: var(--lp-ink-4);
    margin-top: 6px;
}
.lp-price-card--pop .lp-price-card__period { color: rgba(255,255,255,0.35); }

.lp-price-card__features {
    list-style: none;
    padding: 0; margin: 0 0 28px;
    display: flex;
    flex-direction: column;
    gap: 11px;
}
.lp-price-card__features li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 14px;
    color: var(--lp-ink-2);
}
.lp-price-card--pop .lp-price-card__features li { color: rgba(242,242,238,0.7); }
.lp-price-card__features li i { color: var(--lp-teal); font-size: 16px; flex-shrink: 0; margin-top: 1px; }

.lp-price-card__cta { width: 100%; justify-content: center; }

/* pricing toggle */
.lp-toggle-wrap {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: var(--lp-white);
    border: 1px solid var(--lp-border-2);
    border-radius: var(--lp-r-pill);
    padding: 6px 16px;
    margin-top: 20px;
}
.lp-toggle-lbl {
    font-size: 14px;
    font-weight: 500;
    color: var(--lp-ink-3);
    cursor: pointer;
}
.lp-toggle-lbl.on { color: var(--lp-ink); font-weight: 600; }
.lp-toggle-sw {
    width: 44px; height: 24px;
    background: var(--lp-border-2);
    border-radius: 12px;
    cursor: pointer;
    position: relative;
    border: none;
    padding: 0;
    transition: background 0.25s;
}
.lp-toggle-sw.on { background: var(--lp-ink); }
.lp-toggle-sw::after {
    content: '';
    position: absolute;
    top: 3px; left: 3px;
    width: 18px; height: 18px;
    border-radius: 50%;
    background: #fff;
    transition: transform 0.25s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.15);
}
.lp-toggle-sw.on::after { transform: translateX(20px); }
.lp-save-pill {
    font-size: 11px;
    font-weight: 700;
    background: var(--lp-teal);
    color: #fff;
    padding: 2px 10px;
    border-radius: 20px;
}

.price-monthly { display: block; }
.price-annual  { display: none; }
body.lp-annual .price-monthly { display: none; }
body.lp-annual .price-annual  { display: block; }

/* =======================================================
   PULL QUOTE / MANIFESTO
   ======================================================= */
.lp-pull-quote {
    text-align: center;
    max-width: 760px;
    margin: 0 auto;
    padding: 0 20px;
}
.lp-pull-quote__text {
    font-size: clamp(22px, 3vw, 36px);
    font-weight: 700;
    color: var(--lp-ink);
    line-height: 1.4;
    letter-spacing: -0.015em;
    position: relative;
}
.lp-pull-quote__text::before {
    content: '"';
    font-size: 80px;
    line-height: 0;
    color: var(--lp-border-2);
    position: absolute;
    top: 20px; left: -20px;
    font-family: Georgia, serif;
}
.lp-pull-quote__attr {
    margin-top: 20px;
    font-size: 14px;
    color: var(--lp-ink-4);
}

/* =======================================================
   TESTIMONIALS
   ======================================================= */
.lp-testi-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-top: 56px;
}
@media (max-width: 992px) { .lp-testi-grid { grid-template-columns: 1fr; } }

.lp-tcard {
    background: var(--lp-dark-2);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: var(--lp-r-lg);
    padding: 36px 32px;
    position: relative;
    transition: border-color 0.25s, transform 0.25s;
}
.lp-tcard:hover { border-color: rgba(255,255,255,0.12); transform: translateY(-3px); }
.lp-tcard__stars {
    color: #F59E0B;
    font-size: 14px;
    letter-spacing: 2px;
    display: block;
    margin-bottom: 18px;
}
.lp-tcard__body {
    font-size: 15px;
    color: rgba(242,242,238,0.75);
    line-height: 1.7;
    margin-bottom: 28px;
    position: relative;
}
.lp-tcard__author {
    display: flex;
    align-items: center;
    gap: 12px;
    border-top: 1px solid rgba(255,255,255,0.06);
    padding-top: 20px;
}
.lp-tcard__av {
    width: 40px; height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
    color: var(--lp-dark);
    flex-shrink: 0;
}
.lp-tcard__name { font-size: 14px; font-weight: 700; color: var(--lp-text-inv); }
.lp-tcard__biz { font-size: 12px; color: var(--lp-text-inv-2); margin-top: 2px; }

/* =======================================================
   FAQ
   ======================================================= */
.lp-faq-wrap { max-width: 680px; margin: 56px auto 0; }

.lp-faq-item {
    border-bottom: 1px solid var(--lp-border);
    padding: 0;
}
.lp-faq-item:first-child { border-top: 1px solid var(--lp-border); }
.lp-faq-btn {
    width: 100%;
    background: none;
    border: none;
    padding: 24px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    cursor: pointer;
    text-align: left;
    font-family: var(--lp-font);
    font-size: 16px;
    font-weight: 700;
    color: var(--lp-ink);
    line-height: 1.3;
}
.lp-faq-btn:focus { outline: none; }
.lp-faq-icon {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: var(--lp-cream);
    border: 1px solid var(--lp-border-2);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: var(--lp-ink-3);
    font-size: 16px;
    transition: background 0.2s, transform 0.25s;
}
.lp-faq-item.open .lp-faq-icon {
    background: var(--lp-ink);
    color: #fff;
    border-color: transparent;
    transform: rotate(45deg);
}
.lp-faq-body {
    display: none;
    padding: 0 0 24px;
    font-size: 15px;
    color: var(--lp-ink-3);
    line-height: 1.7;
}
.lp-faq-item.open .lp-faq-body { display: block; }

/* =======================================================
   FINAL CTA
   ======================================================= */
.lp-cta-section {
    background: var(--lp-dark);
    padding: var(--lp-sp) 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.lp-cta-section::before {
    content: '';
    position: absolute;
    bottom: -200px; left: 50%;
    transform: translateX(-50%);
    width: 700px; height: 700px;
    background: radial-gradient(circle, rgba(0,164,140,0.08) 0%, transparent 65%);
    pointer-events: none;
}
.lp-cta-section__inner { position: relative; z-index: 2; }
.lp-cta-section__ctas {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 36px;
}
.lp-cta-section__note {
    margin-top: 20px;
    font-size: 13px;
    color: rgba(255,255,255,0.3);
}
.lp-cta-section__note span { margin: 0 8px; }

/* Trust logos row */
.lp-trust-row {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px 28px;
    margin-top: 48px;
}
.lp-trust-item {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 13px;
    font-weight: 500;
    color: rgba(255,255,255,0.4);
}
.lp-trust-item i { font-size: 16px; color: rgba(255,255,255,0.25); }

/* =======================================================
   ADD-ONS
   ======================================================= */
.lp-addons-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 56px;
}
@media (max-width: 768px) { .lp-addons-grid { grid-template-columns: 1fr; } }

.lp-addon-card {
    background: var(--lp-white);
    border: 1px solid var(--lp-border);
    border-radius: var(--lp-r-lg);
    padding: 40px 36px;
    position: relative;
    overflow: hidden;
    transition: box-shadow 0.25s, transform 0.25s;
}
.lp-addon-card:hover {
    box-shadow: var(--lp-shadow-hover);
    transform: translateY(-3px);
}
.lp-addon-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #F59E0B, #FBBF24);
}

.lp-addon-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #92400E;
    background: rgba(245,158,11,0.10);
    border: 1px solid rgba(245,158,11,0.22);
    border-radius: var(--lp-r-pill);
    padding: 5px 14px;
    margin-bottom: 24px;
}
.lp-addon-badge i { font-size: 13px; color: #F59E0B; }

.lp-addon-card__icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    background: rgba(245,158,11,0.08);
    border: 1px solid rgba(245,158,11,0.18);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #D97706;
    margin-bottom: 22px;
}
.lp-addon-card__title {
    font-size: 20px;
    font-weight: 800;
    letter-spacing: -0.015em;
    color: var(--lp-ink);
    margin-bottom: 10px;
    line-height: 1.25;
}
.lp-addon-card__sub {
    font-size: 14px;
    color: var(--lp-ink-3);
    line-height: 1.7;
    margin-bottom: 28px;
}
.lp-addon-card__list {
    list-style: none;
    padding: 0; margin: 0 0 32px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.lp-addon-card__list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 14px;
    font-weight: 500;
    color: var(--lp-ink-2);
}
.lp-addon-card__list li i { color: #D97706; font-size: 16px; flex-shrink: 0; margin-top: 1px; }

.lp-addon-card__cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--lp-ink-2);
    border: 1.5px solid var(--lp-border-2);
    border-radius: var(--lp-r-pill);
    padding: 11px 22px;
    text-decoration: none;
    transition: all 0.2s;
}
.lp-addon-card__cta:hover {
    background: var(--lp-ink);
    color: #fff;
    border-color: var(--lp-ink);
    text-decoration: none;
    transform: translateY(-1px);
}
</style>
@endpush

@section('content')

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="lp-hero lp-bg-cream">
    <div class="container">

        <div class="lp-hero__top">
            <div data-aos="fade-down" data-aos-duration="500">
                <span class="lp-tag">
                    <span class="lp-tag__dot"></span>
                    Built for South African service businesses
                </span>
            </div>

            <h1 class="lp-h1" data-aos="fade-up" data-aos-delay="60" data-aos-duration="600">
                Stop Running Your Business<br>
                on <span class="lp-u">WhatsApp</span> & Spreadsheets
            </h1>

            <p class="lp-lead" data-aos="fade-up" data-aos-delay="120" data-aos-duration="600">
                The all-in-one system for high-performing service pros.<br>
                Leads. Quotes. Jobs. Invoices. All connected. All automated.
            </p>

            <div class="lp-hero__ctas" data-aos="fade-up" data-aos-delay="180" data-aos-duration="600">
                <a href="{{ url('/contact') }}" class="lp-btn lp-btn-ink lp-btn-lg">
                    Book a Demo
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="#how-it-works" class="lp-btn lp-btn-text lp-btn-lg">
                    See how it works
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                </a>
            </div>

            <p class="lp-hero__note" data-aos="fade-up" data-aos-delay="240">
                No contracts <span>·</span> Live in 48 hours <span>·</span> Unlimited team members
            </p>
        </div>

        <!-- Browser Mockup -->
        <div class="lp-mock" data-aos="fade-up" data-aos-delay="300" data-aos-duration="700">
            <div class="lp-mock__bar">
                <div class="lp-mock__dots">
                    <div class="lp-mock__dot"></div>
                    <div class="lp-mock__dot"></div>
                    <div class="lp-mock__dot"></div>
                </div>
                <div class="lp-mock__url">app.useluminii.com — Dashboard</div>
            </div>
            <div class="lp-mock__body">
                <div class="lp-dash__header">
                    <span class="lp-dash__title">Today's Pipeline</span>
                    <span class="lp-dash__date">Saturday, 3 May 2025</span>
                </div>
                <div class="lp-dash__stats">
                    <div class="lp-dash__stat">
                        <span class="lp-dash__stat-val">3</span>
                        <span class="lp-dash__stat-lbl">New Leads</span>
                    </div>
                    <div class="lp-dash__stat">
                        <span class="lp-dash__stat-val">7</span>
                        <span class="lp-dash__stat-lbl">Quotes Sent</span>
                    </div>
                    <div class="lp-dash__stat">
                        <span class="lp-dash__stat-val">12</span>
                        <span class="lp-dash__stat-lbl">Active Jobs</span>
                    </div>
                    <div class="lp-dash__stat lp-dash__stat--teal">
                        <span class="lp-dash__stat-val">R8,400</span>
                        <span class="lp-dash__stat-lbl">Collected Today</span>
                    </div>
                </div>
                <div class="lp-dash__feed">
                    <div class="lp-dash__item">
                        <div class="lp-dash__icon lp-dash__icon--lead"><i class="ph ph-user-circle-plus"></i></div>
                        <div class="lp-dash__item-text">
                            <div class="lp-dash__item-title">Sarah Mitchell — Pool &amp; patio cleaning</div>
                            <div class="lp-dash__item-sub">Cape Town, Gardens · Enquiry via website · 4 min ago</div>
                        </div>
                        <span class="lp-dash__item-badge lp-dash__item-badge--new">New lead</span>
                    </div>
                    <div class="lp-dash__item">
                        <div class="lp-dash__icon lp-dash__icon--quote"><i class="ph ph-file-text"></i></div>
                        <div class="lp-dash__item-text">
                            <div class="lp-dash__item-title">Quote #1047 — R2,400 / month</div>
                            <div class="lp-dash__item-sub">Auto-sent to Sarah M. · 2 min after enquiry · Awaiting approval</div>
                        </div>
                        <span class="lp-dash__item-badge lp-dash__item-badge--sent">Awaiting</span>
                    </div>
                    <div class="lp-dash__item">
                        <div class="lp-dash__icon lp-dash__icon--paid"><i class="ph ph-receipt"></i></div>
                        <div class="lp-dash__item-text">
                            <div class="lp-dash__item-title">Invoice #1031 paid — R3,200</div>
                            <div class="lp-dash__item-sub">James W. · EFT · Auto-sent on job completion · 1 hr ago</div>
                        </div>
                        <span class="lp-dash__item-badge lp-dash__item-badge--paid">Paid ✓</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ============================================================
     STATS BAR
     ============================================================ -->
<div class="lp-stats-bar">
    <div class="container">
        <div class="lp-stats-bar__inner">
            <div class="lp-stat-item" data-aos="fade-up" data-aos-delay="0">
                <span class="lp-stat-item__num"><em class="lp-counter" data-target="500">0</em>+</span>
                <span class="lp-stat-item__lbl">Service businesses using Luminii</span>
            </div>
            <div class="lp-stat-item" data-aos="fade-up" data-aos-delay="60">
                <span class="lp-stat-item__num">R<em class="lp-counter" data-target="50">0</em>M+</span>
                <span class="lp-stat-item__lbl">In quotes processed</span>
            </div>
            <div class="lp-stat-item" data-aos="fade-up" data-aos-delay="120">
                <span class="lp-stat-item__num"><em class="lp-counter" data-target="48">0</em>hrs</span>
                <span class="lp-stat-item__lbl">Average setup time</span>
            </div>
            <div class="lp-stat-item" data-aos="fade-up" data-aos-delay="180">
                <span class="lp-stat-item__num"><em class="lp-counter" data-target="12">0</em>hrs</span>
                <span class="lp-stat-item__lbl">Saved per week, per owner</span>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     PAIN SECTION
     ============================================================ -->
<section class="lp-section lp-bg-white" id="features">
    <div class="container">

        <div data-aos="fade-up" data-aos-duration="600">
            <div class="lp-eyebrow">
                <span class="lp-eyebrow__dot"></span> Sound familiar?
            </div>
            <h2 class="lp-h2" style="max-width:560px;">
                If your business runs on chaos,<br>you're leaving money on the table
            </h2>
            <p class="lp-lead" style="max-width:500px;margin-bottom:0;">
                You're not the problem. Your tools — or the lack of them — are.
            </p>
        </div>

        <div class="lp-pain__grid">

            <div class="lp-pain-card" data-aos="fade-up" data-aos-delay="0">
                <span class="lp-pain-card__num">01</span>
                <i class="lp-pain-card__icon ph ph-chat-circle-slash"></i>
                <h3 class="lp-pain-card__title">Leads fall into a WhatsApp black hole</h3>
                <p class="lp-pain-card__body">You're on a job. A lead messages you. Hours pass. They've already booked someone else. Every missed message is missed revenue.</p>
            </div>

            <div class="lp-pain-card" data-aos="fade-up" data-aos-delay="60">
                <span class="lp-pain-card__num">02</span>
                <i class="lp-pain-card__icon ph ph-clock-countdown"></i>
                <h3 class="lp-pain-card__title">Quotes take days — and still get ignored</h3>
                <p class="lp-pain-card__body">You spend an hour building a quote in Google Docs. Send it. Hear nothing. The fastest business wins — and it's rarely you.</p>
            </div>

            <div class="lp-pain-card" data-aos="fade-up" data-aos-delay="120">
                <span class="lp-pain-card__num">03</span>
                <i class="lp-pain-card__icon ph ph-warning-circle"></i>
                <h3 class="lp-pain-card__title">Jobs tracked in your head. Teams managed via group chat.</h3>
                <p class="lp-pain-card__body">No real-time visibility means mistakes, missed jobs, and frustrated clients. Your team is always asking "what's next?"</p>
            </div>

            <div class="lp-pain-card" data-aos="fade-up" data-aos-delay="180">
                <span class="lp-pain-card__num">04</span>
                <i class="lp-pain-card__icon ph ph-currency-circle-dollar"></i>
                <h3 class="lp-pain-card__title">Chasing invoices at 9pm via text message</h3>
                <p class="lp-pain-card__body">Cash flow problems don't come from bad work — they come from bad billing. Every day you wait to invoice is a day you don't get paid.</p>
            </div>

            <div class="lp-pain-card" data-aos="fade-up" data-aos-delay="240">
                <span class="lp-pain-card__num">05</span>
                <i class="lp-pain-card__icon ph ph-puzzle-piece"></i>
                <h3 class="lp-pain-card__title">Six subscriptions. None of them talk to each other.</h3>
                <p class="lp-pain-card__body">Website here. CRM there. Quoting tool somewhere else. You're the glue between six systems, manually copying data between all of them.</p>
            </div>

            <div class="lp-pain-card" data-aos="fade-up" data-aos-delay="300">
                <span class="lp-pain-card__num">06</span>
                <i class="lp-pain-card__icon ph ph-trend-up"></i>
                <h3 class="lp-pain-card__title">Every new hire costs you more — permanently</h3>
                <p class="lp-pain-card__body">Per-user pricing means your software bill grows every time your team does. Platforms like Jobber charge extra per user. Your growth gets taxed.</p>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================
     PULL QUOTE / MANIFESTO
     ============================================================ -->
<section class="lp-section-sm lp-bg-cream">
    <div class="container">
        <div class="lp-pull-quote" data-aos="fade-up" data-aos-duration="700">
            <p class="lp-pull-quote__text">
                Most service business owners spend their evenings on admin that should happen automatically. Luminii changes that.
            </p>
            <p class="lp-pull-quote__attr">— The Luminii principle</p>
        </div>
    </div>
</section>

<hr class="lp-rule">

<!-- ============================================================
     HOW IT WORKS (PROCESS)
     ============================================================ -->
<section class="lp-section lp-bg-white" id="how-it-works">
    <div class="container">

        <div data-aos="fade-up" data-aos-duration="600">
            <div class="lp-eyebrow">
                <span class="lp-eyebrow__dot"></span> How it works
            </div>
            <h2 class="lp-h2" style="max-width:540px;">
                From first enquiry to final payment. Automatically.
            </h2>
            <p class="lp-lead" style="max-width:500px;margin-bottom:0;">
                Luminii connects every step of your business into one automated flow. This is what running a modern service business looks like.
            </p>
        </div>

        <div class="lp-process__steps" data-aos="fade-up" data-aos-delay="100" data-aos-duration="700">

            <div class="lp-process__step">
                <div class="lp-process__num">01</div>
                <div class="lp-process__content">
                    <span class="lp-process__label">Lead Captured</span>
                    <h4 class="lp-process__title">Enquiry comes in. You don't lift a finger.</h4>
                    <p class="lp-process__body">A visitor fills your smart contact form or chats with your AI Receptionist. Their details land in your CRM — instantly.</p>
                </div>
            </div>

            <div class="lp-process__step">
                <div class="lp-process__num">02</div>
                <div class="lp-process__content">
                    <span class="lp-process__label">Quote Sent</span>
                    <h4 class="lp-process__title">A branded quote goes out in under 2 minutes.</h4>
                    <p class="lp-process__body">Review the pre-built quote, make adjustments, hit send — before your competitor even calls back.</p>
                </div>
            </div>

            <div class="lp-process__step">
                <div class="lp-process__num">03</div>
                <div class="lp-process__content">
                    <span class="lp-process__label">Client Approves</span>
                    <h4 class="lp-process__title">One click. Job confirmed. No back-and-forth.</h4>
                    <p class="lp-process__body">The client approves online. The job is instantly created in your system and added to the schedule.</p>
                </div>
            </div>

            <div class="lp-process__step">
                <div class="lp-process__num">04</div>
                <div class="lp-process__content">
                    <span class="lp-process__label">Job Managed</span>
                    <h4 class="lp-process__title">Your team knows exactly where to be and when.</h4>
                    <p class="lp-process__body">Assign jobs, add checklists, track status in real time. No WhatsApp groups needed.</p>
                </div>
            </div>

            <div class="lp-process__step">
                <div class="lp-process__num lp-process__num--teal">05</div>
                <div class="lp-process__content">
                    <span class="lp-process__label">Invoice &amp; Payment</span>
                    <h4 class="lp-process__title">Job done. Invoice out. Payment in. Automatically.</h4>
                    <p class="lp-process__body">Mark it complete — Luminii sends the invoice. Clients pay online. Reminders handle the rest. No chasing. Ever.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================
     THE TWO-PART SYSTEM
     ============================================================ -->
<section class="lp-section lp-bg-cream">
    <div class="container">

        <div data-aos="fade-up" data-aos-duration="600">
            <div class="lp-eyebrow">
                <span class="lp-eyebrow__dot"></span> The complete system
            </div>
            <h2 class="lp-h2" style="max-width:540px;">
                A website that wins.<br>A system that scales.
            </h2>
            <p class="lp-lead" style="max-width:520px;margin-bottom:0;">
                Most businesses have one or the other. Luminii gives you both — fully connected, working together from day one.
            </p>
        </div>

        <div class="lp-system-grid">

            <div class="lp-system-card" data-aos="fade-right" data-aos-duration="600">
                <div class="lp-system-card__part">
                    <span class="lp-system-card__part__line"></span>
                    Part 1 — Smart Website
                </div>
                <i class="lp-system-card__icon ph ph-desktop"></i>
                <h3 class="lp-h3">Your 24/7 digital sales machine</h3>
                <p class="lp-system-card__body">Your website isn't just a brochure — it's your highest-performing sales rep. It captures enquiries, responds in seconds, and books jobs around the clock.</p>
                <ul class="lp-check-list">
                    <li><i class="ph ph-check-circle"></i> High-converting design built to win bookings</li>
                    <li><i class="ph ph-check-circle"></i> AI Receptionist responds to every enquiry in &lt;30 seconds</li>
                    <li><i class="ph ph-check-circle"></i> Smart lead forms that pre-qualify clients automatically</li>
                    <li><i class="ph ph-check-circle"></i> SEO-built from day one — clients find you, not your competitor</li>
                    <li><i class="ph ph-check-circle"></i> Fully integrated — zero manual data entry</li>
                </ul>
            </div>

            <div class="lp-system-card lp-system-card--dark" data-aos="fade-left" data-aos-duration="600">
                <div class="lp-system-card__part lp-system-card__part--inv">
                    <span class="lp-system-card__part__line" style="background:rgba(0,164,140,0.3)"></span>
                    Part 2 — Smart CRM
                </div>
                <i class="lp-system-card__icon ph ph-chart-line-up"></i>
                <h3 class="lp-h3 lp-h3--inv">Your business running itself</h3>
                <p class="lp-system-card__body lp-system-card--dark">Every lead gets managed, quoted, scheduled, and invoiced — automatically. No spreadsheets. No dropped balls. Just a business that runs.</p>
                <ul class="lp-check-list lp-check-list--inv">
                    <li><i class="ph ph-check-circle"></i> Lead pipeline with full client history</li>
                    <li><i class="ph ph-check-circle"></i> Professional quotes generated in under 2 minutes</li>
                    <li><i class="ph ph-check-circle"></i> Job scheduling with team assignment &amp; tracking</li>
                    <li><i class="ph ph-check-circle"></i> Auto-invoicing the moment a job is complete</li>
                    <li><i class="ph ph-check-circle"></i> Real-time dashboard — know your numbers, always</li>
                </ul>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================
     FEATURE PILLARS
     ============================================================ -->
<section class="lp-section lp-bg-white">
    <div class="container">

        <div data-aos="fade-up" data-aos-duration="600">
            <div class="lp-eyebrow">
                <span class="lp-eyebrow__dot"></span> What Luminii does
            </div>
            <h2 class="lp-h2" style="max-width:540px;">
                One system. Four transformations.<br>Not four more subscriptions.
            </h2>
        </div>

        <div class="lp-pillars-grid">

            <div class="lp-pillar" data-num="01" data-aos="fade-up" data-aos-delay="0" data-aos-duration="600">
                <div class="lp-pillar__icon"><i class="ph ph-globe"></i></div>
                <h3 class="lp-pillar__title">Your website that never sleeps</h3>
                <p class="lp-pillar__sub">While you're on the tools, your website is closing jobs. It captures enquiries, responds in seconds, and qualifies leads automatically — 24 hours a day, 7 days a week.</p>
                <ul class="lp-pillar__list">
                    <li>AI Receptionist responds to every enquiry in under 30 seconds</li>
                    <li>High-converting design — built to book jobs, not just look good</li>
                    <li>Smart contact forms that pre-qualify leads before they reach you</li>
                    <li>SEO-built from day one — so clients find you, not your competitor</li>
                </ul>
            </div>

            <div class="lp-pillar" data-num="02" data-aos="fade-up" data-aos-delay="80" data-aos-duration="600">
                <div class="lp-pillar__icon"><i class="ph ph-file-text"></i></div>
                <h3 class="lp-pillar__title">Win the quote. Win the job.</h3>
                <p class="lp-pillar__sub">The first business to send a professional quote usually wins. Luminii gets yours out in under 2 minutes — polished, branded, with online approval built in.</p>
                <ul class="lp-pillar__list">
                    <li>Generate a professional, branded quote in under 2 minutes</li>
                    <li>Clients approve online — no printing, no back-and-forth</li>
                    <li>Automatic follow-up sequences bring cold quotes back to life</li>
                    <li>Track your win rate — know what's working, fix what isn't</li>
                </ul>
            </div>

            <div class="lp-pillar" data-num="03" data-aos="fade-up" data-aos-delay="0" data-aos-duration="600">
                <div class="lp-pillar__icon"><i class="ph ph-calendar-check"></i></div>
                <h3 class="lp-pillar__title">Every job tracked. Nothing dropped.</h3>
                <p class="lp-pillar__sub">As your business grows, so does the complexity. Luminii is the system that keeps everything aligned — your team knows what to do, where to be, and what's expected.</p>
                <ul class="lp-pillar__list">
                    <li>Drag-and-drop job scheduling — assign in seconds, not minutes</li>
                    <li>Your team sees their tasks — no WhatsApp group needed</li>
                    <li>Real-time job status from field to office, instantly</li>
                    <li>Photos, notes, and checklists logged per job, every client</li>
                </ul>
            </div>

            <div class="lp-pillar" data-num="04" data-aos="fade-up" data-aos-delay="80" data-aos-duration="600">
                <div class="lp-pillar__icon"><i class="ph ph-receipt"></i></div>
                <h3 class="lp-pillar__title">Cash flows in. Chasing stops.</h3>
                <p class="lp-pillar__sub">The last mile of business — getting paid — should require zero effort. Luminii invoices automatically, accepts payment online, and handles reminders so you never chase again.</p>
                <ul class="lp-pillar__list">
                    <li>Invoice auto-sent the moment a job is marked complete</li>
                    <li>Clients pay online — card, EFT, or instant payment links</li>
                    <li>Automated reminders replace late-night WhatsApp follow-ups</li>
                    <li>Live cash flow dashboard — always know where your money is</li>
                </ul>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================
     ADD-ONS
     ============================================================ -->
<section class="lp-section lp-bg-cream">
    <div class="container">

        <div data-aos="fade-up" data-aos-duration="600">
            <div class="lp-eyebrow">
                <span class="lp-eyebrow__dot" style="background:#F59E0B;"></span>
                <span style="color:#92400E;">Power-ups</span>
            </div>
            <h2 class="lp-h2" style="max-width:560px;">
                Go further with optional add-ons
            </h2>
            <p class="lp-lead" style="max-width:520px;margin-bottom:0;">
                Luminii's core system runs your operations end to end. These add-ons extend it into the parts of your business that most platforms ignore entirely.
            </p>
        </div>

        <div class="lp-addons-grid">

            <!-- Finance Management -->
            <div class="lp-addon-card" data-aos="fade-right" data-aos-duration="600">
                <span class="lp-addon-badge">
                    <i class="ph ph-plus-circle"></i> Add-on
                </span>
                <div class="lp-addon-card__icon"><i class="ph ph-chart-pie-slice"></i></div>
                <h3 class="lp-addon-card__title">Finance Management</h3>
                <p class="lp-addon-card__sub">
                    Know your numbers — without needing an accountant for every question. Track every rand in and out, run payroll for your team, and see exactly how profitable your business really is.
                </p>
                <ul class="lp-addon-card__list">
                    <li><i class="ph ph-check-circle"></i> Expense tracking with category breakdown</li>
                    <li><i class="ph ph-check-circle"></i> Payroll management — calculate, record, pay</li>
                    <li><i class="ph ph-check-circle"></i> Profit &amp; Loss reports — monthly and annual</li>
                    <li><i class="ph ph-check-circle"></i> Job costing — know your margin per job</li>
                    <li><i class="ph ph-check-circle"></i> Tax-ready financial summaries</li>
                </ul>
                <a href="{{ url('/contact') }}" class="lp-addon-card__cta">
                    Ask about this add-on
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Compliance & Filing -->
            <div class="lp-addon-card" data-aos="fade-left" data-aos-duration="600">
                <span class="lp-addon-badge">
                    <i class="ph ph-plus-circle"></i> Add-on
                </span>
                <div class="lp-addon-card__icon"><i class="ph ph-stamp"></i></div>
                <h3 class="lp-addon-card__title">Compliance &amp; Filing</h3>
                <p class="lp-addon-card__sub">
                    Stay compliant with CIPC and SARS — without the last-minute panic. Luminii tracks your deadlines, prepares your submissions, and keeps your records audit-ready, all year round.
                </p>
                <ul class="lp-addon-card__list">
                    <li><i class="ph ph-check-circle"></i> CIPC annual return preparation &amp; filing</li>
                    <li><i class="ph ph-check-circle"></i> SARS VAT &amp; income tax report generation</li>
                    <li><i class="ph ph-check-circle"></i> Compliance calendar with automatic deadline reminders</li>
                    <li><i class="ph ph-check-circle"></i> Secure document storage for audit readiness</li>
                    <li><i class="ph ph-check-circle"></i> Company registration &amp; secretarial records</li>
                </ul>
                <a href="{{ url('/contact') }}" class="lp-addon-card__cta">
                    Ask about this add-on
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

        </div>
    </div>
</section>

<hr class="lp-rule">

<!-- ============================================================
     COMPARISON
     ============================================================ -->
<section class="lp-section lp-bg-cream">
    <div class="container">

        <div data-aos="fade-up" data-aos-duration="600">
            <div class="lp-eyebrow">
                <span class="lp-eyebrow__dot"></span> The real cost
            </div>
            <h2 class="lp-h2" style="max-width:540px;">
                "Just making it work" is quietly draining you
            </h2>
            <p class="lp-lead" style="max-width:520px;margin-bottom:0;">
                Add up what you're spending across fragmented tools — then see what one connected system costs.
            </p>
        </div>

        <div class="lp-compare-grid">

            <div class="lp-compare-side" data-aos="fade-right" data-aos-duration="600">
                <div class="lp-compare-side__label lp-compare-side__label">
                    <i class="ph ph-x-circle" style="color:#DC2626;font-size:16px;"></i>
                    The fragmented approach
                </div>
                <h3 class="lp-compare-side__title">What you're probably paying each month</h3>

                <div class="lp-compare-row"><span class="lp-compare-row__tool">Website builder / hosting</span><span class="lp-compare-row__cost">~R400</span></div>
                <div class="lp-compare-row"><span class="lp-compare-row__tool">CRM software</span><span class="lp-compare-row__cost">~R600</span></div>
                <div class="lp-compare-row"><span class="lp-compare-row__tool">Quoting tool</span><span class="lp-compare-row__cost">~R350</span></div>
                <div class="lp-compare-row"><span class="lp-compare-row__tool">Job scheduling app</span><span class="lp-compare-row__cost">~R450</span></div>
                <div class="lp-compare-row"><span class="lp-compare-row__tool">Invoicing software</span><span class="lp-compare-row__cost">~R300</span></div>

                <div class="lp-compare-total lp-compare-total--bad">
                    <span class="lp-compare-total__lbl">Tools only — before per-user fees</span>
                    <span class="lp-compare-total__amt">~R2,100/mo</span>
                </div>

                <ul class="lp-compare-notes" style="margin-top:20px;">
                    <li><i class="ph ph-x-circle" style="color:#DC2626;"></i> No AI Receptionist — leads go unanswered</li>
                    <li><i class="ph ph-x-circle" style="color:#DC2626;"></i> Nothing integrates — you're the glue</li>
                    <li><i class="ph ph-x-circle" style="color:#DC2626;"></i> Pay more as your team grows</li>
                    <li><i class="ph ph-x-circle" style="color:#DC2626;"></i> No single view of your business</li>
                </ul>
            </div>

            <div class="lp-compare-side lp-compare-side--dark" data-aos="fade-left" data-aos-duration="600">
                <div class="lp-compare-side__label lp-compare-side__label--inv">
                    <i class="ph ph-check-circle" style="color:var(--lp-teal);font-size:16px;"></i>
                    The Luminii way
                </div>
                <h3 class="lp-compare-side__title">Everything. One system. One flat bill.</h3>

                <div class="lp-compare-row"><span class="lp-compare-row__tool">Smart high-converting website</span><i class="lp-compare-row__check ph ph-check-circle"></i></div>
                <div class="lp-compare-row"><span class="lp-compare-row__tool">AI Receptionist (24/7)</span><i class="lp-compare-row__check ph ph-check-circle"></i></div>
                <div class="lp-compare-row"><span class="lp-compare-row__tool">Lead capture &amp; full CRM</span><i class="lp-compare-row__check ph ph-check-circle"></i></div>
                <div class="lp-compare-row"><span class="lp-compare-row__tool">Smart quote builder</span><i class="lp-compare-row__check ph ph-check-circle"></i></div>
                <div class="lp-compare-row"><span class="lp-compare-row__tool">Job scheduling &amp; team management</span><i class="lp-compare-row__check ph ph-check-circle"></i></div>
                <div class="lp-compare-row"><span class="lp-compare-row__tool">Automated invoicing &amp; payments</span><i class="lp-compare-row__check ph ph-check-circle"></i></div>
                <div class="lp-compare-row"><span class="lp-compare-row__tool">Unlimited team members</span><i class="lp-compare-row__check ph ph-check-circle"></i></div>

                <div class="lp-compare-total lp-compare-total--good">
                    <span class="lp-compare-total__lbl">Everything, starting from</span>
                    <span class="lp-compare-total__amt">R999/mo</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================
     PRICING
     ============================================================ -->
<section class="lp-section lp-bg-white" id="pricing">
    <div class="container">

        <div data-aos="fade-up" data-aos-duration="600">
            <div class="lp-eyebrow">
                <span class="lp-eyebrow__dot"></span> Pricing
            </div>
            <h2 class="lp-h2" style="max-width:560px;">
                Simple pricing. No surprises.<br>No per-user traps.
            </h2>
            <p class="lp-lead" style="max-width:500px;margin-bottom:16px;">
                Unlike platforms that charge per seat, Luminii is a flat monthly rate. Grow your team — your bill stays the same.
            </p>

            <!-- Toggle -->
            <div class="lp-toggle-wrap">
                <span class="lp-toggle-lbl on" id="lp-ml">Monthly</span>
                <button class="lp-toggle-sw" id="lp-ts" aria-label="Toggle billing"></button>
                <span class="lp-toggle-lbl" id="lp-al">
                    Annual &nbsp;<span class="lp-save-pill">Save 2 months</span>
                </span>
            </div>
        </div>

        <div class="lp-pricing-grid" data-aos="fade-up" data-aos-delay="100" data-aos-duration="700">

            <!-- Starter -->
            <div class="lp-price-card">
                <div class="lp-price-card__name">Starter</div>
                <p class="lp-price-card__desc">Smart website + AI Receptionist. The foundation that wins you jobs around the clock.</p>
                <div class="lp-price-card__price-wrap">
                    <div class="lp-price-card__amount price-monthly">
                        <span class="lp-price-card__curr">R</span>999
                    </div>
                    <div class="lp-price-card__amount price-annual" style="display:none;">
                        <span class="lp-price-card__curr">R</span>799
                    </div>
                    <p class="lp-price-card__period">per month · unlimited users</p>
                </div>
                <ul class="lp-price-card__features">
                    <li><i class="ph ph-check-circle"></i> Smart high-converting website</li>
                    <li><i class="ph ph-check-circle"></i> AI Receptionist (24/7)</li>
                    <li><i class="ph ph-check-circle"></i> Lead capture &amp; contact management</li>
                    <li><i class="ph ph-check-circle"></i> SEO foundation built in</li>
                    <li><i class="ph ph-check-circle"></i> Analytics dashboard</li>
                    <li><i class="ph ph-check-circle"></i> Email &amp; chat support</li>
                </ul>
                <a href="{{ url('/contact') }}" class="lp-btn lp-btn-ghost lp-price-card__cta">
                    Book a Demo
                </a>
            </div>

            <!-- Growth -->
            <div class="lp-price-card lp-price-card--pop">
                <div class="lp-price-card__badge">Most Popular</div>
                <div class="lp-price-card__name">Growth</div>
                <p class="lp-price-card__desc">The full system. Website + CRM. Everything automated, end to end.</p>
                <div class="lp-price-card__price-wrap">
                    <div class="lp-price-card__amount price-monthly">
                        <span class="lp-price-card__curr" style="opacity:.5">R</span>1,999
                    </div>
                    <div class="lp-price-card__amount price-annual" style="display:none;">
                        <span class="lp-price-card__curr" style="opacity:.5">R</span>1,599
                    </div>
                    <p class="lp-price-card__period">per month · unlimited users</p>
                </div>
                <ul class="lp-price-card__features">
                    <li><i class="ph ph-check-circle"></i> Everything in Starter, plus:</li>
                    <li><i class="ph ph-check-circle"></i> Full CRM &amp; lead pipeline</li>
                    <li><i class="ph ph-check-circle"></i> Smart quote builder &amp; approvals</li>
                    <li><i class="ph ph-check-circle"></i> Job scheduling &amp; team management</li>
                    <li><i class="ph ph-check-circle"></i> Automated invoicing &amp; payments</li>
                    <li><i class="ph ph-check-circle"></i> Automated follow-up sequences</li>
                    <li><i class="ph ph-check-circle"></i> Priority support</li>
                </ul>
                <a href="{{ url('/contact') }}" class="lp-btn lp-btn-teal lp-price-card__cta">
                    Book a Demo
                </a>
            </div>

            <!-- Scale -->
            <div class="lp-price-card">
                <div class="lp-price-card__name">Scale</div>
                <p class="lp-price-card__desc">Advanced automations and dedicated support for high-volume, ambitious businesses.</p>
                <div class="lp-price-card__price-wrap">
                    <div class="lp-price-card__amount price-monthly">
                        <span class="lp-price-card__curr">R</span>3,499
                    </div>
                    <div class="lp-price-card__amount price-annual" style="display:none;">
                        <span class="lp-price-card__curr">R</span>2,799
                    </div>
                    <p class="lp-price-card__period">per month · unlimited users</p>
                </div>
                <ul class="lp-price-card__features">
                    <li><i class="ph ph-check-circle"></i> Everything in Growth, plus:</li>
                    <li><i class="ph ph-check-circle"></i> Advanced workflow automations</li>
                    <li><i class="ph ph-check-circle"></i> Custom reporting &amp; analytics</li>
                    <li><i class="ph ph-check-circle"></i> API access &amp; integrations</li>
                    <li><i class="ph ph-check-circle"></i> Dedicated account manager</li>
                    <li><i class="ph ph-check-circle"></i> White-glove onboarding</li>
                    <li><i class="ph ph-check-circle"></i> Phone &amp; priority support</li>
                </ul>
                <a href="{{ url('/contact') }}" class="lp-btn lp-btn-ghost lp-price-card__cta">
                    Book a Demo
                </a>
            </div>

        </div>

        <p style="text-align:center;margin-top:32px;font-size:14px;color:var(--lp-ink-4);" data-aos="fade-up" data-aos-delay="200">
            All plans include <strong style="color:var(--lp-ink-2);">unlimited team members</strong>. No setup fees. No per-user charges. No contracts.<br>
            <span style="font-size:12px;opacity:0.7;">Jobber Plus with AI Receptionist starts at ~R14,700/mo equivalent. Same features. Much higher price.</span>
        </p>

    </div>
</section>

<!-- ============================================================
     TESTIMONIALS
     ============================================================ -->
<section class="lp-section lp-bg-dark">
    <div class="container">

        <div data-aos="fade-up" data-aos-duration="600">
            <div class="lp-eyebrow lp-eyebrow--teal">
                <span class="lp-eyebrow__dot"></span> Real results
            </div>
            <h2 class="lp-h2 lp-h2--inv" style="max-width:500px;">
                From the service pros who made the switch
            </h2>
        </div>

        <div class="lp-testi-grid">

            <div class="lp-tcard" data-aos="fade-up" data-aos-delay="0" data-aos-duration="600">
                <span class="lp-tcard__stars">★★★★★</span>
                <p class="lp-tcard__body">Before Luminii, I was losing at least three jobs a week because I couldn't respond fast enough. Now the AI Receptionist handles enquiries while I'm under someone's sink. Last month was my best month ever.</p>
                <div class="lp-tcard__author">
                    <div class="lp-tcard__av" style="background:#00D9B8;">TN</div>
                    <div>
                        <div class="lp-tcard__name">Thabo Nkosi</div>
                        <div class="lp-tcard__biz">TN Plumbing Solutions · Johannesburg</div>
                    </div>
                </div>
            </div>

            <div class="lp-tcard" data-aos="fade-up" data-aos-delay="80" data-aos-duration="600">
                <span class="lp-tcard__stars">★★★★★</span>
                <p class="lp-tcard__body">I used to juggle Xero, WhatsApp, Google Sheets, and a paper diary. Luminii replaced all of it in one setup call. Two days to go live. I genuinely couldn't go back to how things were.</p>
                <div class="lp-tcard__author">
                    <div class="lp-tcard__av" style="background:#6366F1;">PG</div>
                    <div>
                        <div class="lp-tcard__name">Priya Govender</div>
                        <div class="lp-tcard__biz">Sparkle Cleaning Services · Durban</div>
                    </div>
                </div>
            </div>

            <div class="lp-tcard" data-aos="fade-up" data-aos-delay="160" data-aos-duration="600">
                <span class="lp-tcard__stars">★★★★★</span>
                <p class="lp-tcard__body">The quoting alone paid for itself in the first week. I close twice as many jobs now because I'm always first to send a professional quote. My competitors are still calling clients back hours later.</p>
                <div class="lp-tcard__author">
                    <div class="lp-tcard__av" style="background:#F59E0B;">JD</div>
                    <div>
                        <div class="lp-tcard__name">Jacques du Plessis</div>
                        <div class="lp-tcard__biz">GreenScape Landscaping · Cape Town</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================
     FAQ
     ============================================================ -->
<section class="lp-section lp-bg-white" id="faq">
    <div class="container">

        <div data-aos="fade-up" data-aos-duration="600">
            <div class="lp-eyebrow">
                <span class="lp-eyebrow__dot"></span> FAQ
            </div>
            <h2 class="lp-h2" style="max-width:480px;">Questions. Answered honestly.</h2>
        </div>

        <div class="lp-faq-wrap" data-aos="fade-up" data-aos-delay="80" data-aos-duration="600">

            <div class="lp-faq-item">
                <button class="lp-faq-btn" onclick="lpFaq(this)">
                    How is Luminii different from Jobber?
                    <span class="lp-faq-icon"><i class="ph ph-plus"></i></span>
                </button>
                <div class="lp-faq-body">Jobber charges per user — their AI Receptionist is a $99/month add-on (roughly R1,800/mo), and you pay $29 extra per team member beyond your base. Luminii includes a smart website, AI Receptionist, and unlimited team members in every plan at a flat monthly rate — built specifically for the South African market, priced in Rands, with local support.</div>
            </div>

            <div class="lp-faq-item">
                <button class="lp-faq-btn" onclick="lpFaq(this)">
                    Does Luminii include a website, or is that an add-on?
                    <span class="lp-faq-icon"><i class="ph ph-plus"></i></span>
                </button>
                <div class="lp-faq-body">Every Luminii plan includes a professionally designed, high-converting website — not a template, but a purpose-built site that captures leads and wins bookings. It's SEO-optimised from day one and directly connected to your CRM. No separate website subscription needed.</div>
            </div>

            <div class="lp-faq-item">
                <button class="lp-faq-btn" onclick="lpFaq(this)">
                    How long does it take to get set up?
                    <span class="lp-faq-icon"><i class="ph ph-plus"></i></span>
                </button>
                <div class="lp-faq-body">Our onboarding team has most businesses live within 48 hours of their demo. We handle the setup, data migration, and training — you just show up for the handover call and start using the system.</div>
            </div>

            <div class="lp-faq-item">
                <button class="lp-faq-btn" onclick="lpFaq(this)">
                    I already have a website. Do I need to replace it?
                    <span class="lp-faq-icon"><i class="ph ph-plus"></i></span>
                </button>
                <div class="lp-faq-body">Not immediately. We can integrate Luminii's lead capture and AI Receptionist into your existing site while we build your new one. That said, most clients switch once they see the conversion difference — our sites are purpose-engineered to turn visitors into paying clients.</div>
            </div>

            <div class="lp-faq-item">
                <button class="lp-faq-btn" onclick="lpFaq(this)">
                    Is there a contract or commitment?
                    <span class="lp-faq-icon"><i class="ph ph-plus"></i></span>
                </button>
                <div class="lp-faq-body">No contracts. All Luminii plans are month-to-month — cancel anytime with 30 days' notice. Annual plans get you two months free but are not required. We'd rather keep you because Luminii genuinely works for your business.</div>
            </div>

            <div class="lp-faq-item">
                <button class="lp-faq-btn" onclick="lpFaq(this)">
                    Do I need to be tech-savvy to use Luminii?
                    <span class="lp-faq-icon"><i class="ph ph-plus"></i></span>
                </button>
                <div class="lp-faq-body">Not at all. Luminii is designed for business owners, not developers. If you can send a WhatsApp message, you can use Luminii. Our onboarding team trains you and your team in plain language, and our local support team is always available.</div>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================
     FINAL CTA
     ============================================================ -->
<section class="lp-cta-section">
    <div class="container">
        <div class="lp-cta-section__inner" data-aos="fade-up" data-aos-duration="700">

            <div class="lp-eyebrow lp-eyebrow--teal" style="justify-content:center;margin-bottom:28px;">
                <span class="lp-eyebrow__dot"></span> Ready when you are
            </div>

            <h2 class="lp-h2 lp-h2--inv">
                Your business deserves a system<br>that works as hard as you do.
            </h2>

            <p class="lp-lead lp-lead--inv" style="max-width:500px;margin:20px auto 0;">
                Book a free demo. Our team will walk you through the system, answer every question, and have you live in 48 hours.
            </p>

            <div class="lp-cta-section__ctas">
                <a href="{{ url('/contact') }}" class="lp-btn lp-btn-teal lp-btn-lg">
                    Book Your Free Demo
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="#pricing" class="lp-btn lp-btn-ghost-inv lp-btn-lg">
                    See pricing
                </a>
            </div>

            <p class="lp-cta-section__note">
                No contracts <span>·</span> No credit card required <span>·</span> Live in 48 hours
            </p>

            <div class="lp-trust-row">
                <div class="lp-trust-item"><i class="ph ph-users-three"></i> Unlimited team members</div>
                <div class="lp-trust-item"><i class="ph ph-credit-card"></i> Flat monthly rate</div>
                <div class="lp-trust-item"><i class="ph ph-lightning"></i> 48hr live guarantee</div>
                <div class="lp-trust-item"><i class="ph ph-shield-check"></i> No lock-in contracts</div>
                <div class="lp-trust-item"><i class="ph ph-flag"></i> Built for South Africa</div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('body-scripts')
<script>
(function () {

    /* Counter animation */
    function runCounters() {
        document.querySelectorAll('.lp-counter').forEach(function (el) {
            if (el.dataset.done) return;
            el.dataset.done = 1;
            var target = parseInt(el.getAttribute('data-target'), 10);
            var start = null;
            var dur = 1600;
            function step(ts) {
                if (!start) start = ts;
                var p = Math.min((ts - start) / dur, 1);
                var e = 1 - Math.pow(1 - p, 3);
                el.textContent = Math.floor(e * target);
                if (p < 1) requestAnimationFrame(step);
                else el.textContent = target;
            }
            requestAnimationFrame(step);
        });
    }

    var statsEl = document.querySelector('.lp-stats-bar');
    if (statsEl && 'IntersectionObserver' in window) {
        new IntersectionObserver(function (entries, obs) {
            if (entries[0].isIntersecting) { runCounters(); obs.disconnect(); }
        }, { threshold: 0.3 }).observe(statsEl);
    }

    /* Pricing toggle */
    var sw = document.getElementById('lp-ts');
    var ml = document.getElementById('lp-ml');
    var al = document.getElementById('lp-al');
    var on = false;
    if (sw) {
        sw.addEventListener('click', function () {
            on = !on;
            sw.classList.toggle('on', on);
            document.body.classList.toggle('lp-annual', on);
            ml.classList.toggle('on', !on);
            al.classList.toggle('on', on);
        });
    }

    /* FAQ accordion */
    window.lpFaq = function (btn) {
        var item = btn.closest('.lp-faq-item');
        var isOpen = item.classList.contains('open');
        document.querySelectorAll('.lp-faq-item.open').forEach(function (i) { i.classList.remove('open'); });
        if (!isOpen) item.classList.add('open');
    };

})();
</script>
@endpush
