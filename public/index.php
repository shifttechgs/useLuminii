<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Local dev: artisan lives one level above public/ → use that directory.
// cPanel:    public_html/ is the doc root; app lives at ../luminii_landingPage.
$appBase = is_file(dirname(__DIR__).'/artisan')
    ? dirname(__DIR__)
    : dirname(__DIR__).'/luminii_landingPage';

if (file_exists($maintenance = $appBase.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appBase.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $appBase.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
