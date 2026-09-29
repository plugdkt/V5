<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NewsController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\DownloadController;

// ── Language Switcher Route ──
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['th', 'en'], true)) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// ── Public Site Routes ──
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/about/structure', [PageController::class, 'structure'])->name('about.structure');
Route::get('/about/management', [PageController::class, 'management'])->name('about.management');
Route::get('/about/vision', [PageController::class, 'vision'])->name('about.vision');
Route::get('/about/divisions', [PageController::class, 'divisions'])->name('about.divisions');
Route::get('/pages/policies', [PageController::class, 'policies'])->name('pages.policies');
Route::get('/pages/annual-report', [PageController::class, 'reports'])->name('pages.reports');
Route::get('/pages/academic-articles', [PageController::class, 'academicArticles'])->name('pages.academic-articles');
Route::get('/pages/{slug}', [PageController::class, 'showDynamicPage'])->name('pages.show');

Route::get('/programs', [PageController::class, 'programs'])->name('programs');
Route::get('/programs/{slug}', [PageController::class, 'programDetail'])->name('programs.detail');
Route::get('/admission', [PageController::class, 'admission'])->name('public.admission');

Route::get('/research', [PageController::class, 'research'])->name('research');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/services/car-schedule', [PageController::class, 'carSchedule'])->name('services.car-schedule');
Route::get('/calendar', [PageController::class, 'calendar'])->name('calendar.index');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/contact/corruption-complaint', [PageController::class, 'corruptionComplaint'])->name('contact.corruption');
Route::get('/contact/office-schedule', [PageController::class, 'officeSchedule'])->name('contact.office-schedule');
Route::get('/intranet', [PageController::class, 'intranet'])->name('intranet');
Route::get('/sitemap.xml', [\App\Http\Controllers\Public\SitemapController::class, 'index'])->name('sitemap');
// Government Website Standard v3.0: HTML sitemap, site search, RSS
Route::get('/sitemap', [\App\Http\Controllers\Public\SiteController::class, 'sitemap'])->name('sitemap.page');
Route::get('/search', [\App\Http\Controllers\Public\SiteController::class, 'search'])->name('search');
Route::get('/rss.xml', [\App\Http\Controllers\Public\SiteController::class, 'rss'])->name('rss');

// News Articles (MSC News system, embedded on the home page)
Route::redirect('/news', 'https://www.medsci.up.ac.th/msc_news/index.php')->name('news.index');


// Personnel Directory
Route::get('/personnel', function () {
    return view('public.pages.personnel');
})->name('personnel.index');

Route::get('/booking/rooms', function () {
    return redirect()->away('https://www.medsci.up.ac.th/msc_acc/sso/login.php?client_id=mtr_booking&redirect_uri=https%3A%2F%2Fwww.medsci.up.ac.th%2Fmtr_booking%2Fsso_callback.php');
})->name('booking.rooms');

// File Downloads
Route::get('/downloads', function () {
    return view('public.pages.downloads');
})->name('downloads.index');
Route::get('/downloads/file/{id}', [DownloadController::class, 'download'])->name('downloads.file');

// ── Authentication & SSO ──
Route::get('/login', [\App\Http\Controllers\Auth\SsoController::class, 'redirect'])->name('login');
Route::get('/auth/sso', [\App\Http\Controllers\Auth\SsoController::class, 'redirect'])->name('auth.sso');
Route::get('/auth/callback', [\App\Http\Controllers\Auth\SsoController::class, 'callback'])->name('auth.callback');
Route::get('/public/auth/callback', [\App\Http\Controllers\Auth\SsoController::class, 'callback']);
Route::post('/logout', [\App\Http\Controllers\Auth\SsoController::class, 'logout'])->name('logout');

// ── CMS Backend (protected by Auth and EnsureUserIsEditor middleware) ──
Route::middleware(['auth', 'editor'])->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // CMS News
    Route::get('/news', function() {
        return view('admin.news.index');
    })->name('admin.news.index');

    // CMS Academic Articles
    Route::get('/academic-articles', function() {
        return view('admin.academic-articles.index');
    })->name('admin.academic-articles.index');

    // CMS Events
    Route::get('/events', function() {
        return view('admin.events.index');
    })->name('admin.events.index');

    // CMS Downloads
    Route::get('/downloads', function() {
        return view('admin.downloads.index');
    })->name('admin.downloads.index');

    // CMS Personnel
    Route::get('/personnel', function() {
        return view('admin.personnel.index');
    })->name('admin.personnel.index');

    // CMS Room Bookings
    Route::get('/bookings', function() {
        return view('admin.bookings.index');
    })->name('admin.bookings.index');

    // CMS Service Stats
    Route::get('/stats', function() {
        return view('admin.stats.index');
    })->name('admin.stats.index');

    // CMS Assets
    Route::get('/assets', function() {
        return view('admin.assets.index');
    })->name('admin.assets.index');

    // CMS Settings
    Route::get('/settings', function() {
        return view('admin.settings.index');
    })->name('admin.settings.index');

    // CMS Dynamic Pages
    Route::get('/pages', function() {
        return view('admin.pages.index');
    })->name('admin.pages.index');

    // CMS Slideshow
    Route::get('/slides', function() {
        return view('admin.slides.index');
    })->name('admin.slides.index');

    // CMS Banners
    Route::get('/banners', function() {
        return view('admin.banners.index');
    })->name('admin.banners.index');


    // CMS Navigation Menus
    Route::get('/menus', function() {
        return view('admin.menus.index');
    })->name('admin.menus.index');

    // CMS Executives
    Route::get('/executives', function() {
        return view('admin.executives.index');
    })->name('admin.executives.index');


    // CMS Programs
    Route::get('/programs', function() {
        return view('admin.programs.index');
    })->name('admin.programs.index');

    // CMS E-Services
    Route::get('/e-services', function() {
        return view('admin.e-services.index');
    })->name('admin.e-services.index');

    // CMS Policies
    Route::get('/policies', function() {
        return view('admin.policies.index');
    })->name('admin.policies.index');

    // CMS Operation Reports
    Route::get('/reports', function() {
        return view('admin.reports.index');
    })->name('admin.reports.index');

    // CMS Media Manager
    Route::get('/media', function() {
        return view('admin.media.index');
    })->name('admin.media.index');

    // Standalone Media Picker for TinyMCE
    Route::get('/media/picker', function() {
        return view('admin.media.picker');
    })->name('admin.media.picker');
});

