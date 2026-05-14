<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\Quote;
use App\Models\Job;
use App\Models\Lead;
use App\Observers\InvoiceObserver;
use App\Observers\QuoteObserver;
use App\Observers\JobObserver;
use App\Observers\ContactFormObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Register the crm:: Blade component namespace
        Blade::componentNamespace('App\\View\\Components\\Crm', 'crm');
        // Anonymous components in resources/views/components/crm/
        // are accessible via <x-crm.xyz> but we also want <x-crm::xyz>
        // So we load them from the view directory using a custom path
        Blade::anonymousComponentNamespace('components.crm', 'crm');

        Invoice::observe(InvoiceObserver::class);
        Quote::observe(QuoteObserver::class);
        Job::observe(JobObserver::class);
        Lead::observe(ContactFormObserver::class);
    }
}
