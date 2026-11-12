<?php

/*
 * Vercel entry point (vercel-php runtime).
 *
 * Vercel's filesystem is read-only except /tmp, so Laravel's storage directory is moved
 * there (see bootstrap/app.php) and the folders it expects are created on each cold start.
 * Anything written to /tmp is temporary: uploads need cloud storage, not the local disk.
 */
foreach ([
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
] as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

require __DIR__.'/../public/index.php';
