<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('crm:recurring-invoices')->dailyAt('06:00');
        $schedule->command('crm:overdue-invoices')->dailyAt('07:00');
        $schedule->command('crm:expire-quotes')->dailyAt('08:00');
    })
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo('/luminii/login');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
