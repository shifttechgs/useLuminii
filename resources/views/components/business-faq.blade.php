<section class="lp-questions" id="faq" aria-labelledby="questions-heading">
    <div class="lp-wrap lp-questions__layout">
        <header class="lp-questions__intro">
            <div class="lp-section__label">FAQ</div>
            <h2 id="questions-heading">A few things<br><em>you might be wondering.</em></h2>
            <p>From your first demo to getting the team set up. If your question isn't here, we can talk it through.</p>
            <a href="{{ url('/') }}#booking">Ask us in a demo <i class="ph ph-arrow-up-right" aria-hidden="true"></i></a>
        </header>

        <div class="lp-questions__list">
            @foreach($faqs as $faq)
                <details class="lp-questions__item" name="business-questions"{{ $loop->first ? ' open' : '' }}>
                    <summary><span class="lp-questions__number" aria-hidden="true">/ 0{{ $loop->iteration }}</span><span>{{ $faq['q'] }}</span><span class="lp-questions__symbol" aria-hidden="true"></span></summary>
                    <div class="lp-questions__answer"><p>{{ $faq['a'] }}</p></div>
                </details>
            @endforeach
        </div>
    </div>
</section>
