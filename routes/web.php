<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClientHubController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Crm\BusinessServiceController;
use App\Http\Controllers\Crm\CalendarController;
use App\Http\Controllers\Crm\ClientController;
use App\Http\Controllers\Crm\DashboardController;
use App\Http\Controllers\Crm\ExpenseController;
use App\Http\Controllers\Crm\InvoiceController;
use App\Http\Controllers\Crm\JobController;
use App\Http\Controllers\Crm\LeadsController;
use App\Http\Controllers\Crm\NotificationsController;
use App\Http\Controllers\Crm\PipelineController;
use App\Http\Controllers\Crm\QuoteController;
use App\Http\Controllers\Crm\RecurringInvoiceController;
use App\Http\Controllers\Crm\ReportsController;
use App\Http\Controllers\Crm\RequestController;
use App\Http\Controllers\Crm\SettingsController;
use App\Http\Controllers\Crm\TeamController;
use App\Http\Controllers\Crm\UserController;
use App\Http\Controllers\InvoicePdfController;
use App\Http\Controllers\QuotePdfController;
use App\Http\Controllers\SitemapController;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/features', fn () => view('features'))->name('features');
Route::get('/pricing', fn () => view('pricing'))->name('pricing');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.page');
Route::get('/solutions/business-operating-system-for-service-businesses', fn () => view('solutions.business-operating-system-for-service-businesses'))
    ->name('solutions.business-operating-system');
Route::get('/case-studies', fn () => view('case-studies'))->name('case-studies');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/security', fn () => view('security'))->name('security');
Route::get('/privacy-policy', fn () => view('privacy-policy'))->name('privacy-policy');
Route::get('/terms', fn () => view('terms'))->name('terms');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');
Route::post('/book-demo', [ContactController::class, 'bookDemo'])->name('demo.submit');

Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

if (app()->environment('local')) {
    Route::get('reboot', function () {
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('key:generate');

        dd('system rebooted!');
    });

    Route::get('/migrate', function () {
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('db:seed', [
            '--class' => DatabaseSeeder::class,
            '--force' => true,
        ]);

        return 'Migrations and DatabaseSeeder completed.';
    });
}

// Client hub (public, token-based, no login required)
Route::prefix('client-hub')->name('client-hub.')->group(function () {
    Route::get('/quote/{token}', [ClientHubController::class, 'viewQuote'])->name('quote');
    Route::post('/quote/{token}/accept', [ClientHubController::class, 'acceptQuote'])->name('quote.accept');
    Route::post('/quote/{token}/decline', [ClientHubController::class, 'declineQuote'])->name('quote.decline');
    Route::post('/quote/{token}/comment', [ClientHubController::class, 'postComment'])->name('quote.comment');
    Route::get('/invoice/{token}', [ClientHubController::class, 'viewInvoice'])->name('invoice');
    Route::get('/invoice/{token}/pay', [ClientHubController::class, 'paypalCheckout'])->name('payment.checkout');
    Route::get('/invoice/{token}/success', [ClientHubController::class, 'paypalSuccess'])->name('payment.success');
});

// PayPal webhook (exclude CSRF)
Route::post('/webhooks/paypal', [ClientHubController::class, 'paypalWebhook'])
    ->name('paypal.webhook')
    ->withoutMiddleware([VerifyCsrfToken::class]);

// Invoice / Quote PDF downloads (CRM users)
Route::get('/luminii/pdf/invoice/{invoiceId}', [InvoicePdfController::class, 'download'])
    ->middleware(['auth'])
    ->name('invoice.pdf');

Route::get('/luminii/pdf/quote/{quoteId}', [QuotePdfController::class, 'download'])
    ->middleware(['auth'])
    ->name('quote.pdf');

Route::get('/luminii/pdf/quote/{quoteId}/preview', [QuotePdfController::class, 'preview'])
    ->middleware(['auth'])
    ->name('quote.pdf.preview');

// Luminii CRM
Route::prefix('luminii')->name('crm.')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('clients', ClientController::class)->names('clients');

    Route::resource('requests', RequestController::class)
        ->names('requests')
        ->parameters(['requests' => 'clientRequest']);
    Route::post('requests/{clientRequest}/convert', [RequestController::class, 'convertToQuote'])->name('requests.convert');

    Route::get('leads', [LeadsController::class, 'index'])->name('leads.index');
    Route::get('leads/create', [LeadsController::class, 'create'])->name('leads.create');
    Route::post('leads', [LeadsController::class, 'store'])->name('leads.store');
    Route::get('leads/{lead}', [LeadsController::class, 'show'])->name('leads.show');
    Route::post('leads/{lead}/convert', [LeadsController::class, 'convert'])->name('leads.convert');
    Route::delete('leads/{lead}', [LeadsController::class, 'destroy'])->name('leads.destroy');

    Route::get('pipeline', [PipelineController::class, 'index'])->name('pipeline');
    Route::post('pipeline/{clientRequest}/move', [PipelineController::class, 'move'])->name('pipeline.move');

    Route::get('quotes/ajax/client-requests', [QuoteController::class, 'clientRequests'])->name('quotes.ajax.requests');
    Route::get('quotes/ajax/services', [QuoteController::class, 'services'])->name('quotes.ajax.services');
    Route::resource('quotes', QuoteController::class)->names('quotes');
    Route::post('quotes/{quote}/send', [QuoteController::class, 'send'])->name('quotes.send');
    Route::post('quotes/{quote}/convert-to-job', [QuoteController::class, 'convertToJob'])->name('quotes.convert-to-job');

    Route::get('jobs/ajax/client-requests', [JobController::class, 'clientRequests'])->name('jobs.ajax.requests');
    Route::get('jobs/ajax/services', [JobController::class, 'servicesCatalogue'])->name('jobs.ajax.services');
    Route::resource('jobs', JobController::class)->names('jobs');
    Route::post('jobs/{job}/create-invoice', [JobController::class, 'createInvoice'])->name('jobs.create-invoice');
    Route::post('jobs/{job}/status', [JobController::class, 'updateStatus'])->name('jobs.status');

    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::post('calendar/schedule', [CalendarController::class, 'schedule'])->name('calendar.schedule');
    Route::get('calendar/events', [CalendarController::class, 'events'])->name('calendar.events');

    Route::resource('invoices', InvoiceController::class)->names('invoices');
    Route::post('invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send');
    Route::post('invoices/{invoice}/payment', [InvoiceController::class, 'recordPayment'])->name('invoices.payment');

    Route::resource('expenses', ExpenseController::class)->names('expenses');

    Route::resource('recurring', RecurringInvoiceController::class)->names('recurring');

    Route::get('reports', [ReportsController::class, 'index'])->name('reports');

    Route::get('notifications', [NotificationsController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{notification}/read', [NotificationsController::class, 'markRead'])->name('notifications.read');
    Route::post('notifications/read-all', [NotificationsController::class, 'readAll'])->name('notifications.read-all');

    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::resource('services', BusinessServiceController::class)->names('services');

    Route::resource('team', TeamController::class)->names('team');
    Route::post('team/{teamMember}/invite', [TeamController::class, 'resendInvite'])->name('team.invite');

    Route::resource('users', UserController::class)->names('users');
});

// CRM authentication
Route::get('/luminii/login', [LoginController::class, 'showLoginForm'])->name('crm.login');
Route::post('/luminii/login', [LoginController::class, 'login'])->name('crm.login.post');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('crm.login');
})->name('logout');
