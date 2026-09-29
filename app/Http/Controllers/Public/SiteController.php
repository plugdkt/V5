<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AcademicArticle;
use App\Models\DownloadableFile;
use App\Models\EService;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\PolicyDocument;
use App\Models\Program;
use App\Models\ReportDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

/**
 * Site-wide features required by the Government Website Standard v3.0 (มสพร. 11-2566):
 * search (ข้อ 8.3), HTML sitemap (ข้อ 4.7) and RSS feed (ข้อ 8.2).
 */
class SiteController extends Controller
{
    /** Policy / information pages that ship with the site (can be overridden by a CMS page with the same slug). */
    public const POLICY_PAGES = [
        'website-policy'  => 'นโยบายเว็บไซต์',
        'privacy-policy'  => 'นโยบายคุ้มครองข้อมูลส่วนบุคคล',
        'cookie-policy'   => 'นโยบายคุกกี้',
        'security-policy' => 'นโยบายการรักษาความมั่นคงปลอดภัยเว็บไซต์',
        'accessibility'   => 'การเข้าถึงเว็บไซต์',
    ];

    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $groups = [];

        if (mb_strlen($q) >= 2) {
            $like = '%' . str_replace(['%', '_'], ['\%', '\_'], $q) . '%';
            $groups = array_filter([
                'หน้าเว็บไซต์' => $this->safe(fn () => $this->searchPages($like, $q)),
                'หลักสูตร' => $this->safe(fn () => Program::where('is_active', true)
                    ->where(fn ($w) => $w->where('title_th', 'like', $like)->orWhere('title_en', 'like', $like)->orWhere('overview', 'like', $like))
                    ->limit(10)->get()
                    ->map(fn ($p) => ['title' => $p->title_th, 'url' => route('programs.detail', $p->slug), 'excerpt' => Str::limit(strip_tags((string) $p->overview), 160)])),
                'แผน / นโยบาย / มาตรการ' => $this->safe(fn () => PolicyDocument::where('is_active', true)
                    ->where(fn ($w) => $w->where('title', 'like', $like)->orWhere('group_name', 'like', $like))
                    ->limit(15)->get()
                    ->map(fn ($d) => ['title' => $d->title, 'url' => $this->fileUrl($d->file_path) ?? route('pages.policies'), 'excerpt' => $d->group_name])),
                'รายงานผลการดำเนินงาน' => $this->safe(fn () => ReportDocument::where('is_active', true)
                    ->where(fn ($w) => $w->where('title', 'like', $like)->orWhere('group_name', 'like', $like))
                    ->limit(15)->get()
                    ->map(fn ($d) => ['title' => $d->title, 'url' => $this->fileUrl($d->file_path) ?? route('pages.reports'), 'excerpt' => $d->group_name])),
                'แบบฟอร์มดาวน์โหลด' => $this->safe(fn () => DownloadableFile::where('active', true)
                    ->where(fn ($w) => $w->where('title', 'like', $like)->orWhere('description', 'like', $like))
                    ->limit(15)->get()
                    ->map(fn ($f) => ['title' => $f->title, 'url' => route('downloads.file', $f->id), 'excerpt' => Str::limit((string) $f->description, 160)])),
                'บทความวิชาการ' => $this->safe(fn () => AcademicArticle::where('is_active', true)
                    ->where(fn ($w) => $w->where('title', 'like', $like)->orWhere('author', 'like', $like))
                    ->limit(10)->get()
                    ->map(fn ($a) => ['title' => $a->title, 'url' => $a->link_url ?: route('pages.academic-articles'), 'excerpt' => $a->author])),
                'บริการออนไลน์ (E-Service)' => $this->safe(fn () => EService::where('is_active', true)
                    ->where(fn ($w) => $w->where('title', 'like', $like)->orWhere('description', 'like', $like))
                    ->limit(10)->get()
                    ->map(fn ($e) => ['title' => $e->title, 'url' => $e->url, 'excerpt' => Str::limit((string) $e->description, 160)])),
                'เมนูเว็บไซต์' => $this->safe(fn () => MenuItem::where('active', true)
                    ->where(fn ($w) => $w->where('title_th', 'like', $like)->orWhere('title_en', 'like', $like))
                    ->where('url', '!=', '#')->limit(10)->get()
                    ->map(fn ($m) => ['title' => $m->title_th, 'url' => $m->url, 'excerpt' => ''])),
            ], fn ($items) => $items->isNotEmpty());
        }

        $total = array_sum(array_map(fn ($g) => $g->count(), $groups));
        $newsUrl = 'https://www.medsci.up.ac.th/msc_news/index.php';

        return view('public.pages.search', compact('q', 'groups', 'total', 'newsUrl'));
    }

    public function sitemap()
    {
        $menu = MenuItem::where('location', 'header')->whereNull('parent_id')->where('active', true)
            ->orderBy('order')->with('children.children')->get();
        $policies = self::POLICY_PAGES;

        return view('public.pages.sitemap', compact('menu', 'policies'));
    }

    /** RSS 2.0 feed of recently published documents on this site (news has its own system: MSC News). */
    public function rss()
    {
        $items = collect()
            ->merge($this->safe(fn () => PolicyDocument::where('is_active', true)->latest('updated_at')->limit(15)->get()
                ->map(fn ($d) => ['title' => $d->title, 'link' => $this->fileUrl($d->file_path) ?? route('pages.policies'), 'desc' => 'แผน / นโยบาย / มาตรการ: ' . $d->group_name, 'date' => $d->updated_at])))
            ->merge($this->safe(fn () => ReportDocument::where('is_active', true)->latest('updated_at')->limit(15)->get()
                ->map(fn ($d) => ['title' => $d->title, 'link' => $this->fileUrl($d->file_path) ?? route('pages.reports'), 'desc' => 'รายงานผลการดำเนินงาน: ' . $d->group_name, 'date' => $d->updated_at])))
            ->merge($this->safe(fn () => DownloadableFile::where('active', true)->latest('updated_at')->limit(15)->get()
                ->map(fn ($f) => ['title' => $f->title, 'link' => route('downloads.file', $f->id), 'desc' => 'แบบฟอร์มดาวน์โหลด', 'date' => $f->updated_at])))
            ->merge($this->safe(fn () => Page::where('published', true)->latest('updated_at')->limit(10)->get()
                ->map(fn ($p) => ['title' => $p->title, 'link' => route('pages.show', $p->slug), 'desc' => Str::limit(strip_tags((string) $p->body), 200), 'date' => $p->updated_at])))
            ->filter(fn ($i) => !empty($i['date']))
            ->sortByDesc('date')->take(30)->values();

        $xml = view('public.rss', ['items' => $items])->render();

        return Response::make('<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $xml, 200, [
            'Content-Type' => 'application/rss+xml; charset=UTF-8',
        ]);
    }

    private function searchPages(string $like, string $q): Collection
    {
        $fromDb = Page::where('published', true)
            ->where(fn ($w) => $w->where('title', 'like', $like)->orWhere('body', 'like', $like))
            ->limit(15)->get()
            ->map(fn ($p) => ['title' => $p->title, 'url' => route('pages.show', $p->slug), 'excerpt' => $this->excerpt((string) $p->body, $q)]);

        $builtIn = collect(self::POLICY_PAGES)
            ->filter(fn ($title) => mb_stripos($title, $q) !== false)
            ->map(fn ($title, $slug) => ['title' => $title, 'url' => route('pages.show', $slug), 'excerpt' => ''])
            ->values();

        return $fromDb->merge($builtIn);
    }

    private function excerpt(string $html, string $q): string
    {
        $text = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($html))));
        $pos = mb_stripos($text, $q);
        $start = $pos === false ? 0 : max(0, $pos - 60);
        return ($start > 0 ? '… ' : '') . mb_substr($text, $start, 180) . '…';
    }

    private function fileUrl(?string $path): ?string
    {
        // same convention as the public policy/report pages, which link file_path as stored
        return $path ?: null;
    }

    /** A missing table/column in one source must not break the whole page. */
    private function safe(callable $fn): Collection
    {
        try {
            return collect($fn());
        } catch (\Throwable $e) {
            report($e);
            return collect();
        }
    }
}
