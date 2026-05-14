<?php

namespace App\Http\Controllers;

class SitemapController extends Controller
{
    public function index()
    {
        $pages = [
            [
                'url' => url('/'),
                'lastmod' => now()->toIso8601String(),
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
            [
                'url' => url('/features'),
                'lastmod' => now()->toIso8601String(),
                'changefreq' => 'monthly',
                'priority' => '0.9',
            ],
            [
                'url' => url('/pricing'),
                'lastmod' => now()->toIso8601String(),
                'changefreq' => 'monthly',
                'priority' => '0.9',
            ],
            [
                'url' => url('/contact'),
                'lastmod' => now()->toIso8601String(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            [
                'url' => url('/solutions/business-operating-system-for-service-businesses'),
                'lastmod' => now()->toIso8601String(),
                'changefreq' => 'monthly',
                'priority' => '0.9',
            ],
            [
                'url' => url('/case-studies'),
                'lastmod' => now()->toIso8601String(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ],
            [
                'url' => url('/about'),
                'lastmod' => now()->toIso8601String(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ],
            [
                'url' => url('/security'),
                'lastmod' => now()->toIso8601String(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ],
            [
                'url' => url('/privacy-policy'),
                'lastmod' => now()->toIso8601String(),
                'changefreq' => 'yearly',
                'priority' => '0.3',
            ],
            [
                'url' => url('/terms'),
                'lastmod' => now()->toIso8601String(),
                'changefreq' => 'yearly',
                'priority' => '0.3',
            ],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
        $xml .= ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
        $xml .= ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9';
        $xml .= ' http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

        foreach ($pages as $page) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($page['url']) . '</loc>';
            $xml .= '<lastmod>' . $page['lastmod'] . '</lastmod>';
            $xml .= '<changefreq>' . $page['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $page['priority'] . '</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'text/xml');
    }
}
