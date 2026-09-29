<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CMS Control Panel' }} | MedSci UP</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@300;500;700&display=swap" rel="stylesheet">

    {{-- TinyMCE (Optional, can load locally or CDN) --}}
    <script src="https://cdn.tiny.cloud/1/{{ config('services.tinymce.api_key') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>


    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @stack('styles')
</head>
<body class="bg-[#F3F4F6] text-navy antialiased flex min-h-screen">

    {{-- ── SIDEBAR ── --}}
    <aside class="w-64 bg-[#07192E] text-white flex-shrink-0 flex flex-col z-30 hidden md:flex">
        {{-- Logo Banner --}}
        <div class="h-16 flex items-center gap-3 px-6 border-b border-white/10 bg-[#040E1B]">
            <div class="w-8 h-8 rounded-full bg-gold flex items-center justify-center text-navy font-bold text-sm">M</div>
            <div>
                <span class="font-prompt font-bold text-xs block text-white">MedSci CMS</span>
                <span class="text-[10px] text-white/50 block leading-none">Faculty of Medical Sciences</span>
            </div>
        </div>

        {{-- Navigation Menu --}}
        <nav class="flex-grow p-4 overflow-y-auto space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->is('*/admin') ? 'admin-nav-item-active' : '' }}">
                <span>📊</span> แดชบอร์ด
            </a>
            
            <div class="text-[10px] uppercase font-bold text-white/40 px-4 pt-4 pb-2 tracking-wider">เนื้อหาเว็บหลัก</div>

            <a href="{{ route('admin.pages.index') }}" class="admin-nav-item {{ request()->is('*/admin/pages*') ? 'admin-nav-item-active' : '' }}">
                <span>📃</span> จัดการหน้าเว็บหลัก
            </a>  

            <a href="{{ route('admin.slides.index') }}" class="admin-nav-item {{ request()->is('*/admin/slides*') ? 'admin-nav-item-active' : '' }}">
                <span>🖼️</span> จัดการภาพสไลด์โชว์
            </a>         

            <a href="{{ route('admin.banners.index') }}" class="admin-nav-item {{ request()->is('*/admin/banners*') ? 'admin-nav-item-active' : '' }}">
                <span>🖼️</span> จัดการแบนเนอร์
            </a>
           

            <a href="{{ route('admin.programs.index') }}" class="admin-nav-item {{ request()->is('*/admin/programs*') ? 'admin-nav-item-active' : '' }}">
                <span>🎓</span> จัดการหลักสูตรการศึกษา
            </a>

            <a href="{{ route('admin.academic-articles.index') }}" class="admin-nav-item {{ request()->is('*/admin/academic-articles*') ? 'admin-nav-item-active' : '' }}">
                <span>📚</span> จัดการบทความวิชาการ
            </a>

            <a href="{{ route('admin.e-services.index') }}" class="admin-nav-item {{ request()->is('*/admin/e-services*') ? 'admin-nav-item-active' : '' }}">
                <span>🌐</span> จัดการ E-Service
            </a>

            <a href="{{ route('admin.downloads.index') }}" class="admin-nav-item {{ request()->is('*/admin/downloads*') ? 'admin-nav-item-active' : '' }}">
                <span>📄</span> จัดการไฟล์ดาวน์โหลด
            </a>

            <a href="{{ route('admin.executives.index') }}" class="admin-nav-item {{ request()->is('*/admin/executives*') ? 'admin-nav-item-active' : '' }}">
                <span>💼</span> จัดการรายชื่อผู้บริหาร
            </a>

            <a href="{{ route('admin.policies.index') }}" class="admin-nav-item {{ request()->is('*/admin/policies*') ? 'admin-nav-item-active' : '' }}">
                <span>📁</span> จัดการแผน / นโยบาย / มาตรการ
            </a>

            <a href="{{ route('admin.reports.index') }}" class="admin-nav-item {{ request()->is('*/admin/reports*') ? 'admin-nav-item-active' : '' }}">
                <span>📊</span> จัดการรายงานการดำเนินงาน
            </a>

            <a href="{{ route('admin.menus.index') }}" class="admin-nav-item {{ request()->is('*/admin/menus*') ? 'admin-nav-item-active' : '' }}">
                <span>🔗</span> จัดการเมนูนำทาง
            </a>


            <a href="{{ route('admin.media.index') }}" class="admin-nav-item {{ request()->is('*/admin/media*') ? 'admin-nav-item-active' : '' }}">
                <span>🖼️</span> คลังไฟล์และรูปภาพ
            </a>
            

            <div class="text-[10px] uppercase font-bold text-white/40 px-4 pt-4 pb-2 tracking-wider">การตั้งค่า</div>

            <a href="{{ route('admin.settings.index') }}" class="admin-nav-item {{ request()->is('*/admin/settings*') ? 'admin-nav-item-active' : '' }}">
                <span>⚙️</span> ตั้งค่าทั่วไป
            </a>
        </nav>

        {{-- Footer User Account --}}
        <div class="p-4 border-t border-white/10 bg-[#040E1B] flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-gold/20 flex items-center justify-center text-gold font-bold text-xs uppercase">
                {{ substr(Auth::user()->name, 0, 2) }}
            </div>
            <div class="min-w-0 flex-grow">
                <span class="text-xs font-bold block text-white truncate">{{ Auth::user()->name }}</span>
                <span class="text-[10px] text-white/50 block capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</span>
            </div>
        </div>
    </aside>

    {{-- ── MAIN WINDOW ── --}}
    <div class="flex-grow flex flex-col min-w-0">
        {{-- Header Bar --}}
        <header class="h-16 bg-white border-b border-border-gray flex justify-between items-center px-6 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                {{-- Hamburger for Mobile (Optional) --}}
                <h1 class="font-prompt font-bold text-base text-navy leading-none">
                    {{ $title ?? 'แผงควบคุมระบบ' }}
                </h1>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="text-xs font-bold text-teal hover:underline">
                    🌐 ดูหน้าเว็บหลัก
                </a>
                
                <span class="w-px h-6 bg-border-gray"></span>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-red-600 hover:underline cursor-pointer">
                        ออกจากระบบ ➔
                    </button>
                </form>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="flex-grow p-6 md:p-8 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-update-uri]').forEach(el => {
                const uri = el.getAttribute('data-update-uri');
                if (uri && uri.startsWith('/livewire')) {
                    el.setAttribute('data-update-uri', '/V5' + uri);
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
