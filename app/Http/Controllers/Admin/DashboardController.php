<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use App\Models\PolicyDocument;
use App\Models\ReportDocument;
use App\Models\DownloadableFile;
use App\Models\Slide;
use App\Models\Program;
use App\Models\AcademicArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Visitors & Page Views Stats
        $todayStr = now()->toDateString();
        $todayViews = (int) PageView::where('view_date', $todayStr)->sum('views_count');
        $weekViews = (int) PageView::where('view_date', '>=', now()->subDays(6)->toDateString())->sum('views_count');
        $monthViews = (int) PageView::where('view_date', '>=', now()->subDays(29)->toDateString())->sum('views_count');
        $totalAllViews = (int) PageView::sum('views_count');

        // 2. Daily Trend for Chart (Last 14 days)
        $chartDays = [];
        $chartViews = [];
        $chartDesktopViews = [];
        $chartMobileViews = [];

        $fourteenDaysAgo = now()->subDays(13)->toDateString();
        $dailyRecords = PageView::where('view_date', '>=', $fourteenDaysAgo)
            ->groupBy('view_date')
            ->selectRaw('view_date, SUM(views_count) as total_views, SUM(views_desktop) as desktop_views, SUM(views_mobile) as mobile_views')
            ->get()
            ->keyBy(function ($item) {
                return is_string($item->view_date) ? $item->view_date : $item->view_date->toDateString();
            });

        for ($i = 13; $i >= 0; $i--) {
            $d = now()->subDays($i);
            $dStr = $d->toDateString();
            $dLabel = $d->locale('th')->translatedFormat('j M');
            
            $rec = $dailyRecords->get($dStr);
            $chartDays[] = $dLabel;
            $chartViews[] = $rec ? (int) $rec->total_views : 0;
            $chartDesktopViews[] = $rec ? (int) $rec->desktop_views : 0;
            $chartMobileViews[] = $rec ? (int) $rec->mobile_views : 0;
        }

        // 3. Top 10 Most Visited Pages (Exclude Homepage '/' and empty path)
        $range = $request->query('range', '30'); // '7', '30', or 'all'
        $topPagesQuery = PageView::select(
            'path',
            'page_title',
            DB::raw('SUM(views_count) as total_views')
        )->whereNotIn('path', ['/', '']);

        if ($range === '7') {
            $topPagesQuery->where('view_date', '>=', now()->subDays(6)->toDateString());
        } elseif ($range === '30') {
            $topPagesQuery->where('view_date', '>=', now()->subDays(29)->toDateString());
        }

        $topPages = $topPagesQuery->groupBy('path', 'page_title')
            ->orderByDesc('total_views')
            ->limit(10)
            ->get();

        $maxViews = $topPages->max('total_views') ?: 1;

        // ponytail: Calculate previous rank to detect rank changes (up/down/same/new)
        $prevQuery = PageView::select('path', DB::raw('SUM(views_count) as prev_views'))
            ->whereNotIn('path', ['/', '']);

        if ($range === '7') {
            $hasPriorWeek = PageView::whereBetween('view_date', [
                now()->subDays(13)->toDateString(),
                now()->subDays(7)->toDateString()
            ])->whereNotIn('path', ['/', ''])->exists();

            if ($hasPriorWeek) {
                $prevQuery->whereBetween('view_date', [
                    now()->subDays(13)->toDateString(),
                    now()->subDays(7)->toDateString()
                ]);
            } else {
                $prevQuery->where('view_date', '<', now()->subDays(2)->toDateString());
            }
        } elseif ($range === '30') {
            $hasPriorMonth = PageView::whereBetween('view_date', [
                now()->subDays(59)->toDateString(),
                now()->subDays(30)->toDateString()
            ])->whereNotIn('path', ['/', ''])->exists();

            if ($hasPriorMonth) {
                $prevQuery->whereBetween('view_date', [
                    now()->subDays(59)->toDateString(),
                    now()->subDays(30)->toDateString()
                ]);
            } else {
                $prevQuery->where('view_date', '<', now()->subDays(2)->toDateString());
            }
        } else {
            $prevQuery->where('view_date', '<', now()->subDays(6)->toDateString());
        }

        $prevRanks = $prevQuery->groupBy('path')
            ->orderByDesc('prev_views')
            ->pluck('path')
            ->flip();

        foreach ($topPages as $index => $page) {
            $currentRank = $index + 1;
            if (isset($prevRanks[$page->path])) {
                $prevRank = $prevRanks[$page->path] + 1;
                $page->prev_rank = $prevRank;
                $page->rank_change = $prevRank - $currentRank; // >0 is UP, <0 is DOWN, 0 is UNCHANGED
            } else {
                $page->prev_rank = null;
                $page->rank_change = 'new';
            }
        }

        // 4. Top Downloaded Files
        $topDownloads = DownloadableFile::with('category')
            ->where('active', true)
            ->orderByDesc('download_count')
            ->limit(5)
            ->get();

        // 5. CMS Content Summary
        $policiesCount = PolicyDocument::count();
        $reportsCount = ReportDocument::count();
        $activeSlidesCount = Slide::where('published', true)->count();
        $downloadsCount = DownloadableFile::where('active', true)->count();
        $programsCount = Program::where('is_active', true)->count();
        $articlesCount = AcademicArticle::count();

        // 6. Device Share Stats (Overall / Mobile vs Desktop vs Tablet)
        $desktopViews = (int) PageView::sum('views_desktop');
        $mobileViews = (int) PageView::sum('views_mobile');
        $tabletViews = (int) PageView::sum('views_tablet');
        $deviceTotal = $desktopViews + $mobileViews + $tabletViews;

        $desktopPercent = $deviceTotal > 0 ? round(($desktopViews / $deviceTotal) * 100) : 0;
        $mobilePercent = $deviceTotal > 0 ? round(($mobileViews / $deviceTotal) * 100) : 0;
        $tabletPercent = $deviceTotal > 0 ? max(0, 100 - $desktopPercent - $mobilePercent) : 0;

        // 7. System Health & Document Integrity Check
        $policyMissingFiles = PolicyDocument::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('file_path')->orWhere('file_path', '');
            })
            ->count();

        $reportMissingFiles = ReportDocument::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('file_path')->orWhere('file_path', '');
            })
            ->count();

        $healthIssues = [];
        if ($policyMissingFiles > 0) {
            $healthIssues[] = [
                'type' => 'warning',
                'title' => "มีแผน/นโยบาย {$policyMissingFiles} ฉบับที่ยังไม่ได้แนบไฟล์เอกสาร",
                'url' => route('admin.policies.index'),
            ];
        }
        if ($reportMissingFiles > 0) {
            $healthIssues[] = [
                'type' => 'warning',
                'title' => "มีรายงานผล {$reportMissingFiles} ฉบับที่ยังไม่ได้แนบไฟล์เอกสาร",
                'url' => route('admin.reports.index'),
            ];
        }
        if ($activeSlidesCount < 1) {
            $healthIssues[] = [
                'type' => 'warning',
                'title' => 'ไม่มีภาพสไลด์หน้าแรกที่เผยแพร่อยู่',
                'url' => route('admin.slides.index'),
            ];
        }

        // 8. Storage Usage (Cached for 6 hours)
        $storageSizeMB = \Illuminate\Support\Facades\Cache::remember('medsci_storage_size_mb', 21600, function () {
            $bytes = 0;
            $path = storage_path('app/public');
            if (file_exists($path)) {
                foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)) as $file) {
                    $bytes += $file->getSize();
                }
            }
            return round($bytes / 1048576, 1);
        });

        // 9. Peak Hours / Time of Day
        $viewsMorning = (int) PageView::sum('views_morning');
        $viewsAfternoon = (int) PageView::sum('views_afternoon');
        $viewsEvening = (int) PageView::sum('views_evening');
        $viewsNight = (int) PageView::sum('views_night');
        $timeTotal = $viewsMorning + $viewsAfternoon + $viewsEvening + $viewsNight;

        $morningPercent = $timeTotal > 0 ? round(($viewsMorning / $timeTotal) * 100) : 0;
        $afternoonPercent = $timeTotal > 0 ? round(($viewsAfternoon / $timeTotal) * 100) : 0;
        $eveningPercent = $timeTotal > 0 ? round(($viewsEvening / $timeTotal) * 100) : 0;
        $nightPercent = $timeTotal > 0 ? max(0, 100 - $morningPercent - $afternoonPercent - $eveningPercent) : 0;

        $peakPeriod = 'ช่วงเช้า (06:00 - 12:00 น.)';
        $maxTimeVal = $viewsMorning;
        if ($viewsAfternoon > $maxTimeVal) {
            $peakPeriod = 'ช่วงบ่าย (12:00 - 17:00 น.)';
            $maxTimeVal = $viewsAfternoon;
        }
        if ($viewsEvening > $maxTimeVal) {
            $peakPeriod = 'ช่วงเย็น (17:00 - 21:00 น.)';
            $maxTimeVal = $viewsEvening;
        }
        if ($viewsNight > $maxTimeVal) {
            $peakPeriod = 'ช่วงค่ำ/ดึก (21:00 - 06:00 น.)';
            $maxTimeVal = $viewsNight;
        }

        // 10. Recent Policy & Report Updates (latest 3 each)
        $recentPolicies = PolicyDocument::with('category')->latest('updated_at')->limit(3)->get();
        $recentReports = ReportDocument::with('category')->latest('updated_at')->limit(3)->get();

        return view('admin.dashboard', compact(
            'todayViews', 'weekViews', 'monthViews', 'totalAllViews',
            'chartDays', 'chartViews', 'chartDesktopViews', 'chartMobileViews',
            'topPages', 'maxViews', 'range',
            'desktopViews', 'mobileViews', 'tabletViews', 'deviceTotal',
            'desktopPercent', 'mobilePercent', 'tabletPercent',
            'healthIssues', 'policyMissingFiles', 'reportMissingFiles', 'storageSizeMB',
            'viewsMorning', 'viewsAfternoon', 'viewsEvening', 'viewsNight', 'timeTotal',
            'morningPercent', 'afternoonPercent', 'eveningPercent', 'nightPercent', 'peakPeriod',
            'topDownloads',
            'policiesCount', 'reportsCount', 'activeSlidesCount', 'downloadsCount', 'programsCount', 'articlesCount',
            'recentPolicies', 'recentReports'
        ));
    }
}
