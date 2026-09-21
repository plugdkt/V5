<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Program;

class SitemapController extends Controller
{
    /**
     * Display or generate sitemap.xml
     */
    public function index()
    {
        $xml = $this->generateXml();

        // Save physical sitemap.xml to public directory for direct static serving
        try {
            file_put_contents(public_path('sitemap.xml'), $xml);
        } catch (\Throwable $e) {
            // Ignore file write errors if permissions are restricted
        }

        return Response::make($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'X-Robots-Tag' => 'noindex, follow',
        ]);
    }

    /**
     * Generate valid XML Sitemap content compliant with sitemaps.org standard
     */
    public function generateXml()
    {
        $baseUrl = config('app.url', 'https://www.medsci.up.ac.th/V5');
        if (!str_contains($baseUrl, '/V5')) {
            $baseUrl = rtrim($baseUrl, '/') . '/V5';
        }
        $baseUrl = rtrim($baseUrl, '/');

        $urls = [];

        // 1. Core Static Pages
        $staticPages = [
            ['url' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => '/about', 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['url' => '/about/structure', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/about/management', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/about/vision', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/about/divisions', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/programs', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => '/admission', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/personnel', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/pages/academic-articles', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/pages/policies', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => '/pages/annual-report', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => '/downloads', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['url' => '/services', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => '/services/car-schedule', 'priority' => '0.7', 'changefreq' => 'daily'],
            ['url' => '/contact', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/contact/corruption-complaint', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $urls[] = [
                'loc' => $baseUrl . $page['url'],
                'lastmod' => date('Y-m-d'),
                'changefreq' => $page['changefreq'],
                'priority' => $page['priority'],
            ];
        }

        // 2. Dynamic Academic Programs (programs table)
        try {
            $programs = DB::table('programs')
                ->where('is_active', true)
                ->select('slug', 'updated_at')
                ->get();

            foreach ($programs as $prog) {
                $lastmod = !empty($prog->updated_at) ? date('Y-m-d', strtotime($prog->updated_at)) : date('Y-m-d');
                $urls[] = [
                    'loc' => $baseUrl . '/programs/' . $prog->slug,
                    'lastmod' => $lastmod,
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            }
        } catch (\Throwable $e) {
            // Fallback default programs
            $defaultSlugs = ['microbiology', 'biochemistry', 'nutrition'];
            foreach ($defaultSlugs as $slug) {
                $urls[] = [
                    'loc' => $baseUrl . '/programs/' . $slug,
                    'lastmod' => date('Y-m-d'),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            }
        }

        // 3. Dynamic CMS Pages (pages table)
        try {
            $pages = DB::table('pages')
                ->where('is_published', true)
                ->whereNotIn('slug', ['history', 'policies', 'annual-report'])
                ->select('slug', 'updated_at')
                ->get();

            foreach ($pages as $p) {
                $lastmod = !empty($p->updated_at) ? date('Y-m-d', strtotime($p->updated_at)) : date('Y-m-d');
                $urls[] = [
                    'loc' => $baseUrl . '/pages/' . $p->slug,
                    'lastmod' => $lastmod,
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }
        } catch (\Throwable $e) {
            // Ignore if table missing
        }

        // Generate XML string
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>" . $url['lastmod'] . "</lastmod>\n";
            $xml .= "    <changefreq>" . $url['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $url['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
