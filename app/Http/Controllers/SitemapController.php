<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    /**
     * Public pages, each with the view files that make it up. lastmod is taken from
     * when those files last changed (not "now" on every request, which search
     * engines learn to ignore).
     */
    private const PAGES = [
        ['path' => '/',               'views' => ['welcome', 'components/*', 'components/partials/*'], 'changefreq' => 'weekly',  'priority' => '1.0'],
        ['path' => '/personal',       'views' => ['welcome', 'components/personal/*'],                 'changefreq' => 'weekly',  'priority' => '0.9'],
        ['path' => '/pricing',        'views' => ['pricing', 'components/business-pricing'],           'changefreq' => 'monthly', 'priority' => '0.9'],
        ['path' => '/features',       'views' => ['features'],                                         'changefreq' => 'monthly', 'priority' => '0.9'],
        ['path' => '/solutions/business-operating-system-for-service-businesses',
                                      'views' => ['solutions/business-operating-system-for-service-businesses'], 'changefreq' => 'monthly', 'priority' => '0.9'],
        ['path' => '/contact',        'views' => ['contact'],                                          'changefreq' => 'monthly', 'priority' => '0.8'],
        ['path' => '/case-studies',   'views' => ['case-studies'],                                     'changefreq' => 'monthly', 'priority' => '0.7'],
        ['path' => '/about',          'views' => ['about'],                                            'changefreq' => 'monthly', 'priority' => '0.6'],
        ['path' => '/security',       'views' => ['security'],                                         'changefreq' => 'monthly', 'priority' => '0.6'],
        ['path' => '/privacy-policy', 'views' => ['privacy-policy'],                                   'changefreq' => 'yearly',  'priority' => '0.3'],
        ['path' => '/terms',          'views' => ['terms'],                                            'changefreq' => 'yearly',  'priority' => '0.3'],
    ];

    public function index()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach (self::PAGES as $page) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars(url($page['path'])) . '</loc>';
            $xml .= '<lastmod>' . $this->lastModified($page['views']) . '</lastmod>';
            $xml .= '<changefreq>' . $page['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $page['priority'] . '</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /** Latest modification time of the given view files/globs, as a W3C date. */
    private function lastModified(array $views): string
    {
        $latest = 0;
        foreach ($views as $view) {
            foreach (glob(resource_path('views/' . $view . '.blade.php')) ?: [] as $file) {
                $latest = max($latest, (int) filemtime($file));
            }
        }

        return Carbon::createFromTimestamp($latest ?: filemtime(resource_path('views')))->toAtomString();
    }
}
