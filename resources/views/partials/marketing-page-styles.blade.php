<style>
.lp-ph {
    background: #060F1E;
    padding: 120px 0 80px;
    text-align: center;
    position: relative;
}
.lp-ph::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none;
}
.lp-ph__inner { position: relative; z-index: 2; }
.lp-ph__h1 {
    font-family: "Geist", system-ui, sans-serif;
    font-size: clamp(36px, 5vw, 60px);
    font-weight: 800;
    letter-spacing: -0.035em;
    line-height: 1.08;
    color: #fff;
    margin-bottom: 20px;
}
.lp-ph__h1 em {
    font-style: normal;
    color: rgba(255,255,255,0.45);
}
.lp-ph__sub {
    font-size: 17px;
    line-height: 1.7;
    color: rgba(255,255,255,0.64);
    max-width: 720px;
    margin: 0 auto 28px;
}
.lp-ph__actions {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 14px;
    margin-bottom: 24px;
}
.lp-ph__mini-panel {
    max-width: 940px;
    margin: 28px auto 0;
    padding: 26px;
    border-radius: 28px;
    border: 1px solid rgba(255,255,255,0.08);
    background:
        linear-gradient(180deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.03) 100%);
    box-shadow: 0 28px 80px rgba(0,0,0,0.28);
    position: relative;
    overflow: hidden;
}
.lp-ph__mini-panel::before {
    content: '';
    position: absolute;
    inset: -30% auto auto -10%;
    width: 240px;
    height: 240px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(245,197,66,0.22) 0%, rgba(245,197,66,0) 70%);
    pointer-events: none;
}
.lp-ph__mini-grid {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
}
.lp-ph__mini-card {
    text-align: left;
    padding: 18px;
    border-radius: 20px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
}
.lp-ph__mini-card strong {
    display: block;
    font-family: "Geist", system-ui, sans-serif;
    font-size: 15px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 8px;
}
.lp-ph__mini-card span {
    display: block;
    font-size: 14px;
    line-height: 1.7;
    color: rgba(255,255,255,0.62);
}
.lp-ph__breadcrumb {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: "Geist", system-ui, sans-serif;
    font-size: 13px;
    font-weight: 500;
    color: rgba(255,255,255,0.4);
}
.lp-ph__breadcrumb a {
    color: rgba(255,255,255,0.55);
    text-decoration: none;
}
.lp-ph__breadcrumb a:hover { color: #fff; }
.lp-page {
    padding: 84px 0;
    background: #fff;
}
.lp-page--alt {
    background: #F8F9FC;
}
.lp-page__grid {
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) minmax(280px, 0.9fr);
    gap: 48px;
    align-items: start;
}
.lp-page__grid--single {
    grid-template-columns: 1fr;
}
.lp-page__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: "Geist", system-ui, sans-serif;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #647082;
    margin-bottom: 16px;
}
.lp-page__eyebrow::before {
    content: '';
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #F5C542;
    display: inline-block;
}
.lp-page__lead {
    font-size: 18px;
    line-height: 1.75;
    color: #536173;
    margin: 0;
}
.lp-page__lead + .lp-page__links,
.lp-page__lead + .lp-page__actions {
    margin-top: 24px;
}
.lp-page__card,
.lp-page__stack,
.lp-page__flow,
.lp-page__list,
.lp-page__visual,
.lp-page__compare,
.lp-page__metrics,
.lp-page__rail,
.lp-page__timeline {
    background: #fff;
    border: 1px solid #E5EAF2;
    border-radius: 22px;
    box-shadow: 0 20px 60px rgba(8,29,58,0.06);
}
.lp-page__card {
    padding: 28px;
}
.lp-page__stack {
    padding: 24px;
}
.lp-page__stack h3,
.lp-page__card h3 {
    font-family: "Geist", system-ui, sans-serif;
    font-size: 20px;
    font-weight: 700;
    color: #081D3A;
    margin: 0 0 12px;
}
.lp-page__stack p,
.lp-page__card p {
    font-size: 15px;
    line-height: 1.75;
    color: #647082;
    margin: 0;
}
.lp-page__kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 999px;
    background: rgba(8,29,58,0.05);
    color: #081D3A;
    font-family: "Geist", system-ui, sans-serif;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin-bottom: 16px;
}
.lp-page__stack-items {
    display: grid;
    gap: 18px;
}
.lp-page__section + .lp-page__section {
    margin-top: 72px;
}
.lp-page__section h2 {
    font-family: "Geist", system-ui, sans-serif;
    font-size: clamp(28px, 4vw, 38px);
    font-weight: 800;
    letter-spacing: -0.03em;
    color: #081D3A;
    margin: 0 0 16px;
}
.lp-page__section h2 em,
.lp-page__cta-band h2 em {
    font-style: normal;
    color: #647082;
}
.lp-page__section p {
    font-size: 16px;
    line-height: 1.8;
    color: #647082;
    margin: 0 0 18px;
}
.lp-page__points {
    display: grid;
    gap: 16px;
}
.lp-page__point {
    background: #fff;
    border: 1px solid #E5EAF2;
    border-radius: 18px;
    padding: 22px;
}
.lp-page__point h3 {
    font-family: "Geist", system-ui, sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: #081D3A;
    margin: 0 0 10px;
}
.lp-page__point p {
    margin: 0;
}
.lp-page__columns {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}
.lp-page__cards-3 {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 20px;
}
.lp-page__flow {
    padding: 28px;
}
.lp-page__flow-steps {
    display: grid;
    gap: 18px;
}
.lp-page__flow-step {
    display: grid;
    grid-template-columns: 52px 1fr;
    gap: 18px;
    align-items: start;
}
.lp-page__flow-num {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    background: #081D3A;
    color: #fff;
    font-family: "Geist", system-ui, sans-serif;
    font-size: 18px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
}
.lp-page__flow-step h3 {
    font-family: "Geist", system-ui, sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: #081D3A;
    margin: 0 0 8px;
}
.lp-page__flow-step p {
    margin: 0;
}
.lp-page__visual {
    padding: 28px;
    background:
        linear-gradient(180deg, rgba(8,29,58,0.04) 0%, rgba(255,255,255,0.96) 44%),
        #fff;
    position: relative;
    overflow: hidden;
}
.lp-page__visual::after {
    content: '';
    position: absolute;
    right: -60px;
    top: -60px;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(11,183,165,0.14) 0%, rgba(11,183,165,0) 72%);
    pointer-events: none;
}
.lp-page__visual-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-bottom: 22px;
}
.lp-page__visual-title {
    font-family: "Geist", system-ui, sans-serif;
    font-size: 20px;
    font-weight: 700;
    color: #081D3A;
}
.lp-page__visual-badge {
    padding: 8px 12px;
    border-radius: 999px;
    background: rgba(8,29,58,0.08);
    color: #081D3A;
    font-family: "Geist", system-ui, sans-serif;
    font-size: 12px;
    font-weight: 700;
}
.lp-page__visual-rows {
    display: grid;
    gap: 14px;
    position: relative;
    z-index: 1;
}
.lp-page__visual-row {
    display: grid;
    grid-template-columns: 56px 1fr auto;
    gap: 16px;
    align-items: center;
    padding: 16px;
    border-radius: 18px;
    background: #fff;
    border: 1px solid #E5EAF2;
}
.lp-page__visual-icon {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    background: #081D3A;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}
.lp-page__visual-row strong,
.lp-page__metric strong,
.lp-page__mini strong,
.lp-page__compare-block h3 {
    display: block;
    font-family: "Geist", system-ui, sans-serif;
    color: #081D3A;
}
.lp-page__visual-row strong {
    font-size: 16px;
    margin-bottom: 5px;
}
.lp-page__visual-row span,
.lp-page__metric span,
.lp-page__mini span,
.lp-page__compare-block p {
    font-size: 14px;
    line-height: 1.7;
    color: #647082;
}
.lp-page__pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 12px;
    border-radius: 999px;
    font-family: "Geist", system-ui, sans-serif;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}
.lp-page__pill--gold {
    background: rgba(245,197,66,0.18);
    color: #8A6400;
}
.lp-page__pill--teal {
    background: rgba(11,183,165,0.14);
    color: #0B7268;
}
.lp-page__pill--navy {
    background: rgba(8,29,58,0.08);
    color: #081D3A;
}
.lp-page__metrics {
    padding: 26px;
}
.lp-page__metrics-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
}
.lp-page__metric {
    padding: 18px;
    border-radius: 18px;
    background: #F8F9FC;
    border: 1px solid #E5EAF2;
}
.lp-page__metric-value {
    font-family: "Geist", system-ui, sans-serif;
    font-size: 30px;
    font-weight: 800;
    letter-spacing: -0.03em;
    color: #081D3A;
    margin-bottom: 8px;
}
.lp-page__rail {
    padding: 28px;
    background: linear-gradient(180deg, #081D3A 0%, #0D274D 100%);
    border-color: rgba(8,29,58,0.2);
}
.lp-page__rail-head {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    align-items: center;
    margin-bottom: 20px;
}
.lp-page__rail-head h3 {
    margin: 0;
    color: #fff;
    font-family: "Geist", system-ui, sans-serif;
    font-size: 22px;
    font-weight: 700;
}
.lp-page__rail-head p {
    margin: 8px 0 0;
    color: rgba(255,255,255,0.62);
}
.lp-page__rail-steps {
    display: grid;
    gap: 16px;
}
.lp-page__rail-step {
    display: grid;
    grid-template-columns: 42px 1fr;
    gap: 16px;
    align-items: start;
    padding: 18px;
    border-radius: 18px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.08);
}
.lp-page__rail-num {
    width: 42px;
    height: 42px;
    border-radius: 14px;
    background: #F5C542;
    color: #081D3A;
    font-family: "Geist", system-ui, sans-serif;
    font-size: 16px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
}
.lp-page__rail-step strong {
    display: block;
    color: #fff;
    font-family: "Geist", system-ui, sans-serif;
    font-size: 16px;
    margin-bottom: 6px;
}
.lp-page__rail-step span {
    display: block;
    color: rgba(255,255,255,0.66);
    font-size: 14px;
    line-height: 1.7;
}
.lp-page__timeline {
    padding: 24px;
}
.lp-page__timeline-items {
    display: grid;
    gap: 14px;
}
.lp-page__timeline-item {
    display: grid;
    grid-template-columns: 110px 1fr;
    gap: 16px;
    align-items: start;
}
.lp-page__timeline-label {
    font-family: "Geist", system-ui, sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: #081D3A;
    padding-top: 4px;
}
.lp-page__timeline-body {
    padding: 18px;
    border-radius: 18px;
    background: #F8F9FC;
    border: 1px solid #E5EAF2;
}
.lp-page__timeline-body strong {
    display: block;
    font-family: "Geist", system-ui, sans-serif;
    font-size: 16px;
    color: #081D3A;
    margin-bottom: 6px;
}
.lp-page__timeline-body span {
    display: block;
    font-size: 14px;
    line-height: 1.7;
    color: #647082;
}
.lp-page__compare {
    padding: 28px;
}
.lp-page__compare-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
}
.lp-page__compare-block {
    padding: 22px;
    border-radius: 20px;
    border: 1px solid #E5EAF2;
}
.lp-page__compare-block--soft {
    background: #F8F9FC;
}
.lp-page__compare-block--strong {
    background: linear-gradient(180deg, rgba(11,183,165,0.1) 0%, rgba(255,255,255,0.98) 100%);
}
.lp-page__mini-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
}
.lp-page__mini {
    padding: 18px;
    border-radius: 18px;
    background: #fff;
    border: 1px solid #E5EAF2;
}
.lp-page__cta-band {
    padding: 32px;
    border-radius: 28px;
    background: linear-gradient(135deg, #081D3A 0%, #0C3568 100%);
    box-shadow: 0 24px 70px rgba(8,29,58,0.18);
}
.lp-page__cta-band h2 {
    color: #fff;
    margin-bottom: 12px;
}
.lp-page__cta-band h2 em {
    color: rgba(255,255,255,0.45);
}
.lp-page__cta-band p {
    color: rgba(255,255,255,0.66);
    margin-bottom: 0;
}
.lp-page__cta-band .lp-page__links {
    margin-top: 22px;
}
.lp-page__cta-band .lp-page__link-chip {
    background: rgba(255,255,255,0.08);
    border-color: rgba(255,255,255,0.12);
    color: #fff;
}
.lp-page__cta-band .lp-page__link-chip:hover {
    border-color: rgba(255,255,255,0.3);
}
.lp-btn--outline {
    background: #fff;
    border-color: #D7DEEA;
    color: #081D3A;
}
.lp-btn--outline:hover {
    background: #081D3A;
    border-color: #081D3A;
    color: #fff;
}
.lp-ph .lp-btn--outline {
    background: rgba(255,255,255,0.06);
    border-color: rgba(255,255,255,0.18);
    color: #fff;
}
.lp-ph .lp-btn--outline:hover {
    background: #fff;
    border-color: #fff;
    color: #081D3A;
}
.lp-page__links {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 24px;
}
.lp-page__link-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 16px;
    border-radius: 999px;
    border: 1px solid #D7DEEA;
    background: #fff;
    color: #081D3A;
    font-family: "Geist", system-ui, sans-serif;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
}
.lp-page__link-chip:hover {
    border-color: #081D3A;
}
.lp-page__note {
    font-size: 14px;
    color: #647082;
    border-left: 3px solid #F5C542;
    padding-left: 14px;
}
.lp-page__list {
    padding: 26px;
}
.lp-page__list ul {
    display: grid;
    gap: 12px;
    margin: 0;
    padding: 0;
}
.lp-page__list li {
    list-style: none;
    font-size: 15px;
    line-height: 1.7;
    color: #4E5C6D;
    padding-left: 18px;
    position: relative;
}
.lp-page__list li::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #F5C542;
    position: absolute;
    left: 0;
    top: 10px;
}
@media (max-width: 900px) {
    .lp-page__grid,
    .lp-page__columns,
    .lp-page__cards-3,
    .lp-page__compare-grid,
    .lp-page__mini-grid,
    .lp-ph__mini-grid,
    .lp-page__metrics-grid {
        grid-template-columns: 1fr;
    }
    .lp-page__timeline-item,
    .lp-page__visual-row {
        grid-template-columns: 1fr;
    }
    .lp-page__visual-head,
    .lp-page__rail-head {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
