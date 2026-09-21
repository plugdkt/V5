<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\News;
use App\Models\Event;
use App\Models\ServiceType;
use App\Models\ServiceStat;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slides = \App\Models\Slide::where('published', true)->orderBy('order_key', 'asc')->get();
        $banners = Banner::where('active', true)->orderBy('order')->get();
        
        $featuredNews = News::published()->where('category_id', '!=', 3)->latest('published_at')->first();

        
        $recentNews = News::published()
            ->where('category_id', '!=', 3)
            ->when($featuredNews, function($q) use ($featuredNews) {
                return $q->where('id', '!=', $featuredNews->id);
            })
            ->latest('published_at')
            ->limit(4)
            ->get();

        $upcomingEvents = Event::where('start_date', '>=', now()->startOfDay())
            ->with('category')
            ->orderBy('start_date')
            ->limit(3)
            ->get();

        $announcements = News::published()
            ->whereHas('category', function($q) {
                $q->where('slug', 'procurement');
            })
            ->latest('published_at')
            ->limit(4)
            ->get();

        // Calculate dynamic stats if possible, or fallback to settings
        $yearsOfExcellence = Setting::get('stat_years', 15);
        $staffCount = \App\Models\Personnel::where('status', true)->count() ?: Setting::get('stat_staff', 60);
        $alumniCount = Setting::get('stat_alumni', 1200);
        $researchCount = Setting::get('stat_research', 200);

        $programs = \App\Models\Program::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        return view('public.home', compact(
            'slides', 'banners', 'featuredNews', 'recentNews', 'upcomingEvents', 
            'announcements', 'yearsOfExcellence', 'staffCount', 'alumniCount', 'researchCount',
            'programs'
        ));
    }

}
