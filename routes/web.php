<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.page');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');
Route::post('/book-demo', [ContactController::class, 'bookDemo'])->name('demo.submit');

// Sitemap XML
Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('reboot', function(){
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('key:generate');
    dd('system rebooted!');
});
