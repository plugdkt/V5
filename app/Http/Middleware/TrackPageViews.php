<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackPageViews
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // ponytail: lightweight daily pageviews tracking. Skips bots, admin, ajax, and auth users.
        if ($this->shouldTrack($request, $response)) {
            $this->recordPageView($request);
        }

        return $response;
    }

    /**
     * Determine if request should be tracked
     */
    protected function shouldTrack(Request $request, Response $response): bool
    {
        if ($request->method() !== 'GET') {
            return false;
        }

        // Only track successful HTML responses
        $status = $response->getStatusCode();
        if ($status < 200 || $status >= 400) {
            return false;
        }

        if ($request->ajax() || $request->prefetch() || $request->isJson()) {
            return false;
        }

        // Skip admin, livewire, auth, asset, api paths
        if ($request->is('admin*', '*/admin*', 'livewire*', '*/livewire*', 'api*', 'login*', 'logout*', 'auth*', 'up', '_debugbar*')) {
            return false;
        }

        // Skip static file extensions
        $path = $request->path();
        if (preg_match('/\.(css|js|jpg|jpeg|png|gif|svg|webp|ico|pdf|doc|docx|xls|xlsx|zip|rar)$/i', $path)) {
            return false;
        }

        // Skip logged in staff/admin to keep metrics pure
        if (Auth::check()) {
            return false;
        }

        // Skip common crawlers / bots
        $userAgent = strtolower($request->userAgent() ?? '');
        $botPatterns = [
            'bot', 'crawl', 'spider', 'slurp', 'mediapartners', 'facebookexternalhit',
            'curl', 'wget', 'python', 'postman', 'httpclient', 'headlesschrome'
        ];
        foreach ($botPatterns as $bot) {
            if (str_contains($userAgent, $bot)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Record or increment page view count for today
     */
    protected function recordPageView(Request $request): void
    {
        try {
            $rawPath = trim($request->path(), '/');
            $path = $rawPath === '' ? '/' : '/' . $rawPath;
            $title = $this->resolvePageTitle($path);
            $today = now()->toDateString();
            $device = $this->detectDevice($request->userAgent());

            $isDesktop = $device === 'desktop' ? 1 : 0;
            $isMobile = $device === 'mobile' ? 1 : 0;
            $isTablet = $device === 'tablet' ? 1 : 0;

            // Track time of day (Morning: 6-12, Afternoon: 12-17, Evening: 17-21, Night: 21-6)
            $hour = (int) now()->format('H');
            $isMorning = ($hour >= 6 && $hour < 12) ? 1 : 0;
            $isAfternoon = ($hour >= 12 && $hour < 17) ? 1 : 0;
            $isEvening = ($hour >= 17 && $hour < 21) ? 1 : 0;
            $isNight = ($hour >= 21 || $hour < 6) ? 1 : 0;

            DB::table('page_views')->upsert(
                [
                    'view_date' => $today,
                    'path' => $path,
                    'page_title' => $title,
                    'views_count' => 1,
                    'views_desktop' => $isDesktop,
                    'views_mobile' => $isMobile,
                    'views_tablet' => $isTablet,
                    'views_morning' => $isMorning,
                    'views_afternoon' => $isAfternoon,
                    'views_evening' => $isEvening,
                    'views_night' => $isNight,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                ['view_date', 'path'],
                [
                    'views_count' => DB::raw('page_views.views_count + 1'),
                    'views_desktop' => DB::raw("page_views.views_desktop + {$isDesktop}"),
                    'views_mobile' => DB::raw("page_views.views_mobile + {$isMobile}"),
                    'views_tablet' => DB::raw("page_views.views_tablet + {$isTablet}"),
                    'views_morning' => DB::raw("page_views.views_morning + {$isMorning}"),
                    'views_afternoon' => DB::raw("page_views.views_afternoon + {$isAfternoon}"),
                    'views_evening' => DB::raw("page_views.views_evening + {$isEvening}"),
                    'views_night' => DB::raw("page_views.views_night + {$isNight}"),
                    'page_title' => $title,
                    'updated_at' => now(),
                ]
            );
        } catch (\Throwable $e) {
            // Silently ignore to prevent user-facing errors
        }
    }

    /**
     * Detect device type: 'tablet', 'mobile', or 'desktop'
     */
    protected function detectDevice(?string $userAgent): string
    {
        $ua = strtolower($userAgent ?? '');

        // Check tablet first
        if (preg_match('/(ipad|tablet|(android(?!.*mobile))|(windows(?!.*phone)(.*touch))|kindle|playbook|silk)/i', $ua)) {
            return 'tablet';
        }

        // Check mobile
        if (preg_match('/(mobile|iphone|ipod|android|blackberry|opera mini|iemobile|wpdesktop)/i', $ua)) {
            return 'mobile';
        }

        return 'desktop';
    }

    /**
     * Map known routes/paths to human-readable Thai titles
     */
    protected function resolvePageTitle(string $path): string
    {
        static $knownTitles = [
            '/' => 'หน้าแรก (Home)',
            '/about' => 'เกี่ยวกับคณะ',
            '/about/structure' => 'โครงสร้างองค์กร',
            '/about/management' => 'คณะผู้บริหาร',
            '/about/vision' => 'ปรัชญา ปณิธาน วิสัยทัศน์',
            '/about/divisions' => 'หน่วยงานภายใน',
            '/pages/policies' => 'แผน / นโยบาย / มาตรการ',
            '/pages/annual-report' => 'รายงานผลการดำเนินงาน',
            '/pages/academic-articles' => 'บทความวิชาการ',
            '/programs' => 'หลักสูตรการศึกษาทั้งหมด',
            '/programs/microbiology' => 'หลักสูตร วท.บ. จุลชีววิทยา',
            '/programs/biochemistry' => 'หลักสูตร วท.บ. ชีวเคมี',
            '/programs/nutrition' => 'หลักสูตร วท.บ. โภชนาการและการกำหนดอาหาร',
            '/admission' => 'การรับสมัครเข้าศึกษา (Admission)',
            '/research' => 'งานวิจัยและนวัตกรรม',
            '/services' => 'บริการวิชาการ',
            '/services/car-schedule' => 'ตารางการใช้ยานพาหนะ',
            '/calendar' => 'ปฏิทินกิจกรรม',
            '/contact' => 'ติดต่อเรา',
            '/contact/corruption-complaint' => 'ศูนย์รับเรื่องร้องเรียนการทุจริต',
            '/contact/office-schedule' => 'ตารางการใช้ห้องสำนักงาน',
            '/downloads' => 'คลังไฟล์ดาวน์โหลด',
            '/personnel' => 'ทำเนียบบุคลากร',
            '/intranet' => 'ระบบอินทราเน็ต',
        ];

        if (isset($knownTitles[$path])) {
            return $knownTitles[$path];
        }

        // Check dynamic program slug
        if (str_starts_with($path, '/programs/')) {
            $slug = substr($path, strlen('/programs/'));
            $progTitle = DB::table('programs')->where('slug', $slug)->value('title_th');
            if ($progTitle) {
                return $progTitle;
            }
        }

        // Check dynamic CMS page slug
        if (str_starts_with($path, '/pages/')) {
            $slug = substr($path, strlen('/pages/'));
            $pageTitle = DB::table('pages')->where('slug', $slug)->value('title_th');
            if ($pageTitle) {
                return $pageTitle;
            }
        }

        return $path;
    }
}
