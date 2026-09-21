<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::where('slug', 'history')->first();
        $title = $page ? $page->title : 'ประวัติความเป็นมา';
        $content = $page ? $page->body : '<p>ประวัติของคณะวิทยาศาสตร์การแพทย์</p>';
        return view('public.pages.dynamic', compact('title', 'content', 'page'));
    }


    public function structure()
    {
        $page = Page::where('slug', 'structure')->first();
        $title = $page ? $page->title : 'โครงสร้างองค์กร';
        $content = $page ? $page->body : null;

        if ($page && $page->published) {
            return view('public.pages.dynamic', compact('title', 'content', 'page'));
        }

        return view('public.pages.structure');
    }


    public function management()
    {
        $executives = \App\Models\Executive::orderBy('order_key', 'asc')->get();
        return view('public.pages.management', compact('executives'));
    }



    public function vision()
    {
        $page = Page::where('slug', 'vision')->first();
        $title = $page ? $page->title : 'วิสัยทัศน์ / พันธกิจ';
        $content = $page ? $page->body : '<p>วิสัยทัศน์และพันธกิจของคณะ</p>';
        return view('public.pages.dynamic', compact('title', 'content', 'page'));
    }

    public function divisions()
    {
        return view('public.pages.divisions');
    }


    public function programs()
    {
        $programs = \App\Models\Program::where('is_active', true)->orderBy('sort_order')->get();
        return view('public.pages.programs.index', compact('programs'));
    }

    public function admission()
    {
        $programs = \App\Models\Program::where('is_active', true)->orderBy('sort_order')->get();
        return view('public.pages.admission', compact('programs'));
    }

    public function programDetail($slug)
    {
        $program = \App\Models\Program::where('slug', $slug)->where('is_active', true)->first();
        if (!$program) {
            abort(404);
        }
        return view('public.pages.programs.detail', compact('program'));
    }

    public function research()
    {
        return view('public.pages.research');
    }

    public function services()
    {
        $services = \App\Models\EService::where('is_active', true)->orderBy('sort_order')->get();
        return view('public.pages.services', compact('services'));
    }

    public function calendar()
    {
        return view('public.pages.calendar');
    }

    public function contact()
    {
        $page = Page::where('slug', 'contact-us')->first();
        if ($page && $page->published) {
            $title = $page->title;
            $content = $page->body;
            return view('public.pages.dynamic', compact('title', 'content', 'page'));
        }

        $phone = Setting::get('contact_phone', '054-466-666 ต่อ 3811');
        $email = Setting::get('contact_email', 'medsci@up.ac.th');
        $address = Setting::get('contact_address', '19 หมู่ 2 ต.แม่กา อ.เมือง จ.พะเยา 56000');
        return view('public.pages.contact', compact('phone', 'email', 'address'));
    }

    public function corruptionComplaint()
    {
        return view('public.pages.corruption-complaint');
    }

    public function officeSchedule()
    {
        return view('public.pages.office-schedule');
    }

    public function intranet()
    {
        return view('public.pages.intranet');
    }

    public function showDynamicPage($slug)
    {
        $page = Page::where('slug', $slug)->where('published', true)->firstOrFail();
        $title = $page->title;
        $content = $page->body;
        return view('public.pages.dynamic', compact('title', 'content', 'page'));
    }

    public function policies()
    {
        $categories = \App\Models\PolicyCategory::where('is_active', true)
            ->with(['documents' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        return view('public.pages.policies', compact('categories'));
    }

    public function reports()
    {
        $categories = \App\Models\ReportCategory::where('is_active', true)
            ->with(['documents' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        return view('public.pages.reports', compact('categories'));
    }

    public function carSchedule()
    {
        return view('public.pages.car-schedule');
    }

    public function academicArticles()
    {
        $articles = \App\Models\AcademicArticle::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return view('public.pages.academic-articles', compact('articles'));
    }
}

