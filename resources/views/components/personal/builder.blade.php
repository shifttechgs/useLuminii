{{--
    Personal page hero: the quote / invoice builder itself, open on load.
    The draft lives only in this browser (localStorage). "Download PDF" builds the file in the
    browser (html2canvas + jsPDF, loaded on first use) and saves it directly; nothing is uploaded.
    If those libraries can't load, it falls back to the browser's print-to-PDF. "Send" needs an account, which isn't open yet, so it
    asks for an email and creates a CRM lead (route personal.early-access).
    Any [data-builder="quote|invoice"] link on the page scrolls here and switches the type.
--}}
@php
    $qbCurrencies = ['USD','EUR','GBP','ZAR','AUD','CAD','NZD','INR','NGN','KES','GHS','AED','SGD','JPY','CHF','SEK','NOK','DKK','PLN','BRL','MXN',
                     'CNY','HKD','MYR','PHP','THB','IDR','SAR','QAR','EGP','MAD','TZS','UGX','ZMW','BWP','NAD','MUR','TRY','ILS','CZK','HUF','RON'];
@endphp
<section class="qb" id="top" aria-labelledby="qb-heading">
    <div class="qb__app" id="qb">
        <div class="qb__top">
            <div class="qb__intro">
                <h1 class="qb__h1" id="qb-heading">Free quote and invoice maker</h1>
                <p class="qb__lead">No sign-up. Fill it in, download a PDF. For freelancers and sole traders anywhere.</p>
            </div>
            <div class="qb__tools">
                <div class="qb__view" role="tablist" aria-label="View">
                    <button type="button" role="tab" class="qb__view-btn" data-qb-view="edit">Edit</button>
                    <button type="button" role="tab" class="qb__view-btn" data-qb-view="preview">Preview</button>
                </div>
                <button type="button" class="qb__reset" data-qb-reset><i class="ph ph-arrow-counter-clockwise" aria-hidden="true"></i> Start over</button>
                <button type="button" class="qb__btn qb__btn--ghost" data-qb-pdf><i class="ph ph-download-simple" aria-hidden="true"></i> Download PDF</button>
                <button type="button" class="qb__btn qb__btn--ghost qb__btn--wa" data-qb-wa aria-label="Share on WhatsApp"><i class="ph ph-whatsapp-logo" aria-hidden="true"></i> <span>WhatsApp</span></button>
                <button type="button" class="qb__btn qb__btn--solid" data-qb-send><i class="ph ph-paper-plane-tilt" aria-hidden="true"></i> <span data-qb-send-label>Send quote</span></button>
            </div>
        </div>

        <div class="qb__body">
            <div class="qb__panel">
                <div class="qb__panel-head">
                    <div class="qb__type" role="tablist" aria-label="Document type">
                        <button type="button" role="tab" class="qb__type-btn" data-qb-type="quote">Quote</button>
                        <button type="button" role="tab" class="qb__type-btn" data-qb-type="invoice">Invoice</button>
                    </div>
                    <button type="button" class="qb__convert" data-qb-convert hidden><i class="ph ph-check-circle" aria-hidden="true"></i> Accepted? <span>Make it an invoice</span> <i class="ph ph-arrow-right" aria-hidden="true"></i></button>
                    <p class="qb__autosave"><i class="ph ph-lock-simple" aria-hidden="true"></i> Saved in this browser only</p>
                </div>
            {{-- ── Form ── --}}
            <form class="qb__form" id="qb-form" autocomplete="on" novalidate>
                <div class="qb__pair">
                    <fieldset class="qb__group qb__group--from">
                        <legend>From</legend>
                        <label class="qb__field"><span>Your name or business</span><input type="text" data-qb="from.name" placeholder="Acme Studio" maxlength="120" autocomplete="organization"></label>
                        <label class="qb__field"><span>Email</span><input type="email" data-qb="from.email" placeholder="you@example.com" maxlength="160" autocomplete="email"></label>
                        <label class="qb__field"><span>Address <em>optional</em></span><input type="text" data-qb="from.address" placeholder="Street, city, country" maxlength="300" autocomplete="street-address"></label>
                        <button type="button" class="qb__logo-btn" data-qb-logo-pick><i class="ph ph-image" aria-hidden="true"></i> <span data-qb-logo-label>Add logo</span></button>
                        <input type="file" id="qb-logo-input" accept="image/png,image/jpeg,image/webp,image/svg+xml" hidden>
                        <p class="qb__logo-err" data-qb-logo-err role="alert" hidden></p>
                    </fieldset>
                    <fieldset class="qb__group">
                        <legend>Bill to</legend>
                        <label class="qb__field"><span>Client name</span><input type="text" data-qb="to.name" placeholder="Client or company" maxlength="120" autocomplete="off"></label>
                        <label class="qb__field"><span>Client email <em>optional</em></span><input type="email" data-qb="to.email" placeholder="client@example.com" maxlength="160" autocomplete="off"></label>
                        <label class="qb__field"><span>Client address <em>optional</em></span><input type="text" data-qb="to.address" placeholder="Street, city, country" maxlength="300" autocomplete="off"></label>
                    </fieldset>
                </div>

                <div class="qb__row qb__row--4">
                    <label class="qb__field"><span data-qb-label="number">Quote number</span><input type="text" data-qb="number" maxlength="40"></label>
                    <div class="qb__field qb-cur" data-qb-cur>
                        <span id="qb-cur-label">Currency</span>
                        <select data-qb="currency" class="qb-cur__native" aria-labelledby="qb-cur-label">
                            @foreach($qbCurrencies as $code)<option value="{{ $code }}">{{ $code }}</option>@endforeach
                        </select>
                        <button type="button" class="qb-cur__btn" aria-haspopup="listbox" aria-expanded="false" aria-labelledby="qb-cur-label qb-cur-value">
                            <span class="qb-cur__sym" aria-hidden="true"></span>
                            <span class="qb-cur__code" id="qb-cur-value"></span>
                            <i class="ph ph-caret-down" aria-hidden="true"></i>
                        </button>
                        <div class="qb-cur__pop" hidden>
                            <div class="qb-cur__search">
                                <i class="ph ph-magnifying-glass" aria-hidden="true"></i>
                                <input type="text" placeholder="Search currency" autocomplete="off" spellcheck="false" aria-label="Search currency" aria-controls="qb-cur-list" aria-autocomplete="list" role="combobox" aria-expanded="true">
                            </div>
                            <ul class="qb-cur__list" id="qb-cur-list" role="listbox" aria-label="Currencies"></ul>
                        </div>
                    </div>
                    <div class="qb__field qb-date" data-qb-date="date">
                        <span id="qb-date-l-date">Date</span>
                        <input type="date" data-qb="date" class="qb-date__native" aria-labelledby="qb-date-l-date">
                        <button type="button" class="qb-date__btn" aria-haspopup="dialog" aria-expanded="false" aria-labelledby="qb-date-l-date qb-date-v-date">
                            <span class="qb-date__value" id="qb-date-v-date"></span><i class="ph ph-calendar-blank" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="qb__field qb-date" data-qb-date="due">
                        <span id="qb-date-l-due" data-qb-label="due">Valid until</span>
                        <input type="date" data-qb="due" class="qb-date__native" aria-labelledby="qb-date-l-due">
                        <button type="button" class="qb-date__btn" aria-haspopup="dialog" aria-expanded="false" aria-labelledby="qb-date-l-due qb-date-v-due">
                            <span class="qb-date__value" id="qb-date-v-due"></span><i class="ph ph-calendar-blank" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <fieldset class="qb__group qb__group--items">
                    <legend>Items</legend>
                    <div class="qb__items-head" aria-hidden="true"><span>Description</span><span>Qty</span><span>Price</span><span class="qb__items-amt">Amount</span><span></span></div>
                    <ol class="qb__items" id="qb-items"></ol>
                    <div class="qb__items-foot">
                        <button type="button" class="qb__add" data-qb-add><i class="ph ph-plus" aria-hidden="true"></i> Add item</button>
                        <div class="qb__sum" aria-live="polite"><span class="qb__sum-break" id="qb-form-break" hidden></span><span>Total</span><strong id="qb-form-total">0.00</strong></div>
                    </div>
                </fieldset>

                <div class="qb__row qb__row--notes">
                    <div class="qb__field qb-tax">
                        <span>Tax <em>optional</em></span>
                        <div class="qb-tax__box">
                            <input type="text" data-qb="taxName" class="qb-tax__name" placeholder="VAT" maxlength="20" autocomplete="off" aria-label="Tax name, for example VAT or GST">
                            <span class="qb-tax__sep" aria-hidden="true"></span>
                            <input type="number" data-qb="tax" class="qb-tax__rate" min="0" max="100" step="0.01" inputmode="decimal" placeholder="0" aria-label="Tax rate in percent">
                            <span class="qb-tax__pct" aria-hidden="true">%</span>
                        </div>
                    </div>
                    <label class="qb__field qb-notes"><span>Notes <em>optional</em></span><textarea data-qb="notes" rows="1" placeholder="Terms, thank-you note" maxlength="1000"></textarea></label>
                </div>

                <div class="qb-pay" data-qb-pay-box>
                    <button type="button" class="qb-pay__toggle" data-qb-pay-toggle aria-expanded="false" aria-controls="qb-pay-fields">
                        <i class="ph ph-hand-coins" aria-hidden="true"></i>
                        <span class="qb-pay__title">Get paid faster</span>
                        <span class="qb-pay__sub" data-qb-pay-sub>Add a payment link or bank details. We add a QR code.</span>
                        <i class="ph ph-caret-down qb-pay__caret" aria-hidden="true"></i>
                    </button>
                    <div class="qb-pay__fields" id="qb-pay-fields" hidden>
                        <div class="qb__row">
                            <label class="qb__field"><span>Payment link <em>optional</em></span><input type="url" data-qb="pay.link" placeholder="paypal.me/you or any pay link" maxlength="500" inputmode="url" autocomplete="off" spellcheck="false" aria-describedby="qb-pay-err"></label>
                            <label class="qb__field qb-notes"><span>Bank or mobile money <em>optional</em></span><textarea data-qb="pay.details" rows="1" placeholder="Bank account, M-Pesa or UPI ID" maxlength="500"></textarea></label>
                        </div>
                        <p class="qb-pay__err" id="qb-pay-err" role="alert" hidden></p>
                    </div>
                </div>
            </form>
            </div>

            {{-- ── Live preview ── --}}
            <div class="qb__stage" aria-label="Preview">
                <article class="qb-paper" id="qb-paper">
                    <header class="qb-paper__head">
                        <div>
                            <div class="qb-paper__logo is-empty" data-qb-logo-slot>
                                <button type="button" class="qb-paper__logo-add" data-qb-logo-pick aria-label="Add your logo"><i class="ph ph-plus" aria-hidden="true"></i> Logo</button>
                                <img alt="" hidden data-qb-logo-img>
                                <button type="button" class="qb-paper__logo-x" data-qb-logo-remove aria-label="Remove logo" hidden><i class="ph ph-x" aria-hidden="true"></i></button>
                            </div>
                            <div class="qb-paper__from" data-pv="from.name"></div>
                            <div class="qb-paper__muted qb-paper__pre" data-pv="from.email"></div>
                            <div class="qb-paper__muted qb-paper__pre" data-pv="from.address"></div>
                        </div>
                        <div class="qb-paper__doc">
                            <div class="qb-paper__type" data-pv="type"></div>
                            <div class="qb-paper__muted" data-pv="number"></div>
                            <div class="qb-paper__ref" data-pv="quoteRef"></div>
                        </div>
                    </header>

                    <div class="qb-paper__meta">
                        <div>
                            <div class="qb-paper__label">Bill to</div>
                            <div class="qb-paper__strong" data-pv="to.name"></div>
                            <div class="qb-paper__muted qb-paper__pre" data-pv="to.email"></div>
                            <div class="qb-paper__muted qb-paper__pre" data-pv="to.address"></div>
                        </div>
                        <div class="qb-paper__dates">
                            <div><span class="qb-paper__label">Date</span><span data-pv="date"></span></div>
                            <div><span class="qb-paper__label" data-pv="dueLabel"></span><span data-pv="due"></span></div>
                        </div>
                    </div>

                    <table class="qb-paper__table">
                        <thead><tr><th>Description</th><th>Qty</th><th>Price</th><th>Amount</th></tr></thead>
                        <tbody id="qb-pv-items"></tbody>
                    </table>

                    <div class="qb-paper__totals">
                        <div><span>Subtotal</span><span data-pv="subtotal"></span></div>
                        <div data-pv-tax-row><span data-pv="taxLabel"></span><span data-pv="taxAmount"></span></div>
                        <div class="qb-paper__grand"><span>Total</span><span data-pv="total"></span></div>
                    </div>

                    <section class="qb-paper__pay" data-qb-pv-pay hidden>
                        <div class="qb-paper__pay-text">
                            <div class="qb-paper__label" data-pv="payLabel"></div>
                            <div class="qb-paper__pre" data-pv="pay.details"></div>
                            <div class="qb-paper__pay-online" data-qb-pv-link-row hidden><span class="qb-paper__muted">Pay online:</span> <a class="qb-paper__pay-link" data-qb-pv-link target="_blank" rel="noopener noreferrer nofollow"></a></div>
                            <div class="qb-paper__muted" data-pv="payRef"></div>
                        </div>
                        <figure class="qb-paper__qr" data-qb-pv-qr hidden>
                            <svg data-qb-pv-qr-svg viewBox="0 0 1 1" role="img" aria-label="QR code for the payment link" shape-rendering="crispEdges"><path fill="#081D3A"></path></svg>
                            <figcaption>Scan to pay</figcaption>
                        </figure>
                    </section>
                    <button type="button" class="qb-paper__pay-add" data-qb-pv-pay-add><i class="ph ph-plus" aria-hidden="true"></i> How to pay</button>

                    <div class="qb-paper__notes qb-paper__pre" data-pv="notes"></div>
                </article>
            </div>
        </div>

        {{-- ── Share on WhatsApp: a ready-to-send message; the PDF is attached in the chat ── --}}
        <div class="qb__gate" id="qb-wa" role="dialog" aria-modal="true" aria-labelledby="qb-wa-h" hidden>
            <div class="qb__gate-card qb-wa">
                <button type="button" class="qb__gate-x" data-qb-wa-close aria-label="Close"><i class="ph ph-x" aria-hidden="true"></i></button>
                <h2 class="qb__gate-h qb-wa__h" id="qb-wa-h"><i class="ph ph-whatsapp-logo" aria-hidden="true"></i> Share on WhatsApp</h2>

                <ol class="qb-wa__steps">
                    <li>
                        <span class="qb-wa__n" aria-hidden="true">1</span>
                        <div><button type="button" class="qb-wa__pdf" data-qb-pdf><i class="ph ph-download-simple" aria-hidden="true"></i> Download the PDF</button> <span class="qb-wa__hint">so you can attach it in the chat</span></div>
                    </li>
                    <li>
                        <span class="qb-wa__n" aria-hidden="true">2</span>
                        <label class="qb__field qb-wa__field"><span>Message <em>edit if you like</em></span><textarea data-qb-wa-msg rows="9" maxlength="2000"></textarea></label>
                    </li>
                    <li>
                        <span class="qb-wa__n" aria-hidden="true">3</span>
                        <div>
                            <label class="qb__field qb-wa__field"><span>Client's WhatsApp number <em>optional</em></span><input type="tel" data-qb-wa-phone inputmode="tel" autocomplete="off" maxlength="24" placeholder="Country code and number, e.g. 27 82 123 4567" aria-describedby="qb-wa-err qb-wa-note"></label>
                            <p class="qb-wa__note" id="qb-wa-note">Leave it empty to pick the chat in WhatsApp.</p>
                            <p class="qb__gate-err" id="qb-wa-err" role="alert" hidden></p>
                        </div>
                    </li>
                </ol>

                <div class="qb-wa__actions">
                    <button type="button" class="qb__btn qb__btn--ghost" data-qb-wa-copy><i class="ph ph-copy" aria-hidden="true"></i> <span data-qb-wa-copy-label>Copy message</span></button>
                    <button type="button" class="qb__btn qb__btn--solid" data-qb-wa-open><i class="ph ph-whatsapp-logo" aria-hidden="true"></i> Open WhatsApp</button>
                </div>
            </div>
        </div>

        <div class="qb-toast" id="qb-toast" role="status" aria-live="polite" hidden>
            <i class="ph ph-check-circle" aria-hidden="true"></i>
            <span class="qb-toast__msg" data-qb-toast-msg></span>
            <button type="button" class="qb-toast__undo" data-qb-undo>Undo</button>
        </div>

        {{-- ── Send: early-access capture ── --}}
        <div class="qb__gate" id="qb-gate" role="dialog" aria-modal="true" aria-labelledby="qb-gate-h" hidden>
            <div class="qb__gate-card">
                <button type="button" class="qb__gate-x" data-qb-gate-close aria-label="Back to editing"><i class="ph ph-x" aria-hidden="true"></i></button>

                <div data-qb-gate-step="ask">
                    <h2 class="qb__gate-h" id="qb-gate-h">Sending opens soon</h2>
                    <p class="qb__gate-p">We're opening sending to everyone shortly. Leave your email and we'll tell you the moment you can send this <span data-qb-doc-word>quote</span> to your client. You can download it as a PDF right now.</p>
                    <form class="qb__gate-form" id="qb-gate-form" action="{{ route('personal.early-access') }}" method="post" novalidate>
                        @csrf
                        <label class="qb__field"><span>Email</span><input type="email" name="email" required maxlength="255" autocomplete="email" placeholder="you@example.com"></label>
                        <label class="qb__field"><span>Name <em>optional</em></span><input type="text" name="name" maxlength="120" autocomplete="name"></label>
                        <fieldset class="qb-vote">
                            <legend>What should we build first? <em>optional</em></legend>
                            <div class="qb-vote__grid">
                            <label class="qb-vote__opt"><input type="radio" name="wants" value="accept"><i class="ph ph-signature" aria-hidden="true"></i><span>Client accepts the quote online</span></label>
                            <label class="qb-vote__opt"><input type="radio" name="wants" value="pay"><i class="ph ph-credit-card" aria-hidden="true"></i><span>Pay button: card or mobile money</span></label>
                            <label class="qb-vote__opt"><input type="radio" name="wants" value="remind"><i class="ph ph-bell-ringing" aria-hidden="true"></i><span>Automatic payment reminders</span></label>
                            <label class="qb-vote__opt"><input type="radio" name="wants" value="track"><i class="ph ph-eye" aria-hidden="true"></i><span>Know when they open it</span></label>
                            </div>
                        </fieldset>
                        <label class="qb__hp" aria-hidden="true">Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                        <p class="qb__gate-err" id="qb-gate-err" role="alert" hidden></p>
                        <button type="submit" class="qb__btn qb__btn--solid qb__btn--block">Notify me</button>
                    </form>
                    <button type="button" class="qb__gate-link" data-qb-pdf><i class="ph ph-file-pdf" aria-hidden="true"></i> Download PDF instead</button>
                </div>

                <div data-qb-gate-step="done" hidden>
                    <div class="qb__gate-ok"><i class="ph ph-check" aria-hidden="true"></i></div>
                    <h2 class="qb__gate-h">You're on the list</h2>
                    <p class="qb__gate-p">We'll email <strong data-qb-done-email></strong> as soon as sending opens. Your draft is saved in this browser.<span data-qb-done-vote hidden> Thanks for the vote: <strong data-qb-done-vote-label></strong> is on our list.</span></p>
                    <button type="button" class="qb__btn qb__btn--solid qb__btn--block" data-qb-gate-close>Keep editing</button>
                </div>
            </div>
        </div>
    </div>
</section>

@push('body-scripts')
<script src="{{ asset('useluminii/assets/js/qrcode-generator-1.4.4.js') }}"></script>
<script>
(function () {
    var root = document.getElementById('qb');
    if (!root) return;

    var KEY = 'luminii.personal.draft.v1';
    var form = document.getElementById('qb-form');
    var itemsEl = document.getElementById('qb-items');
    var pvItems = document.getElementById('qb-pv-items');
    var gate = document.getElementById('qb-gate');
    var gateForm = document.getElementById('qb-gate-form');
    var gateErr = document.getElementById('qb-gate-err');
    function F(n) { return gateForm.elements[n]; }

    // ── State ──
    function iso(d) { return new Date(d.getTime() - d.getTimezoneOffset() * 60000).toISOString().slice(0, 10); }
    function addDays(n) { var d = new Date(); d.setDate(d.getDate() + n); return iso(d); }
    function guessCurrency() {
        try {
            var r = (Intl.DateTimeFormat().resolvedOptions().locale || '').split('-').pop().toUpperCase();
            var map = { US: 'USD', GB: 'GBP', ZA: 'ZAR', AU: 'AUD', CA: 'CAD', NZ: 'NZD', IN: 'INR', NG: 'NGN', KE: 'KES', GH: 'GHS', AE: 'AED', SG: 'SGD', JP: 'JPY', CH: 'CHF', SE: 'SEK', NO: 'NOK', DK: 'DKK', BR: 'BRL', MX: 'MXN',
                        DE: 'EUR', FR: 'EUR', ES: 'EUR', IT: 'EUR', NL: 'EUR', IE: 'EUR', PT: 'EUR', BE: 'EUR', AT: 'EUR', FI: 'EUR', GR: 'EUR' };
            return map[r] || 'USD';
        } catch (e) { return 'USD'; }
    }
    function fresh(type) {
        return {
            type: type || 'quote',
            from: { name: '', email: '', address: '' },
            to: { name: '', email: '', address: '', phone: '' },
            number: (type === 'invoice' ? 'INV' : 'QUO') + '-0001',
            currency: guessCurrency(),
            date: iso(new Date()),
            due: addDays(type === 'invoice' ? 14 : 30),
            items: [{ d: '', q: 1, p: '' }],
            tax: '',
            taxName: '',
            notes: '',
            logo: '',
            pay: { link: '', details: '' },
            quoteRef: ''
        };
    }
    var S = fresh('quote');
    try { var saved = JSON.parse(localStorage.getItem(KEY) || 'null'); if (saved && saved.items) { S = Object.assign(fresh(saved.type), saved); if (!S.pay || typeof S.pay !== 'object') S.pay = { link: '', details: '' }; } } catch (e) {}
    function save() { try { localStorage.setItem(KEY, JSON.stringify(S)); } catch (e) {} }

    function get(path) { return path.split('.').reduce(function (o, k) { return o == null ? '' : o[k]; }, S); }
    function set(path, v) { var ks = path.split('.'), o = S; for (var i = 0; i < ks.length - 1; i++) o = o[ks[i]]; o[ks[ks.length - 1]] = v; }

    // ── Money ──
    function num(v) { var n = parseFloat(String(v).replace(',', '.')); return isFinite(n) ? n : 0; }
    function money(n) {
        try { return new Intl.NumberFormat(undefined, { style: 'currency', currency: S.currency, currencyDisplay: 'narrowSymbol' }).format(n); }
        catch (e) {
            try { return new Intl.NumberFormat(undefined, { style: 'currency', currency: S.currency }).format(n); }
            catch (e2) { return S.currency + ' ' + n.toFixed(2); }
        }
    }
    function totals() {
        var sub = S.items.reduce(function (t, it) { return t + num(it.q) * num(it.p); }, 0);
        var rate = Math.min(100, Math.max(0, num(S.tax))), tax = sub * rate / 100;
        return { sub: sub, rate: rate, tax: tax, total: sub + tax, lines: S.items.filter(function (it) { return it.d || num(it.p); }).length };
    }
    function fmtDate(v) {
        if (!v) return '';
        try { return new Date(v + 'T00:00:00').toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' }); } catch (e) { return v; }
    }

    // ── Items editor ──
    function curSymbol() {
        try {
            var part = new Intl.NumberFormat(undefined, { style: 'currency', currency: S.currency, currencyDisplay: 'narrowSymbol' }).formatToParts(0)
                .filter(function (x) { return x.type === 'currency'; })[0];
            return part ? part.value : S.currency;
        } catch (e) { return S.currency; }
    }
    function itemRow(it, idx) {
        var li = document.createElement('li');
        li.className = 'qb__item';
        li.innerHTML =
            '<input type="text" class="qb__in-d" maxlength="200" aria-label="Description">' +
            '<input type="number" class="qb__in-q" min="0" step="any" inputmode="decimal" aria-label="Quantity">' +
            '<label class="qb__price"><span class="qb__price-sym" aria-hidden="true"></span>' +
                '<input type="number" class="qb__in-p" min="0" step="any" inputmode="decimal" placeholder="0.00" aria-label="Price"></label>' +
            '<output class="qb__line-amt" aria-label="Line amount"></output>' +
            '<button type="button" class="qb__rm"><i class="ph ph-x" aria-hidden="true"></i></button>';
        var d = li.querySelector('.qb__in-d'), q = li.querySelector('.qb__in-q'), p = li.querySelector('.qb__in-p');
        d.placeholder = idx === 0 ? 'e.g. Logo design' : 'Item or service';
        d.value = it.d; q.value = it.q; p.value = it.p;
        li._it = it;
        d.addEventListener('input', function () { it.d = d.value; update(); });
        q.addEventListener('input', function () { it.q = q.value; update(); });
        p.addEventListener('input', function () { it.p = p.value; update(); });
        // No accidental changes from the mouse wheel on number fields
        [q, p].forEach(function (n) { n.addEventListener('wheel', function () { if (document.activeElement === n) n.blur(); }, { passive: true }); });
        // Enter: next row, or a new row from the last one
        [d, q, p].forEach(function (n) {
            n.addEventListener('keydown', function (e) {
                if (e.key !== 'Enter' || e.isComposing) return;
                e.preventDefault();
                var i = S.items.indexOf(it);
                if (i === S.items.length - 1) { addItem(); }
                else { var next = itemsEl.children[i + 1]; if (next) next.querySelector('.qb__in-d').focus(); }
            });
        });
        var rm = li.querySelector('.qb__rm');
        rm.addEventListener('click', function () {
            var i = S.items.indexOf(it);
            if (S.items.length === 1) { S.items[0] = { d: '', q: 1, p: '' }; } else { S.items.splice(i, 1); }
            renderItems(); update();
            var rows = itemsEl.querySelectorAll('.qb__in-d');
            var target = rows[Math.min(i, rows.length - 1)]; if (target) target.focus();
        });
        return li;
    }
    function addItem() {
        S.items.push({ d: '', q: 1, p: '' });
        renderItems(); update();
        var last = itemsEl.lastElementChild;
        if (last) { last.classList.add('is-new'); last.querySelector('.qb__in-d').focus(); }
    }
    function renderItems() {
        itemsEl.textContent = '';
        S.items.forEach(function (it, i) { itemsEl.appendChild(itemRow(it, i)); });
    }

    // ── Preview ── (textContent only: user input is never parsed as HTML)
    function pv(name, text) { root.querySelectorAll('[data-pv="' + name + '"]').forEach(function (el) { el.textContent = text; el.classList.remove('is-ph'); }); }
    function ph(name, value, hint) { root.querySelectorAll('[data-pv="' + name + '"]').forEach(function (el) { el.textContent = value || hint; el.classList.toggle('is-ph', !value); }); }
    function update() {
        var t = totals(), isInv = S.type === 'invoice';
        pv('type', isInv ? 'Invoice' : 'Quote');
        pv('number', S.number);
        pv('quoteRef', isInv && S.quoteRef ? 'For quote ' + S.quoteRef : '');
        ph('from.name', S.from.name, 'Your business name');
        ph('from.email', S.from.email, 'you@example.com');
        pv('from.address', S.from.address);
        ph('to.name', S.to.name, 'Client name');
        pv('to.email', S.to.email);
        pv('to.address', S.to.address);
        pv('date', fmtDate(S.date));
        pv('dueLabel', isInv ? 'Due' : 'Valid until');
        pv('due', fmtDate(S.due));
        pv('subtotal', money(t.sub));
        var taxName = (S.taxName || '').trim() || 'Tax';
        pv('taxLabel', taxName + ' (' + (t.rate || 0) + '%)');
        var brk = document.getElementById('qb-form-break');
        brk.hidden = !t.rate;
        brk.textContent = t.rate ? 'Subtotal ' + money(t.sub) + ' \u00B7 ' + taxName + ' ' + money(t.tax) : '';
        pv('taxAmount', money(t.tax));
        pv('total', money(t.total));
        pv('notes', S.notes);
        root.querySelector('[data-pv-tax-row]').hidden = !t.rate;
        renderLogo();
        renderPay();
        if (curRender) curRender();
        if (dateRender) dateRender();
        document.getElementById('qb-form-total').textContent = money(t.total);

        var sym = curSymbol(), only = S.items.length === 1;
        [].forEach.call(itemsEl.children, function (li) {
            var it = li._it; if (!it) return;
            li.querySelector('.qb__price-sym').textContent = sym;
            var amt = li.querySelector('.qb__line-amt');
            amt.textContent = money(num(it.q) * num(it.p));
            amt.classList.toggle('is-zero', !(num(it.q) * num(it.p)));
            var rm = li.querySelector('.qb__rm');
            rm.setAttribute('aria-label', only ? 'Clear item' : 'Remove item');
            rm.title = only ? 'Clear' : 'Remove';
        });

        pvItems.textContent = '';
        S.items.forEach(function (it) {
            var tr = document.createElement('tr');
            [it.d || 'Item or service', String(num(it.q)), money(num(it.p)), money(num(it.q) * num(it.p))].forEach(function (v, i) {
                var td = document.createElement('td'); td.textContent = v;
                if (i === 0 && !it.d) td.className = 'is-ph';
                tr.appendChild(td);
            });
            pvItems.appendChild(tr);
        });
        save();
    }

    // ── Currency picker: symbol + code when closed, searchable list with names when open ──
    var curRender = null;
    (function () {
        var box = root.querySelector('[data-qb-cur]');
        if (!box) return;
        var sel = box.querySelector('select'), btn = box.querySelector('.qb-cur__btn');
        var pop = box.querySelector('.qb-cur__pop'), search = pop.querySelector('input'), list = pop.querySelector('.qb-cur__list');
        var names = null;
        try { names = new Intl.DisplayNames([navigator.language || 'en'], { type: 'currency' }); } catch (e) {}
        function nameOf(c) { try { return names ? names.of(c) : c; } catch (e) { return c; } }
        function symOf(c) {
            try {
                var part = new Intl.NumberFormat(undefined, { style: 'currency', currency: c, currencyDisplay: 'narrowSymbol' }).formatToParts(0)
                    .filter(function (x) { return x.type === 'currency'; })[0];
                // No short symbol (e.g. KES)? Use the generic currency sign so the code isn't shown twice
                return part && part.value !== c ? part.value : '¤';
            } catch (e) { return '¤'; }
        }
        var items = [].map.call(sel.options, function (o) {
            var c = o.value, n = nameOf(c), sy = symOf(c);
            o.textContent = c + ' · ' + n;   // nicer fallback text in the native select too
            var li = document.createElement('li');
            li.className = 'qb-cur__opt'; li.id = 'qb-cur-' + c; li.setAttribute('role', 'option'); li.dataset.code = c;
            var a = document.createElement('span'); a.className = 'qb-cur__opt-sym'; a.textContent = sy;
            var b = document.createElement('span'); b.className = 'qb-cur__opt-code'; b.textContent = c;
            var d = document.createElement('span'); d.className = 'qb-cur__opt-name'; d.textContent = n;
            var k = document.createElement('i'); k.className = 'ph ph-check qb-cur__opt-tick'; k.setAttribute('aria-hidden', 'true');
            li.appendChild(a); li.appendChild(b); li.appendChild(d); li.appendChild(k);
            li.addEventListener('mousedown', function (e) { e.preventDefault(); });   // keep focus in the search box
            li.addEventListener('click', function () { choose(c); });
            li.addEventListener('mousemove', function () { setActive(li); });
            list.appendChild(li);
            return { code: c, hay: (c + ' ' + n + ' ' + sy).toLowerCase(), el: li };
        });
        var empty = document.createElement('li');
        empty.className = 'qb-cur__empty'; empty.textContent = 'No matching currency'; empty.hidden = true;
        list.appendChild(empty);
        box.classList.add('is-enhanced');

        var active = null;
        function visible() { return items.filter(function (it) { return !it.el.hidden; }); }
        function setActive(li) {
            if (active) active.classList.remove('is-active');
            active = li || null;
            if (active) {
                active.classList.add('is-active'); search.setAttribute('aria-activedescendant', active.id);
                // scroll only the list, never the page
                var top = active.offsetTop - list.offsetTop, bottom = top + active.offsetHeight;
                if (top < list.scrollTop) list.scrollTop = top;
                else if (bottom > list.scrollTop + list.clientHeight) list.scrollTop = bottom - list.clientHeight;
            }
            else search.removeAttribute('aria-activedescendant');
        }
        function filter() {
            var q = search.value.trim().toLowerCase();
            items.forEach(function (it) { it.el.hidden = q && it.hay.indexOf(q) === -1; });
            var v = visible(); empty.hidden = v.length > 0;
            setActive(v[0] ? v[0].el : null);
        }
        function place() {
            var r = btn.getBoundingClientRect(), w = Math.min(320, window.innerWidth - 24);
            var left = Math.max(12, Math.min(r.left, window.innerWidth - w - 12));
            var below = window.innerHeight - r.bottom - 12, h = Math.min(340, Math.max(below, r.top - 12));
            pop.style.width = w + 'px'; pop.style.left = left + 'px';
            pop.style.maxHeight = h + 'px';
            if (below >= Math.min(300, r.top - 12)) { pop.style.top = (r.bottom + 6) + 'px'; pop.style.bottom = ''; }
            else { pop.style.top = ''; pop.style.bottom = (window.innerHeight - r.top + 6) + 'px'; }
        }
        function open() {
            if (!pop.hidden) return;
            search.value = ''; filter();
            pop.hidden = false; btn.setAttribute('aria-expanded', 'true');
            place();
            var cur = items.filter(function (it) { return it.code === sel.value; })[0];
            if (cur) setActive(cur.el);
            search.focus({ preventScroll: true });
        }
        function close(refocus) {
            if (pop.hidden) return;
            pop.hidden = true; btn.setAttribute('aria-expanded', 'false');
            if (refocus) btn.focus({ preventScroll: true });
        }
        function choose(c) {
            sel.value = c;
            sel.dispatchEvent(new Event('change', { bubbles: true }));
            close(true);
        }
        btn.addEventListener('click', function () { pop.hidden ? open() : close(true); });
        btn.addEventListener('keydown', function (e) { if (e.key === 'ArrowDown' || e.key === 'ArrowUp') { e.preventDefault(); open(); } });
        search.addEventListener('input', filter);
        search.addEventListener('keydown', function (e) {
            var v = visible().map(function (it) { return it.el; }), i = v.indexOf(active);
            if (e.key === 'ArrowDown') { e.preventDefault(); setActive(v[Math.min(v.length - 1, i + 1)] || v[0]); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); setActive(v[Math.max(0, i - 1)] || v[0]); }
            else if (e.key === 'Home') { e.preventDefault(); setActive(v[0]); }
            else if (e.key === 'End') { e.preventDefault(); setActive(v[v.length - 1]); }
            else if (e.key === 'Enter') { e.preventDefault(); if (active) choose(active.dataset.code); }
            else if (e.key === 'Escape') { e.preventDefault(); e.stopPropagation(); close(true); }
            else if (e.key === 'Tab') { close(false); }
        });
        document.addEventListener('mousedown', function (e) { if (!pop.hidden && !box.contains(e.target)) close(false); });
        window.addEventListener('resize', function () { close(false); });
        window.addEventListener('scroll', function (e) { if (!pop.hidden && !pop.contains(e.target)) close(false); }, true);

        curRender = function () {
            var c = sel.value;
            btn.querySelector('.qb-cur__sym').textContent = symOf(c);
            btn.querySelector('.qb-cur__code').textContent = c;
            btn.title = nameOf(c);
            items.forEach(function (it) { it.el.setAttribute('aria-selected', it.code === c ? 'true' : 'false'); });
        };
        curRender();
    })();

    // ── Date pickers: friendly date when closed, a small calendar when open ──
    var dateRender = null;
    (function () {
        var fields = [].slice.call(root.querySelectorAll('[data-qb-date]'));
        if (!fields.length) return;
        var loc = navigator.language || 'en-US';

        // First day of the week for the visitor's region (Sunday for US-style calendars, Monday otherwise)
        var firstDay = 1;
        try {
            var li = new Intl.Locale(loc);
            var wi = li.getWeekInfo ? li.getWeekInfo() : li.weekInfo;
            if (wi && wi.firstDay) firstDay = wi.firstDay % 7;
            else if (/-(US|CA|JP|BR|MX|PH|IL|ZA|IN|SA)$/i.test(loc) || loc === 'en') firstDay = 0;
        } catch (e) { if (/-(US|CA|JP|BR|MX)$/i.test(loc)) firstDay = 0; }

        function parse(v) { var m = /^(\d{4})-(\d{2})-(\d{2})$/.exec(v || ''); return m ? new Date(+m[1], +m[2] - 1, +m[3]) : null; }
        function fmt(d) { return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0'); }
        function nice(d) { try { return d.toLocaleDateString(loc, { day: 'numeric', month: 'short', year: 'numeric' }); } catch (e) { return fmt(d); } }
        function same(a, b) { return a && b && a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate(); }
        function addD(d, n) { var x = new Date(d); x.setDate(x.getDate() + n); return x; }

        var weekdays = [];
        for (var i = 0; i < 7; i++) {
            var wd = new Date(2024, 0, 7 + ((firstDay + i) % 7));   // 7 Jan 2024 was a Sunday
            try { weekdays.push(wd.toLocaleDateString(loc, { weekday: 'narrow' })); } catch (e) { weekdays.push('SMTWTFS'[wd.getDay()]); }
        }

        // One shared popover
        var pop = document.createElement('div');
        pop.className = 'qb-cal'; pop.hidden = true;
        pop.setAttribute('role', 'dialog'); pop.setAttribute('aria-modal', 'false');
        pop.innerHTML =
            '<div class="qb-cal__head">' +
                '<button type="button" class="qb-cal__nav" data-cal-nav="-1" aria-label="Previous month"><i class="ph ph-caret-left" aria-hidden="true"></i></button>' +
                '<div class="qb-cal__title" aria-live="polite"></div>' +
                '<button type="button" class="qb-cal__nav" data-cal-nav="1" aria-label="Next month"><i class="ph ph-caret-right" aria-hidden="true"></i></button>' +
            '</div>' +
            '<div class="qb-cal__week" aria-hidden="true"></div>' +
            '<div class="qb-cal__grid"></div>' +
            '<div class="qb-cal__foot"></div>';
        root.appendChild(pop);
        var titleEl = pop.querySelector('.qb-cal__title'), grid = pop.querySelector('.qb-cal__grid'), foot = pop.querySelector('.qb-cal__foot');
        weekdays.forEach(function (w) { var sp = document.createElement('span'); sp.textContent = w; pop.querySelector('.qb-cal__week').appendChild(sp); });

        var cur = null;       // { field, input, btn, key }
        var view = null;      // first of the month being shown
        var focusDay = null;  // keyboard focus date

        function minFor(key) { return key === 'due' ? parse(S.date) : null; }

        function draw(focus) {
            var sel = parse(cur.input.value), today = new Date(), min = minFor(cur.key);
            try { titleEl.textContent = view.toLocaleDateString(loc, { month: 'long', year: 'numeric' }); } catch (e) { titleEl.textContent = fmt(view).slice(0, 7); }
            grid.textContent = '';
            var start = addD(view, -((view.getDay() - firstDay + 7) % 7));
            for (var n = 0; n < 42; n++) {
                var d = addD(start, n), b = document.createElement('button');
                b.type = 'button'; b.className = 'qb-cal__day'; b.textContent = d.getDate();
                b.dataset.date = fmt(d);
                try { b.setAttribute('aria-label', d.toLocaleDateString(loc, { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })); } catch (e) {}
                if (d.getMonth() !== view.getMonth()) b.classList.add('is-out');
                if (same(d, today)) b.classList.add('is-today');
                if (same(d, sel)) { b.classList.add('is-sel'); b.setAttribute('aria-pressed', 'true'); }
                if (min && d < min) { b.disabled = true; }
                b.tabIndex = same(d, focusDay) ? 0 : -1;
                grid.appendChild(b);
            }
            if (!grid.querySelector('[tabindex="0"]')) { var first = grid.querySelector('.qb-cal__day:not(.is-out):not(:disabled)'); if (first) first.tabIndex = 0; }
            if (focus) { var f = grid.querySelector('[tabindex="0"]'); if (f) f.focus({ preventScroll: true }); }
        }

        function drawFoot() {
            foot.textContent = '';
            function chip(label, date) {
                var b = document.createElement('button'); b.type = 'button'; b.className = 'qb-cal__chip'; b.textContent = label;
                b.addEventListener('click', function () { choose(date); });
                foot.appendChild(b);
            }
            if (cur.key === 'due') {
                var base = parse(S.date) || new Date();
                [7, 14, 30].forEach(function (n) { chip('+' + n + ' days', addD(base, n)); });
            } else {
                chip('Today', new Date());
            }
        }

        function place() {
            var r = cur.btn.getBoundingClientRect(), w = 284;
            var left = Math.max(12, Math.min(r.left, window.innerWidth - w - 12));
            var below = window.innerHeight - r.bottom - 12, need = 330;
            pop.style.left = left + 'px';
            if (below >= need || below >= r.top - 12) { pop.style.top = (r.bottom + 6) + 'px'; pop.style.bottom = ''; }
            else { pop.style.top = ''; pop.style.bottom = (window.innerHeight - r.top + 6) + 'px'; }
        }

        function open(f) {
            if (cur && cur.field === f.field && !pop.hidden) { close(true); return; }
            if (!pop.hidden) close(false);
            cur = f;
            var sel = parse(f.input.value) || new Date();
            view = new Date(sel.getFullYear(), sel.getMonth(), 1);
            focusDay = sel;
            pop.setAttribute('aria-label', f.field.querySelector('span').textContent);
            draw(false); drawFoot();
            pop.hidden = false; f.btn.setAttribute('aria-expanded', 'true');
            place();
            draw(true);
        }
        function close(refocus) {
            if (pop.hidden || !cur) return;
            pop.hidden = true; cur.btn.setAttribute('aria-expanded', 'false');
            if (refocus) cur.btn.focus({ preventScroll: true });
        }
        function choose(d) {
            cur.input.value = fmt(d);
            cur.input.dispatchEvent(new Event('change', { bubbles: true }));
            close(true);
        }
        function moveFocus(d) {
            var min = minFor(cur.key);
            if (min && d < min) d = min;
            focusDay = d;
            if (d.getMonth() !== view.getMonth() || d.getFullYear() !== view.getFullYear()) view = new Date(d.getFullYear(), d.getMonth(), 1);
            draw(true);
        }

        pop.querySelectorAll('[data-cal-nav]').forEach(function (b) {
            b.addEventListener('click', function () {
                var n = +b.dataset.calNav;
                view = new Date(view.getFullYear(), view.getMonth() + n, 1);
                focusDay = new Date(view.getFullYear(), view.getMonth(), Math.min(focusDay ? focusDay.getDate() : 1, 28));
                draw(false);
            });
        });
        grid.addEventListener('click', function (e) {
            var b = e.target.closest('.qb-cal__day');
            if (b && !b.disabled) choose(parse(b.dataset.date));
        });
        grid.addEventListener('keydown', function (e) {
            var b = e.target.closest('.qb-cal__day'); if (!b) return;
            var d = parse(b.dataset.date), map = { ArrowLeft: -1, ArrowRight: 1, ArrowUp: -7, ArrowDown: 7 };
            if (map[e.key] !== undefined) { e.preventDefault(); moveFocus(addD(d, map[e.key])); }
            else if (e.key === 'PageUp' || e.key === 'PageDown') { e.preventDefault(); var x = new Date(d); x.setMonth(x.getMonth() + (e.key === 'PageUp' ? -1 : 1)); moveFocus(x); }
            else if (e.key === 'Home') { e.preventDefault(); moveFocus(addD(d, -((d.getDay() - firstDay + 7) % 7))); }
            else if (e.key === 'End') { e.preventDefault(); moveFocus(addD(d, 6 - ((d.getDay() - firstDay + 7) % 7))); }
        });
        pop.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { e.preventDefault(); e.stopPropagation(); close(true); }
        });
        document.addEventListener('mousedown', function (e) {
            if (pop.hidden || pop.contains(e.target) || (cur && cur.btn.contains(e.target))) return;
            close(false);
        });
        window.addEventListener('resize', function () { close(false); });
        window.addEventListener('scroll', function (e) { if (!pop.hidden && !pop.contains(e.target)) close(false); }, true);

        var items = fields.map(function (field) {
            var f = { field: field, key: field.dataset.qbDate, input: field.querySelector('input[type="date"]'), btn: field.querySelector('.qb-date__btn') };
            f.btn.addEventListener('click', function () { open(f); });
            f.btn.addEventListener('keydown', function (e) { if (e.key === 'ArrowDown') { e.preventDefault(); open(f); } });
            field.classList.add('is-enhanced');
            return f;
        });

        dateRender = function () {
            items.forEach(function (f) {
                var d = parse(f.input.value), v = f.btn.querySelector('.qb-date__value');
                v.textContent = d ? nice(d) : 'Pick a date';
                v.classList.toggle('is-ph', !d);
            });
        };
        dateRender();
    })();

    // ── Logo: shrunk in the browser and kept with the draft; never uploaded ──
    var logoInput = document.getElementById('qb-logo-input');
    var logoSlot = root.querySelector('[data-qb-logo-slot]');
    var logoImg = root.querySelector('[data-qb-logo-img]');
    var logoErr = root.querySelector('[data-qb-logo-err]');
    function logoMsg(m) { logoErr.textContent = m || ''; logoErr.hidden = !m; }
    // Logos often come with empty space around them (transparent, or a white background), which
    // pushes the visible mark away from the business name. Crop that border, then fit 480 × 240.
    function fitCanvas(src, w, h, maxW, maxH) {
        var k = Math.min(1, maxW / w, maxH / h);
        var c = document.createElement('canvas');
        c.width = Math.max(1, Math.round(w * k)); c.height = Math.max(1, Math.round(h * k));
        c.getContext('2d').drawImage(src, 0, 0, w, h, 0, 0, c.width, c.height);
        return c;
    }
    function trimCanvas(c) {
        var w = c.width, h = c.height, d;
        try { d = c.getContext('2d').getImageData(0, 0, w, h).data; } catch (e) { return c; }
        // The background is whatever fills the top-left corner: transparent, white or any flat colour
        var br = d[0], bg = d[1], bb = d[2], ba = d[3], tol = 24;
        function isBg(i) {
            var a = d[i + 3];
            if (ba < 16) return a < 16;
            return Math.abs(a - ba) <= tol && Math.abs(d[i] - br) <= tol && Math.abs(d[i + 1] - bg) <= tol && Math.abs(d[i + 2] - bb) <= tol;
        }
        var top = h, left = w, right = -1, bottom = -1;
        for (var y = 0; y < h; y++) {
            for (var x = 0; x < w; x++) {
                if (!isBg((y * w + x) * 4)) {
                    if (x < left) left = x; if (x > right) right = x;
                    if (y < top) top = y; if (y > bottom) bottom = y;
                }
            }
        }
        if (right < 0) return c;   // nothing but background: keep the image as it is
        var tw = right - left + 1, th = bottom - top + 1;
        if (tw === w && th === h) return c;
        var out = document.createElement('canvas');
        out.width = tw; out.height = th;
        out.getContext('2d').drawImage(c, left, top, tw, th, 0, 0, tw, th);
        return out;
    }
    function logoDataUrl(img) {
        var w = img.naturalWidth || 480, h = img.naturalHeight || 240;
        var big = fitCanvas(img, w, h, 1440, 720);   // trim at a generous size so the result stays sharp
        var t = trimCanvas(big);
        return fitCanvas(t, t.width, t.height, 480, 240).toDataURL('image/png');
    }
    // Logos saved before cropping existed get the same treatment once
    if (S.logo && !S.logoTrimmed) {
        (function () {
            var old = new Image();
            old.onload = function () {
                try { S.logo = logoDataUrl(old); } catch (e) {}
                S.logoTrimmed = true;
                update();
            };
            old.src = S.logo;
        })();
    }
    function renderLogo() {
        var has = !!S.logo;
        logoSlot.classList.toggle('is-empty', !has);
        logoImg.hidden = !has;
        if (has) { if (logoImg.getAttribute('src') !== S.logo) logoImg.src = S.logo; } else { logoImg.removeAttribute('src'); }
        root.querySelector('[data-qb-logo-remove]').hidden = !has;
        root.querySelector('.qb-paper__logo-add').hidden = has;
        root.querySelector('[data-qb-logo-label]').textContent = has ? 'Change logo' : 'Add logo';
    }
    function pickLogo() { logoInput.value = ''; logoInput.click(); }
    root.querySelectorAll('[data-qb-logo-pick]').forEach(function (b) { b.addEventListener('click', pickLogo); });
    logoImg.addEventListener('click', pickLogo);
    root.querySelector('[data-qb-logo-remove]').addEventListener('click', function () { S.logo = ''; update(); });
    logoInput.addEventListener('change', function () {
        var file = logoInput.files && logoInput.files[0];
        if (!file) return;
        logoMsg('');
        if (!/^image\/(png|jpeg|webp|svg\+xml)$/.test(file.type)) { logoMsg('Please choose a PNG, JPG, WebP or SVG image.'); return; }
        if (file.size > 5 * 1024 * 1024) { logoMsg('That image is over 5 MB. Please choose a smaller one.'); return; }
        var reader = new FileReader();
        reader.onload = function () {
            var img = new Image();
            img.onload = function () {
                try { S.logo = logoDataUrl(img); S.logoTrimmed = true; } catch (e) { S.logo = ''; }
                update();
            };
            img.onerror = function () { logoMsg('That image could not be read. Please try another file.'); };
            img.src = reader.result;
        };
        reader.readAsDataURL(file);
    });

    // ── Get paid: payment link (with QR code) and bank / mobile money details ──
    var payBox = root.querySelector('[data-qb-pay-box]');
    var payToggle = root.querySelector('[data-qb-pay-toggle]');
    var payFields = document.getElementById('qb-pay-fields');
    var payErr = document.getElementById('qb-pay-err');
    var pvPay = root.querySelector('[data-qb-pv-pay]');
    var pvPayAdd = root.querySelector('[data-qb-pv-pay-add]');
    var pvLinkRow = root.querySelector('[data-qb-pv-link-row]');
    var pvLink = root.querySelector('[data-qb-pv-link]');
    var pvQr = root.querySelector('[data-qb-pv-qr]');
    var pvQrSvg = root.querySelector('[data-qb-pv-qr-svg]');
    var qrFor = null;
    // Accept "paypal.me/you" as well as full links; only http(s) is ever used
    function payUrl(v) {
        v = (v || '').trim();
        if (!v) return '';
        if (!/^[a-z][a-z0-9+.-]*:/i.test(v)) {
            if (/\s/.test(v) || v.indexOf('.') < 1) return null;
            v = 'https://' + v;
        }
        try {
            var u = new URL(v);
            if ((u.protocol !== 'https:' && u.protocol !== 'http:') || u.hostname.indexOf('.') < 1) return null;
            return u.href;
        } catch (e) { return null; }
    }
    function shortUrl(href) {
        var t = href.replace(/^https?:\/\//i, '').replace(/^www\./i, '').replace(/\/$/, '');
        return t.length > 48 ? t.slice(0, 47) + '\u2026' : t;
    }
    function drawQr(text) {
        if (qrFor === text) return true;
        if (typeof window.qrcode !== 'function') return false;
        try {
            var qr = window.qrcode(0, 'M');
            qr.addData(text, 'Byte');
            qr.make();
            var n = qr.getModuleCount(), q = 2, d = '';   // 2-module quiet zone; the figure adds white space too
            for (var r = 0; r < n; r++) for (var c = 0; c < n; c++) if (qr.isDark(r, c)) d += 'M' + (c + q) + ' ' + (r + q) + 'h1v1h-1z';
            pvQrSvg.setAttribute('viewBox', '0 0 ' + (n + 2 * q) + ' ' + (n + 2 * q));
            pvQrSvg.querySelector('path').setAttribute('d', d);
            qrFor = text;
            return true;
        } catch (e) { qrFor = null; return false; }
    }
    function payOpen(open, focus) {
        payToggle.setAttribute('aria-expanded', open);
        payFields.hidden = !open;
        payBox.classList.toggle('is-open', open);
        if (open && focus) {
            var f = payFields.querySelector('[data-qb="pay.link"]'); if (f) f.focus({ preventScroll: true });
            payBox.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        }
    }
    payToggle.addEventListener('click', function () { payOpen(payFields.hidden, payFields.hidden); });
    pvPayAdd.addEventListener('click', function () { setView('edit'); payOpen(true, true); });
    function renderPay() {
        var isInv = S.type === 'invoice';
        var link = payUrl(S.pay.link), details = (S.pay.details || '').trim();
        var bad = link === null;
        payErr.hidden = !bad;
        payErr.textContent = bad ? 'That doesn\'t look like a web link. Try something like paypal.me/yourname.' : '';
        var linkInput = payFields.querySelector('[data-qb="pay.link"]');
        if (linkInput) linkInput.setAttribute('aria-invalid', bad ? 'true' : 'false');

        var has = !!(link || details);
        pvPay.hidden = !has;
        pvPayAdd.hidden = has;
        payBox.classList.toggle('is-set', has);
        root.querySelector('[data-qb-pay-sub]').textContent = has
            ? (link ? 'Link' + (details ? ' and bank details' : '') + ' added, with a QR code' : 'Bank details added')
            : 'Add a payment link or bank details. We add a QR code.';
        if (!has) return;

        pv('payLabel', isInv ? 'How to pay' : 'Payment details');
        pv('pay.details', details);
        pv('payRef', isInv && S.number ? 'Please use ' + S.number + ' as the reference.' : '');
        pvLinkRow.hidden = !link;
        if (link) { pvLink.href = link; pvLink.textContent = shortUrl(link); } else { pvLink.removeAttribute('href'); pvLink.textContent = ''; }
        pvQr.hidden = !(link && drawQr(link));
    }
    // Opened by default once something is filled in, so people see what they entered
    if (S.pay && (S.pay.link || S.pay.details)) payOpen(true, false);
    window.addEventListener('load', function () { if (pvQr.hidden && payUrl(S.pay.link)) renderPay(); });

    // ── Type (quote / invoice) ──
    function setType(type) {
        var was = S.type, isInv = type === 'invoice';
        S.type = type;
        if (was !== type && /^(QUO|INV)-\d+$/.test(S.number)) S.number = S.number.replace(/^(QUO|INV)/, isInv ? 'INV' : 'QUO');
        root.querySelectorAll('[data-qb-type]').forEach(function (b) { b.setAttribute('aria-selected', b.dataset.qbType === type); });
        root.querySelector('[data-qb-label="number"]').textContent = isInv ? 'Invoice number' : 'Quote number';
        root.querySelector('[data-qb-label="due"]').textContent = isInv ? 'Due date' : 'Valid until';
        root.querySelector('[data-qb-send-label]').textContent = isInv ? 'Send invoice' : 'Send quote';
        if (convertBtn) convertBtn.hidden = isInv;
        root.querySelectorAll('[data-qb-doc-word]').forEach(function (el) { el.textContent = isInv ? 'invoice' : 'quote'; });
        fillFields();
        update();
    }
    root.querySelectorAll('[data-qb-type]').forEach(function (b) { b.addEventListener('click', function () { setType(b.dataset.qbType); }); });

    // ── Accepted quote → invoice: same client and items, invoice number, dates from today, undo for a few seconds ──
    var convertBtn = root.querySelector('[data-qb-convert]');
    var toast = document.getElementById('qb-toast');
    var toastMsg = toast.querySelector('[data-qb-toast-msg]');
    var toastTimer = null, undoSnap = null;
    function hideToast() { clearTimeout(toastTimer); toast.hidden = true; undoSnap = null; }
    function showToast(msg) {
        toastMsg.textContent = msg;
        toast.hidden = false;
        toast.classList.remove('is-in'); void toast.offsetWidth; toast.classList.add('is-in');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(hideToast, 12000);
    }
    // Stay open while the pointer or keyboard is on it
    toast.addEventListener('mouseenter', function () { clearTimeout(toastTimer); });
    toast.addEventListener('focusin', function () { clearTimeout(toastTimer); });
    toast.addEventListener('mouseleave', function () { if (!toast.hidden && !toast.contains(document.activeElement)) { clearTimeout(toastTimer); toastTimer = setTimeout(hideToast, 4000); } });
    toast.addEventListener('focusout', function (e) { if (!toast.hidden && !toast.contains(e.relatedTarget)) { clearTimeout(toastTimer); toastTimer = setTimeout(hideToast, 4000); } });
    function invoiceNumberFor(q) {
        q = (q || '').trim();
        if (/^QUO-\d+$/i.test(q)) return 'INV-' + q.slice(4);
        var m = /(\d+)\s*$/.exec(q);
        return 'INV-' + (m ? m[1] : '0001');
    }
    convertBtn.addEventListener('click', function () {
        undoSnap = JSON.stringify(S);
        var quoteNo = (S.number || '').trim();
        S.quoteRef = quoteNo;
        S.number = invoiceNumberFor(quoteNo);
        S.date = iso(new Date());
        S.due = addDays(14);
        setType('invoice');
        setView('preview');
        var send = root.querySelector('[data-qb-send]');
        if (send) send.focus({ preventScroll: true });
        showToast('Now invoice ' + S.number + (quoteNo ? ' for quote ' + quoteNo : '') + '. Dated today, due in 14 days.');
    });
    toast.querySelector('[data-qb-undo]').addEventListener('click', function () {
        if (!undoSnap) return hideToast();
        try {
            var back = JSON.parse(undoSnap);
            S = Object.assign(fresh(back.type), back);
        } catch (e) { return hideToast(); }
        hideToast();
        renderItems();
        setType(S.type);
        convertBtn.focus({ preventScroll: true });
    });

    // ── Simple fields ──
    var fields = [].slice.call(form.querySelectorAll('[data-qb]'));
    var notesEl = form.querySelector('[data-qb="notes"]');
    function growNotes() {
        if (!notesEl) return;
        notesEl.style.height = '';
        var border = notesEl.offsetHeight - notesEl.clientHeight;
        if (notesEl.scrollHeight > notesEl.clientHeight + 1) {   // only grow when the text actually overflows
            notesEl.style.height = Math.min(notesEl.scrollHeight + border, 112) + 'px';
        }
        notesEl.style.overflowY = notesEl.scrollHeight + border > 112 ? 'auto' : 'hidden';
    }
    function fillFields() { fields.forEach(function (el) { el.value = get(el.dataset.qb) || ''; }); growNotes(); if (typeof growPay === 'function') growPay(); }
    // Moving the quote / invoice date moves the due date by the same number of days, so the terms stay the same
    function ymd(v) { var m = /^(\d{4})-(\d{2})-(\d{2})$/.exec(v || ''); return m ? new Date(+m[1], +m[2] - 1, +m[3]) : null; }
    var bumpTimer;
    function setField(path, v) {
        if (path === 'date') {
            var was = ymd(S.date), now = ymd(v), due = ymd(S.due);
            if (was && now && due) {
                var shift = Math.round((now - was) / 864e5);
                if (shift) {
                    due.setDate(due.getDate() + shift);
                    S.due = iso(due);
                    var dueEl = form.querySelector('[data-qb="due"]');
                    if (dueEl) dueEl.value = S.due;
                    var box = root.querySelector('[data-qb-date="due"]');
                    if (box) {
                        box.classList.remove('is-bumped'); void box.offsetWidth; box.classList.add('is-bumped');
                        clearTimeout(bumpTimer); bumpTimer = setTimeout(function () { box.classList.remove('is-bumped'); }, 1400);
                    }
                }
            }
        }
        set(path, v);
    }
    if (notesEl) notesEl.addEventListener('input', growNotes);
    var payDetailsEl = form.querySelector('[data-qb="pay.details"]');
    function growPay() {
        if (!payDetailsEl || payFields.hidden) return;
        payDetailsEl.style.height = '';
        var border = payDetailsEl.offsetHeight - payDetailsEl.clientHeight;
        if (payDetailsEl.scrollHeight > payDetailsEl.clientHeight + 1) payDetailsEl.style.height = Math.min(payDetailsEl.scrollHeight + border, 112) + 'px';
        payDetailsEl.style.overflowY = payDetailsEl.scrollHeight + border > 112 ? 'auto' : 'hidden';
    }
    if (payDetailsEl) payDetailsEl.addEventListener('input', growPay);
    payToggle.addEventListener('click', growPay);
    fields.forEach(function (el) {
        el.addEventListener('input', function () { setField(el.dataset.qb, el.value); update(); });
        el.addEventListener('change', function () { setField(el.dataset.qb, el.value); update(); });
    });
    form.addEventListener('submit', function (e) { e.preventDefault(); });

    root.querySelector('[data-qb-add]').addEventListener('click', addItem);

    root.querySelector('[data-qb-reset]').addEventListener('click', function () {
        S = fresh(S.type);
        payOpen(false, false);
        hideToast();
        renderItems(); fillFields(); update();
        var first = form.querySelector('[data-qb="from.name"]'); if (first) first.focus();
    });

    // ── Edit / Preview (phones) ──
    function setView(v) {
        root.dataset.view = v;
        root.querySelectorAll('[data-qb-view]').forEach(function (b) { b.setAttribute('aria-selected', b.dataset.qbView === v); });
    }
    root.querySelectorAll('[data-qb-view]').forEach(function (b) { b.addEventListener('click', function () { setView(b.dataset.qbView); }); });

    // ── Other "Create a quote / invoice" links on the page jump here ──
    document.addEventListener('click', function (e) {
        var a = e.target.closest && e.target.closest('[data-builder]');
        if (!a) return;
        e.preventDefault();
        setType(a.getAttribute('data-builder') === 'invoice' ? 'invoice' : 'quote');
        setView('edit');
        var section = document.getElementById('top');
        var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        section.scrollIntoView({ behavior: reduce ? 'auto' : 'smooth', block: 'start' });
        var first = form.querySelector('[data-qb="from.name"]');
        if (first) setTimeout(function () { first.focus({ preventScroll: true }); }, reduce ? 0 : 400);
    });

    // ── PDF: print a copy of the paper from a body-level holder, so the rest of the page is left out ──
    function printPdf() {
        var holder = document.createElement('div');
        holder.id = 'qb-print';
        holder.appendChild(document.getElementById('qb-paper').cloneNode(true));
        holder.firstChild.removeAttribute('id');
        document.body.appendChild(holder);
        var title = document.title;
        document.title = (S.type === 'invoice' ? 'Invoice ' : 'Quote ') + (S.number || '');
        document.documentElement.classList.add('qb-printing');
        var cleaned = false;
        var done = function () {
            if (cleaned) return; cleaned = true;
            document.documentElement.classList.remove('qb-printing');
            document.title = title;
            if (holder.parentNode) holder.parentNode.removeChild(holder);
            window.removeEventListener('afterprint', done);
        };
        window.addEventListener('afterprint', done);
        window.print();
        setTimeout(done, 1500);   // some browsers skip afterprint
    }
    // Direct download: draw a copy of the paper at A4 width, cut it into pages between rows, save.
    var PDF_LIBS = ['{{ asset('useluminii/assets/js/html2canvas-1.4.1.min.js') }}', '{{ asset('useluminii/assets/js/jspdf-3.0.3.umd.min.js') }}'];
    var pdfLibs = null, pdfBusy = false;
    function loadScript(src) {
        return new Promise(function (resolve, reject) {
            var s = document.createElement('script');
            s.src = src; s.async = true;
            s.onload = resolve; s.onerror = function () { reject(new Error('Could not load ' + src)); };
            document.head.appendChild(s);
        });
    }
    function loadPdfLibs() {
        if (window.html2canvas && window.jspdf) return Promise.resolve();
        if (!pdfLibs) pdfLibs = Promise.all(PDF_LIBS.map(loadScript)).catch(function (e) { pdfLibs = null; throw e; });
        return pdfLibs;
    }
    function pdfName() {
        var name = (S.type === 'invoice' ? 'Invoice' : 'Quote') + (S.number ? ' ' + S.number : '') + ((S.to.name || '').trim() ? ' - ' + S.to.name.trim() : '');
        return name.replace(/[\\/:*?"<>|\u0000-\u001F]+/g, '').replace(/\s+/g, ' ').trim().slice(0, 100) + '.pdf';
    }
    function setPdfBusy(on) {
        root.querySelectorAll('[data-qb-pdf]').forEach(function (b) {
            b.disabled = on;
            b.classList.toggle('is-busy', on);
            b.setAttribute('aria-busy', on ? 'true' : 'false');
            var ic = b.querySelector('i');
            if (!ic) return;
            if (on) { ic.dataset.was = ic.className; ic.className = 'ph ph-spinner-gap qb-spin'; }
            else if (ic.dataset.was) { ic.className = ic.dataset.was; delete ic.dataset.was; }
        });
    }
    // Footer on every page, centred in the bottom margin:
    // "Powered by [logo]  ·  Created 12 Nov 2026, 14:32 (UTC+2)"; the logo links to the website
    var SITE_URL = 'https://www.useluminii.com';
    var FOOTER_LOGO_SRC = @json(asset('assets/images/logo/useluminii_logos/useluminii_dark.png'));
    var footerLogo = null, pdfCreated = '';
    function loadFooterLogo() {
        if (footerLogo) return Promise.resolve(footerLogo);
        return new Promise(function (resolve) {
            var img = new Image();
            img.onload = function () {
                try {
                    var c = document.createElement('canvas');
                    c.width = img.naturalWidth; c.height = img.naturalHeight;
                    c.getContext('2d').drawImage(img, 0, 0);
                    footerLogo = { data: c.toDataURL('image/png'), ratio: img.naturalWidth / img.naturalHeight };
                } catch (e) { footerLogo = null; }
                resolve(footerLogo);
            };
            img.onerror = function () { resolve(null); };   // the footer falls back to the name in text
            img.src = FOOTER_LOGO_SRC;
        });
    }
    // The built-in PDF font only covers Latin characters, so fall back to digits if the locale uses others
    function createdStamp() {
        var d = new Date(), pad = function (n) { return (n < 10 ? '0' : '') + n; };
        var s = '';
        try { s = d.toLocaleString(undefined, { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }); } catch (e) {}
        s = s.replace(/[   ]/g, ' ').replace(/[‎‏]/g, '');
        if (!s || /[^\x20-\x7E -ÿ]/.test(s)) {
            s = d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()) + ' ' + pad(d.getHours()) + ':' + pad(d.getMinutes());
        }
        var off = -d.getTimezoneOffset(), sign = off >= 0 ? '+' : '-', a = Math.abs(off);
        return s + ' (UTC' + sign + Math.floor(a / 60) + (a % 60 ? ':' + pad(a % 60) : '') + ')';
    }
    function pdfFooter(doc, k, pageW, pageH, margin) {
        var size = 7.5, gap = 3, sep = '   ·   ';
        var grey = [138, 147, 160], ink = [8, 29, 58];
        var logoH = 9, logoW = footerLogo ? logoH * footerLogo.ratio : 0;
        doc.setFontSize(size);
        doc.setFont('helvetica', 'normal');
        var lead = 'Powered by', created = 'Created ' + pdfCreated;
        var wLead = doc.getTextWidth(lead), wSep = doc.getTextWidth(sep), wCreated = doc.getTextWidth(created);
        doc.setFont('helvetica', 'bold');
        var wBrand = footerLogo ? logoW : doc.getTextWidth('useLuminii');
        var total = wLead + gap + wBrand + wSep + wCreated;
        var x = (pageW * k - total) / 2;
        var y = (pageH - margin / 2) * k + size / 3;

        doc.setFont('helvetica', 'normal'); doc.setTextColor(grey[0], grey[1], grey[2]);
        doc.text(lead, x, y);
        x += wLead + gap;
        if (footerLogo) {
            var mid = y - size * 0.35;
            doc.addImage(footerLogo.data, 'PNG', x, mid - logoH / 2, logoW, logoH, 'useluminii-logo', 'FAST');
            doc.link(x, mid - logoH / 2, logoW, logoH, { url: SITE_URL });
        } else {
            doc.setFont('helvetica', 'bold'); doc.setTextColor(ink[0], ink[1], ink[2]);
            doc.text('useLuminii', x, y);
            doc.link(x, y - size, wBrand, size + 3, { url: SITE_URL });
        }
        x += wBrand;
        doc.setFont('helvetica', 'normal'); doc.setTextColor(grey[0], grey[1], grey[2]);
        doc.text(sep + created, x, y);
    }
    function buildPdf() {
        var M = 48, PAGE_W = 794, PAGE_H = 1123, CW = PAGE_W - 2 * M, AVAIL = PAGE_H - 2 * M, SCALE = 2;
        var holder = document.createElement('div');
        holder.className = 'qb-pdf-render';
        holder.setAttribute('aria-hidden', 'true');
        holder.style.width = CW + 'px';
        var paper = document.getElementById('qb-paper').cloneNode(true);
        paper.removeAttribute('id');
        holder.appendChild(paper);
        document.body.appendChild(holder);
        function cleanup() { if (holder.parentNode) holder.parentNode.removeChild(holder); }

        var imgs = [].slice.call(paper.querySelectorAll('img')).filter(function (i) { return !i.hidden && i.getAttribute('src'); });
        return Promise.all(imgs.map(function (img) {
            return img.complete ? null : new Promise(function (r) { img.onload = img.onerror = r; });
        })).then(function () {
            var base = paper.getBoundingClientRect();
            // Places a page may end: the top or bottom of a section or table row
            var breaks = [];
            paper.querySelectorAll('.qb-paper__head, .qb-paper__meta, .qb-paper__table tr, .qb-paper__totals, .qb-paper__pay, .qb-paper__notes').forEach(function (el) {
                var r = el.getBoundingClientRect();
                if (!r.height) return;
                breaks.push(r.top - base.top, r.bottom - base.top);
            });
            // Keep the payment link clickable in the PDF
            var link = null, a = paper.querySelector('[data-qb-pv-link]');
            if (a && a.href && /^https?:/i.test(a.href) && a.getClientRects().length) {
                var lr = a.getBoundingClientRect();
                link = { x: lr.left - base.left, y: lr.top - base.top, w: lr.width, h: lr.height, url: a.href };
            }
            return window.html2canvas(paper, { scale: SCALE, backgroundColor: '#ffffff', logging: false, useCORS: true }).then(function (canvas) {
                var H = canvas.height / SCALE;
                var doc = new window.jspdf.jsPDF({ unit: 'pt', format: 'a4', orientation: 'portrait', compress: true });
                var k = doc.internal.pageSize.getWidth() / PAGE_W;
                var start = 0, first = true;
                while (start < H - 1) {
                    var limit = start + AVAIL, cut;
                    if (limit >= H) cut = H;
                    else {
                        var fits = breaks.filter(function (b) { return b > start + 60 && b <= limit; });
                        cut = fits.length ? Math.max.apply(null, fits) : limit;
                    }
                    var sy = Math.round(start * SCALE), sh = Math.max(1, Math.round((cut - start) * SCALE));
                    var slice = document.createElement('canvas');
                    slice.width = canvas.width; slice.height = sh;
                    var ctx = slice.getContext('2d');
                    ctx.fillStyle = '#ffffff'; ctx.fillRect(0, 0, slice.width, sh);
                    ctx.drawImage(canvas, 0, sy, canvas.width, sh, 0, 0, canvas.width, sh);
                    if (!first) doc.addPage();
                    doc.addImage(slice.toDataURL('image/png'), 'PNG', M * k, M * k, CW * k, (sh / SCALE) * k, undefined, 'FAST');
                    if (link && link.y >= start && link.y + link.h <= cut) {
                        doc.link((M + link.x) * k, (M + link.y - start) * k, link.w * k, link.h * k, { url: link.url });
                    }
                    pdfFooter(doc, k, PAGE_W, PAGE_H, M);
                    first = false;
                    start = cut;
                }
                doc.setProperties({ title: pdfName().replace(/\.pdf$/, ''), creator: 'useLuminii' });
                return doc;
            });
        }).then(function (doc) { cleanup(); return doc; }, function (err) { cleanup(); throw err; });
    }
    function pdf() {
        if (pdfBusy) return;
        closeGate();
        pdfBusy = true; setPdfBusy(true);
        pdfCreated = createdStamp();
        loadPdfLibs()
            .then(loadFooterLogo)
            .then(function () { return document.fonts && document.fonts.ready; })
            .then(buildPdf)
            .then(function (doc) { doc.save(pdfName()); })
            .catch(function (err) {
                if (window.console) console.error('Direct PDF failed, using print instead:', err);
                printPdf();
            })
            .then(function () { pdfBusy = false; setPdfBusy(false); });
    }
    root.querySelectorAll('[data-qb-pdf]').forEach(function (b) { b.addEventListener('click', pdf); });

    // ── Send → early-access capture ──
    var gateOpener = null;
    function showStep(step) { gate.querySelectorAll('[data-qb-gate-step]').forEach(function (el) { el.hidden = el.dataset.qbGateStep !== step; }); }
    function openGate(e) {
        gateOpener = e && e.currentTarget;
        gate.hidden = false; showStep('ask'); gateErr.hidden = true;
        var em = F('email');
        if (!em.value && S.from.email) em.value = S.from.email;
        root.scrollTop = 0;
        em.focus({ preventScroll: true });
    }
    function closeGate() {
        if (gate.hidden) return;
        gate.hidden = true;
        root.scrollTop = 0;
        if (gateOpener && gateOpener.focus) gateOpener.focus({ preventScroll: true });
    }
    root.querySelector('[data-qb-send]').addEventListener('click', openGate);
    gate.querySelectorAll('[data-qb-gate-close]').forEach(function (b) { b.addEventListener('click', closeGate); });
    gate.addEventListener('click', function (e) { if (e.target === gate) closeGate(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !gate.hidden) closeGate(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !wa.hidden) closeWa(); });

    gateForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var email = F('email').value.trim();
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            gateErr.textContent = 'Please enter a valid email address.'; gateErr.hidden = false; F('email').focus(); return;
        }
        var t = totals(), btn = gateForm.querySelector('[type="submit"]');
        var tz = ''; try { tz = Intl.DateTimeFormat().resolvedOptions().timeZone || ''; } catch (err) {}
        btn.disabled = true; gateErr.hidden = true;
        fetch(gateForm.action, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': F('_token').value },
            body: JSON.stringify({
                email: email,
                name: F('name').value.trim(),
                wants: (gateForm.querySelector('input[name="wants"]:checked') || {}).value || '',
                website: F('website').value,
                business: S.from.name,
                doc_type: S.type,
                currency: S.currency,
                lines: t.lines,
                total: Math.round(t.total * 100) / 100,
                timezone: tz
            })
        }).then(function (r) {
            if (r.ok) return r.json();
            return r.json().catch(function () { return {}; }).then(function (j) {
                var first = j.errors && Object.keys(j.errors).length ? j.errors[Object.keys(j.errors)[0]][0] : null;
                throw new Error(first || j.message || (r.status === 429 ? 'Too many tries. Please wait a minute.' : 'Something went wrong. Please try again.'));
            });
        }).then(function () {
            gate.querySelector('[data-qb-done-email]').textContent = email;
            var picked = gateForm.querySelector('input[name="wants"]:checked');
            gate.querySelector('[data-qb-done-vote]').hidden = !picked;
            gate.querySelector('[data-qb-done-vote-label]').textContent = picked ? picked.parentNode.textContent.trim() : '';
            showStep('done');
            var keep = gate.querySelector('[data-qb-gate-step="done"] [data-qb-gate-close]'); if (keep) keep.focus();
        }).catch(function (err) {
            gateErr.textContent = err.message; gateErr.hidden = false;
        }).then(function () { btn.disabled = false; });
    });

    // ── Share on WhatsApp ──
    var wa = document.getElementById('qb-wa');
    var waMsg = wa.querySelector('[data-qb-wa-msg]');
    var waPhone = wa.querySelector('[data-qb-wa-phone]');
    var waErr = document.getElementById('qb-wa-err');
    var waCopyLabel = wa.querySelector('[data-qb-wa-copy-label]');
    var waOpener = null, waCopyTimer = null;
    function waText() {
        var isInv = S.type === 'invoice', t = totals();
        var first = (S.to.name || '').trim().split(/\s+/)[0];
        var from = (S.from.name || '').trim();
        var out = ['Hi' + (first ? ' ' + first : '') + ',', ''];
        var head = 'Here\'s ' + (isInv ? 'invoice' : 'quote') + (S.number ? ' ' + S.number : '') + (from ? ' from ' + from : '') + ' for ' + money(t.total);
        if (S.due) head += (isInv ? ', due ' : ', valid until ') + fmtDate(S.due);
        out.push(head + '.');
        var lines = S.items.filter(function (it) { return (it.d || '').trim(); });
        if (lines.length && lines.length <= 5) {
            out.push('');
            lines.forEach(function (it) { out.push('• ' + it.d.trim() + ': ' + money(num(it.q) * num(it.p))); });
        }
        if (isInv) {
            var link = payUrl(S.pay && S.pay.link), det = ((S.pay && S.pay.details) || '').trim();
            if (link || det) {
                out.push('');
                if (link) out.push('Pay online: ' + link);
                if (det) out.push((link ? 'Or pay to:' : 'Payment details:') + '\n' + det);
                if (S.number) out.push('Reference: ' + S.number);
            }
        } else {
            out.push('', 'Let me know if you\'d like to go ahead.');
        }
        out.push('', 'The PDF is attached. Thank you!');
        return out.join('\n');
    }
    // wa.me wants the full international number, digits only
    function waNumber(v) {
        v = (v || '').trim();
        if (!v) return '';
        var d = v.replace(/[\s().\-]/g, '');
        if (/^\+/.test(d)) d = d.slice(1); else if (/^00/.test(d)) d = d.slice(2); else if (/^0/.test(d)) return null;
        return /^[1-9]\d{6,14}$/.test(d) ? d : null;
    }
    function openWa(e) {
        waOpener = e && e.currentTarget;
        closeGate();
        waMsg.value = waText();
        waPhone.value = (S.to && S.to.phone) || '';
        waErr.hidden = true; waPhone.removeAttribute('aria-invalid');
        waCopyLabel.textContent = 'Copy message';
        wa.hidden = false;
        waMsg.scrollTop = 0;
        var first = wa.querySelector('.qb-wa__pdf'); if (first) first.focus({ preventScroll: true });
    }
    function closeWa() {
        if (wa.hidden) return;
        wa.hidden = true;
        if (waOpener && waOpener.focus) waOpener.focus({ preventScroll: true });
    }
    root.querySelector('[data-qb-wa]').addEventListener('click', openWa);
    wa.querySelector('[data-qb-wa-close]').addEventListener('click', closeWa);
    wa.addEventListener('click', function (e) { if (e.target === wa) closeWa(); });
    waPhone.addEventListener('input', function () { waErr.hidden = true; waPhone.removeAttribute('aria-invalid'); });
    wa.querySelector('[data-qb-wa-open]').addEventListener('click', function () {
        var n = waNumber(waPhone.value);
        if (n === null) {
            waErr.textContent = 'Start with the country code, for example 27 82 123 4567 or +44 7700 900123.';
            waErr.hidden = false; waPhone.setAttribute('aria-invalid', 'true'); waPhone.focus();
            return;
        }
        S.to.phone = waPhone.value.trim();
        save();
        var text = waMsg.value.trim();
        window.open('https://wa.me/' + n + (text ? '?text=' + encodeURIComponent(text) : ''), '_blank', 'noopener');
    });
    wa.querySelector('[data-qb-wa-copy]').addEventListener('click', function () {
        var text = waMsg.value;
        function copied() {
            waCopyLabel.textContent = 'Copied';
            clearTimeout(waCopyTimer); waCopyTimer = setTimeout(function () { waCopyLabel.textContent = 'Copy message'; }, 2000);
        }
        function fallback() { waMsg.focus(); waMsg.select(); try { if (document.execCommand('copy')) copied(); } catch (err) {} }
        if (navigator.clipboard && navigator.clipboard.writeText) navigator.clipboard.writeText(text).then(copied, fallback);
        else fallback();
    });

    // ── Fit: on desktop the builder fills the window below the headline, so the page needn't scroll ──
    var wide = window.matchMedia('(min-width: 861px)');
    function fit() {
        if (!wide.matches) { root.style.height = ''; return; }
        var top = root.getBoundingClientRect().top + window.scrollY;
        root.style.height = Math.max(440, window.innerHeight - top) + 'px';
    }
    var fitTimer;
    window.addEventListener('resize', function () { clearTimeout(fitTimer); fitTimer = setTimeout(fit, 80); });
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(fit);
    window.addEventListener('load', fit);

    setType(S.type);
    renderItems(); fillFields(); update(); setView('edit'); fit();
})();
</script>
@endpush
