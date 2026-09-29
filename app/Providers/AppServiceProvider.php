<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \Illuminate\Support\Facades\Event::listen(
            \SocialiteProviders\Manager\SocialiteWasCalled::class,
            [\SocialiteProviders\Azure\AzureExtendSocialite::class, 'handle']
        );

        // Support Livewire update requests (both with and without /V5 prefix)
        \Livewire\Livewire::setUpdateRoute(function ($handle) {
            \Illuminate\Support\Facades\Route::post('/V5/livewire/update', $handle)
                ->middleware(['web']);

            return \Illuminate\Support\Facades\Route::post('/livewire/update', $handle)
                ->middleware(['web']);
        });

        // Public links managed in "ตั้งค่าทั่วไป" (social links, satisfaction survey)
        \Illuminate\Support\Facades\View::composer(['layouts.public', 'public.pages.sitemap'], function ($view) {
            $view->with(Cache::remember('site_public_settings_v1', 600, function () {
                try {
                    return [
                        'socialFacebook' => \App\Models\Setting::get('social_facebook', 'https://www.facebook.com/MedSciUP'),
                        'socialYoutube'  => \App\Models\Setting::get('social_youtube', ''),
                        'surveyUrl'      => \App\Models\Setting::get('survey_url', ''),
                    ];
                } catch (\Throwable $e) {
                    return ['socialFacebook' => 'https://www.facebook.com/MedSciUP', 'socialYoutube' => '', 'surveyUrl' => ''];
                }
            }));
        });

        // Share navigation menus & visitor stats with the public layout
        \Illuminate\Support\Facades\View::composer('layouts.public', function ($view) {
            // Track unique visitor per day
            try {
                $ip = request()->ip();
                $today = now()->toDateString();
                if ($ip) {
                    \App\Models\VisitorLog::firstOrCreate([
                        'ip_address' => $ip,
                        'visit_date' => $today,
                    ], [
                        'user_agent' => substr(request()->userAgent() ?? '', 0, 250),
                    ]);
                }
            } catch (\Throwable $e) {
                // Ignore tracking error
            }

            // Cache visitor statistics for 5 minutes
            $stats = Cache::remember('visitor_counter_stats_v1', 300, function () {
                $baseOffsetTotal = 185420;
                $baseOffsetYear  = 38240;
                $baseOffsetMonth = 3450;
                $baseOffsetToday = 124;

                $todayCount = \App\Models\VisitorLog::whereDate('visit_date', today())->count();
                $monthCount = \App\Models\VisitorLog::whereYear('visit_date', now()->year)
                    ->whereMonth('visit_date', now()->month)->count();
                $yearCount  = \App\Models\VisitorLog::whereYear('visit_date', now()->year)->count();
                $totalCount = \App\Models\VisitorLog::count();

                return [
                    'visitorToday' => $todayCount + $baseOffsetToday,
                    'visitorMonth' => $monthCount + $baseOffsetMonth,
                    'visitorYear'  => $yearCount + $baseOffsetYear,
                    'visitorTotal' => $totalCount + $baseOffsetTotal,
                ];
            });

            $view->with($stats);

            $view->with(Cache::remember('nav_menus_v2', 3600, function () {
                return [
                    'headerMenu'    => \App\Models\MenuItem::where('location', 'header')->whereNull('parent_id')->where('active', true)->orderBy('order')->with('children.children')->get(),
                    'footerAbout'   => \App\Models\MenuItem::where('location', 'footer_about')->where('active', true)->orderBy('order')->get(),
                    'footerPrograms'=> \App\Models\MenuItem::where('location', 'footer_programs')->where('active', true)->orderBy('order')->get(),
                    'footerServices'=> \App\Models\MenuItem::where('location', 'footer_services')->where('active', true)->orderBy('order')->get(),
                ];
            }));
        });

        $assetUrl = config('app.asset_url', '');
        if ($assetUrl) {
            // Force URL generator to include the subdirectory base path
            \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url') . $assetUrl);

            \Livewire\Livewire::setScriptRoute(function ($handle) use ($assetUrl) {
                return \Illuminate\Support\Facades\Route::get('/livewire/livewire.min.js', $handle)->middleware([\App\Http\Middleware\GzipResponse::class]);
            });

            // All Livewire AJAX updates (wire:click, wire:submit, etc.) must POST
            // to the correct subdirectory path. forceRootUrl automatically prepends /V5.
            \Livewire\Livewire::setUpdateRoute(function ($handle) use ($assetUrl) {
                return \Illuminate\Support\Facades\Route::post('/livewire/update', $handle)->middleware('web');
            });
        }
    }
}
