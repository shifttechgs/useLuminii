<script>
(function () {
    var btns = document.querySelectorAll('.lp-pricing__toggle-btn');
    var vals = document.querySelectorAll('.lp-pcard__price-val');
    var saves = document.querySelectorAll('.lp-pcard__annual-save');
    var metaMo = document.querySelectorAll('.lp-pcard__meta--monthly');
    var metaAn = document.querySelectorAll('.lp-pcard__meta--annual');

    btns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var billing = this.dataset.billing;
            var isAnnual = billing === 'annual';

            btns.forEach(function (b) { b.classList.remove('lp-pricing__toggle-btn--active'); });
            this.classList.add('lp-pricing__toggle-btn--active');

            vals.forEach(function (el) {
                el.textContent = isAnnual ? el.dataset.annual : el.dataset.monthly;
            });

            saves.forEach(function (el) {
                el.style.display = isAnnual ? 'block' : 'none';
            });

            metaMo.forEach(function (el) { el.style.display = isAnnual ? 'none' : 'block'; });
            metaAn.forEach(function (el) { el.style.display = isAnnual ? 'block' : 'none'; });
        });
    });
}());
</script>
