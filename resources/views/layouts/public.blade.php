<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? __('faculty_full_name') }}">
    <meta name="keywords" content="{{ $keywords ?? __('meta_keywords') }}">
    <meta name="robots" content="INDEX, FOLLOW">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>{{ isset($title) ? $title . ' | ' : '' }}{{ __('faculty_full_name') }}</title>

    {{-- Open Graph / Facebook / LINE --}}
    <meta property="og:site_name" content="{{ __('faculty_full_name') }}">
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:title" content="{{ isset($title) ? $title . ' | ' : '' }}{{ __('faculty_full_name') }}">
    <meta property="og:description" content="{{ $description ?? __('faculty_full_name') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('storage/Logo_MedSci_th.webp') }}">
    <meta property="og:locale" content="{{ app()->getLocale() === 'en' ? 'en_US' : 'th_TH' }}">
    <meta property="og:locale:alternate" content="{{ app()->getLocale() === 'en' ? 'th_TH' : 'en_US' }}">

    {{-- Twitter Cards --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ isset($title) ? $title . ' | ' : '' }}{{ __('faculty_full_name') }}">
    <meta name="twitter:description" content="{{ $description ?? __('faculty_full_name') }}">
    <meta name="twitter:image" content="{{ $ogImage ?? asset('storage/Logo_MedSci_th.webp') }}">

    {{-- Schema.org Global Organization & WebSite (AEO & GEO) --}}
    <x-schema-org />

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@300;500;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@300;500;700&display=swap" rel="stylesheet"></noscript>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="alternate" type="application/rss+xml" title="คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา - ข้อมูลเผยแพร่ล่าสุด" href="{{ route('rss') }}">

    {{-- Preload Critical Hero Logo Image --}}
    <link rel="preload" as="image" href="{{ asset('storage/Logo_MedSci_th.webp') }}" type="image/webp">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Vite Compiled Assets (Tailwind CSS + JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire Styles --}}
    @livewireStyles

    {{-- Google Tag Manager: loaded only after the visitor accepts analytics cookies (PDPA, นโยบายคุกกี้) --}}
    <script>
        (function(w,d,s,l,i){
            var loaded = false;
            function consented(){ try { return localStorage.getItem('medsci_cookie_consent') === 'all'; } catch (e) { return false; } }
            function loadGTM(){
                if (loaded || !consented()) return;
                loaded = true;
                w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});
                var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
                j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
                f.parentNode.insertBefore(j,f);
            }
            w.medsciLoadGTM = loadGTM;
            if (!consented()) return;
            if('requestIdleCallback' in window){
                requestIdleCallback(loadGTM, {timeout: 1500});
            } else if (document.readyState === 'complete') {
                loadGTM();
            } else {
                window.addEventListener('load', loadGTM);
            }
        })(window,document,'script','dataLayer','GTM-TWF2HSLK');
    </script>
    {{-- End Google Tag Manager --}}

    <style>[x-cloak] { display: none !important; }</style>
    @stack('head')
    @stack('styles')
</head>
<body class="antialiased">
    {{-- Skip link (WCAG 2.4.1 Bypass Blocks) --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-[100000] focus:bg-gold focus:text-navy focus:font-bold focus:px-4 focus:py-2 focus:rounded-lg focus:shadow-lg">
        {{ app()->getLocale() === 'en' ? 'Skip to main content' : 'ข้ามไปยังเนื้อหาหลัก' }}
    </a>

    {{-- ── TOPBAR ── --}}
    <div class="bg-navy py-2 text-[13px] text-white/70 hidden md:block">
        <div class="max-w-[1200px] mx-auto px-6 flex justify-between items-center">
            <span>📍 {{ __('faculty_address') }} &nbsp;|&nbsp; ☎ {{ __('faculty_phone') }}</span>
            <div class="flex items-center gap-3">
                <form action="{{ route('search') }}" method="get" role="search" class="flex items-center">
                    <label for="topbar-search" class="sr-only">{{ app()->getLocale() === 'en' ? 'Search this website' : 'ค้นหาในเว็บไซต์' }}</label>
                    <input id="topbar-search" type="search" name="q" minlength="2" required
                           placeholder="{{ app()->getLocale() === 'en' ? 'Search…' : 'ค้นหา…' }}"
                           class="w-36 focus:w-52 transition-all bg-white/10 border border-white/20 rounded-l-md px-2.5 py-0.5 text-xs text-white placeholder-white/50 focus:outline-none focus:bg-white/20">
                    <button type="submit" class="bg-white/10 border border-l-0 border-white/20 rounded-r-md px-2 py-0.5 text-xs hover:bg-white/20" aria-label="{{ app()->getLocale() === 'en' ? 'Search' : 'ค้นหา' }}">🔍</button>
                </form>
                <div class="inline-flex items-center bg-white/10 rounded-lg p-0.5 border border-white/20 text-xs font-semibold" role="group" aria-label="ปรับขนาดตัวอักษร">
                    <button type="button" onclick="medsciFont(-1)" class="px-2 py-0.5 rounded text-white/80 hover:text-white" aria-label="ลดขนาดตัวอักษร" title="ลดขนาดตัวอักษร">ก-</button>
                    <button type="button" onclick="medsciFont(0)" class="px-2 py-0.5 rounded text-white/80 hover:text-white" aria-label="ขนาดตัวอักษรปกติ" title="ขนาดตัวอักษรปกติ">ก</button>
                    <button type="button" onclick="medsciFont(1)" class="px-2 py-0.5 rounded text-white/80 hover:text-white" aria-label="เพิ่มขนาดตัวอักษร" title="เพิ่มขนาดตัวอักษร">ก+</button>
                </div>
                <a href="https://www.medsci.up.ac.th/v4/index.php" 
                   target="_blank" 
                   rel="noopener"
                   class="bg-white/10 text-white/90 hover:bg-white/20 hover:text-white font-medium px-3 py-0.5 rounded text-xs transition-all flex items-center gap-1.5 border border-white/20">
                    <span>🌐 {{ __('legacy_website') }}</span>
                </a>
                
                {{-- Language Switcher (Top Bar) --}}
                <div class="inline-flex items-center bg-white/10 rounded-lg p-0.5 border border-white/20 text-xs font-semibold">
                    <a href="{{ route('lang.switch', 'th') }}" 
                       class="px-2.5 py-0.5 rounded transition-all {{ app()->getLocale() === 'th' ? 'bg-gold text-navy font-bold shadow-xs' : 'text-white/80 hover:text-white' }}" 
                       title="ภาษาไทย">
                        🇹🇭 TH
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}" 
                       class="px-2.5 py-0.5 rounded transition-all {{ app()->getLocale() === 'en' ? 'bg-gold text-navy font-bold shadow-xs' : 'text-white/80 hover:text-white' }}" 
                       title="English">
                        🇬🇧 EN
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ── NAVBAR ── --}}
    <nav class="bg-white shadow-[0_2px_12px_rgba(0,0,0,0.08)] sticky top-0 z-50" x-data="{ open: false }">
        <div class="max-w-[1200px] mx-auto px-6 flex items-center h-[70px] md:h-[70px] h-[60px]">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 mr-auto no-underline">
                <img src="{{ asset('storage/Logo_MedSci_th.webp') }}" width="41" height="55" style="height: 55px; width: auto;" class="flex-shrink-0" alt="{{ __('faculty_name') }}" decoding="async" fetchpriority="high">
                <div class="leading-tight">
                    @if(app()->getLocale() === 'en')
                        <div class="text-[14px] font-bold text-navy font-prompt">School of Medical Sciences</div>
                        <div class="text-[11px] text-muted font-medium">University of Phayao · Thailand</div>
                    @else
                        <div class="text-[14px] font-semibold text-navy">คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</div>
                        <div class="text-[11px] text-muted hidden sm:block">School of Medical Sciences · University of Phayao</div>
                    @endif
                </div>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden lg:flex items-center gap-1">
                @foreach($headerMenu as $menu)
                    @if($menu->children->isNotEmpty())
                        @php
                            $isMegamenu = $menu->children->contains(fn($c) => $c->children->isNotEmpty());
                        @endphp
                        
                        @if($isMegamenu)
                            {{-- Mega Menu --}}
                            <div class="static" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                <a href="{{ $menu->url }}" class="nav-link flex items-center gap-1 cursor-pointer">
                                    {{ $menu->title }} <span class="text-[10px]">▼</span>
                                </a>
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-4"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-4"
                                     class="absolute top-[70px] left-0 right-0 mx-auto max-w-[1152px] bg-white shadow-2xl border border-border-gray rounded-3xl p-8 grid grid-cols-5 gap-6 mt-2 z-50">
                                    
                                    @foreach($menu->children as $column)
                                        <div class="space-y-3">
                                            <div class="font-prompt text-sm font-bold text-navy pb-2 border-b border-border-gray uppercase tracking-wider">
                                                @if($column->url && $column->url !== '#')
                                                    <a href="{{ $column->url }}" target="{{ $column->target }}" class="hover:text-teal transition-colors">{{ $column->title }}</a>
                                                @else
                                                    {{ $column->title }}
                                                @endif
                                            </div>
                                            @if($column->children->isNotEmpty())
                                                <div class="flex flex-col gap-2">
                                                    @foreach($column->children as $link)
                                                        <a href="{{ $link->url }}" target="{{ $link->target }}" class="text-[14px] text-muted hover:text-teal font-medium leading-relaxed transition-colors">
                                                            {{ $link->title }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @else
                            {{-- Simple Dropdown --}}
                            <div class="relative" x-data="{ open: false }" @click.away="open = false" @mouseenter="open = true" @mouseleave="open = false">
                                <a href="{{ $menu->url }}" class="nav-link flex items-center gap-1 cursor-pointer">
                                    {{ $menu->title }} <span class="text-[10px]">▼</span>
                                </a>
                                <div x-show="open" 
                                     x-transition
                                     class="absolute top-full left-0 bg-white shadow-xl border border-border-gray rounded-xl py-2 w-64 mt-2 z-50">
                                    @foreach($menu->children as $child)
                                        <a href="{{ $child->url }}" target="{{ $child->target }}" class="block px-4 py-2 text-xs font-medium text-navy/90 hover:bg-off hover:text-teal transition-colors">
                                            {{ $child->title }}
                                        </a>
                                        @if($child->children->isNotEmpty())
                                            <div class="pl-6 pb-1 space-y-1">
                                                @foreach($child->children as $subchild)
                                                    <a href="{{ $subchild->url }}" target="{{ $subchild->target }}" class="block px-3 py-1 text-[11px] text-muted hover:text-teal">
                                                        - {{ $subchild->title }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <a href="{{ $menu->url }}" target="{{ $menu->target }}" class="nav-link {{ request()->is(ltrim($menu->url, '/')) ? 'nav-link-active' : '' }}">
                            {{ $menu->title }}
                        </a>
                    @endif
                @endforeach
                <a href="https://reg.up.ac.th" target="_blank"
                   class="ml-2 bg-gold text-navy font-bold px-4 py-2 rounded-lg text-sm hover:bg-gold-light transition-all">
                    {{ __('apply_admission') }} →
                </a>
            </div>

            {{-- Mobile/Tablet Language Toggle --}}
            <div class="lg:hidden inline-flex items-center bg-gray-100 rounded-lg p-0.5 border border-gray-200 text-xs font-semibold mr-2">
                <a href="{{ route('lang.switch', 'th') }}" 
                   class="px-2 py-0.5 rounded transition-all {{ app()->getLocale() === 'th' ? 'bg-gold text-navy font-bold shadow-xs' : 'text-gray-600 hover:text-navy' }}" 
                   title="ภาษาไทย">
                    TH
                </a>
                <a href="{{ route('lang.switch', 'en') }}" 
                   class="px-2 py-0.5 rounded transition-all {{ app()->getLocale() === 'en' ? 'bg-gold text-navy font-bold shadow-xs' : 'text-gray-600 hover:text-navy' }}" 
                   title="English">
                    EN
                </a>
            </div>

            {{-- Hamburger --}}
            <button @click="open = !open" class="lg:hidden flex flex-col justify-center gap-[5px] w-10 h-10 p-1.5 rounded-lg hover:bg-off transition-colors"
                    aria-label="{{ __('nav_navigation') }}" id="hamburger-btn">
                <span class="block w-[22px] h-0.5 bg-navy rounded transition-all" :class="open ? 'translate-y-[7px] rotate-45' : ''"></span>
                <span class="block w-[22px] h-0.5 bg-navy rounded transition-all" :class="open ? 'opacity-0' : ''"></span>
                <span class="block w-[22px] h-0.5 bg-navy rounded transition-all" :class="open ? '-translate-y-[7px] -rotate-45' : ''"></span>
            </button>
        </div>

        {{-- Mobile Drawer --}}
        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
             class="lg:hidden fixed inset-0 z-40" style="display: none;">
            <div class="absolute inset-0 bg-black/50" @click="open = false"></div>
            <div class="absolute top-0 right-0 bottom-0 w-80 bg-white p-6 overflow-y-auto shadow-2xl">
                <div class="flex justify-between items-center mb-6">
                    <span class="font-prompt text-navy font-bold">{{ __('nav_navigation') }}</span>
                    <div class="flex items-center gap-2">
                        <div class="inline-flex items-center bg-gray-100 rounded-lg p-0.5 border border-gray-200 text-xs font-semibold">
                            <a href="{{ route('lang.switch', 'th') }}" class="px-2 py-0.5 rounded {{ app()->getLocale() === 'th' ? 'bg-gold text-navy font-bold' : 'text-gray-600' }}">TH</a>
                            <a href="{{ route('lang.switch', 'en') }}" class="px-2 py-0.5 rounded {{ app()->getLocale() === 'en' ? 'bg-gold text-navy font-bold' : 'text-gray-600' }}">EN</a>
                        </div>
                        <button @click="open = false" class="text-muted hover:bg-off rounded-lg p-1 text-xl">✕</button>
                    </div>
                </div>
                <form action="{{ route('search') }}" method="get" role="search" class="flex mb-4">
                    <label for="drawer-search" class="sr-only">ค้นหาในเว็บไซต์</label>
                    <input id="drawer-search" type="search" name="q" minlength="2" required placeholder="ค้นหาในเว็บไซต์…"
                           class="flex-1 border border-border-gray rounded-l-lg px-3 py-2 text-sm focus:outline-none focus:border-teal">
                    <button type="submit" class="bg-navy text-white px-3 rounded-r-lg text-sm" aria-label="ค้นหา">🔍</button>
                </form>
                <div class="flex items-center justify-between mb-4 text-sm" role="group" aria-label="ปรับขนาดตัวอักษร">
                    <span class="text-muted">ขนาดตัวอักษร</span>
                    <span class="inline-flex bg-gray-100 rounded-lg p-0.5 border border-gray-200 font-semibold">
                        <button type="button" onclick="medsciFont(-1)" class="px-3 py-1 rounded" aria-label="ลดขนาดตัวอักษร">ก-</button>
                        <button type="button" onclick="medsciFont(0)" class="px-3 py-1 rounded" aria-label="ขนาดตัวอักษรปกติ">ก</button>
                        <button type="button" onclick="medsciFont(1)" class="px-3 py-1 rounded" aria-label="เพิ่มขนาดตัวอักษร">ก+</button>
                    </span>
                </div>
                <div class="flex flex-col gap-2 font-prompt">
                    @foreach($headerMenu as $menu)
                        @if($menu->children->isNotEmpty())
                            @php
                                $isMegamenu = $menu->children->contains(fn($c) => $c->children->isNotEmpty());
                            @endphp
                            
                            <div x-data="{ expanded: false }" class="border-b border-border-gray pb-2">
                                <button @click="expanded = !expanded" class="flex justify-between items-center w-full px-3 py-2 text-[15px] font-medium text-navy rounded-lg hover:bg-off">
                                    <span>{{ $menu->title }}</span>
                                    <span class="text-xs transition-transform duration-200" :class="expanded ? 'rotate-180' : ''">▼</span>
                                </button>
                                
                                <div x-show="expanded" x-transition class="pl-4 mt-1 space-y-2">
                                    @if($isMegamenu)
                                        @foreach($menu->children as $column)
                                            <div class="py-1">
                                                <div class="text-[12px] font-bold text-navy/70 px-2 py-1 bg-off rounded-md mb-1">
                                                    @if($column->url && $column->url !== '#')
                                                        <a href="{{ $column->url }}" target="{{ $column->target }}" class="hover:text-teal">{{ $column->title }}</a>
                                                    @else
                                                        {{ $column->title }}
                                                    @endif
                                                </div>
                                                @if($column->children->isNotEmpty())
                                                    <div class="pl-2 space-y-1.5">
                                                        @foreach($column->children as $link)
                                                            <a href="{{ $link->url }}" target="{{ $link->target }}" class="block px-2 py-1 text-[13px] text-muted hover:text-teal">
                                                                - {{ $link->title }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($menu->children as $child)
                                            <a href="{{ $child->url }}" target="{{ $child->target }}" class="block px-3 py-1.5 text-[14px] text-muted hover:text-teal">
                                                {{ $child->title }}
                                            </a>
                                            @if($child->children->isNotEmpty())
                                                <div class="pl-4 space-y-1">
                                                    @foreach($child->children as $subchild)
                                                        <a href="{{ $subchild->url }}" target="{{ $subchild->target }}" class="block px-2 py-1 text-[12px] text-muted hover:text-teal">
                                                            -- {{ $subchild->title }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @else
                            <a href="{{ $menu->url }}" target="{{ $menu->target }}" class="px-3 py-2 text-[15px] font-medium text-navy rounded-lg border-b border-border-gray hover:bg-off hover:text-teal transition-colors">
                                {{ $menu->title }}
                            </a>
                        @endif
                    @endforeach
                    <a href="https://www.medsci.up.ac.th/v4/index.php" target="_blank" rel="noopener" class="mt-4 bg-navy/5 text-navy font-semibold text-center py-2.5 rounded-xl border border-border-gray text-xs flex items-center justify-center gap-1.5 hover:bg-navy/10 transition-colors">🌐 {{ __('legacy_website') }}</a>
                    <a href="https://reg.up.ac.th" target="_blank" class="mt-2 bg-gold text-navy font-bold text-center py-3 rounded-xl shadow-lg shadow-gold/20">{{ __('apply_admission') }} →</a>
                </div>
            </div>
        </div>

    </nav>

    {{-- ── MAIN CONTENT ── --}}
    <main id="main-content" tabindex="-1" data-font-scale class="focus:outline-none">
        {{ $slot }}
    </main>

    {{-- ── FOOTER ── --}}
    <footer class="bg-[#07192E] pt-12 pb-8 text-white/70" data-font-scale>
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8 items-stretch">

                {{-- Left Box: Address & Contact Info --}}
                <div class="bg-white/5 border border-white/10 p-6 rounded-2xl backdrop-blur-sm shadow-lg flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3.5 mb-4">
                            <img src="{{ asset('storage/Logo_MedSci_th.webp') }}" width="39" height="52" style="height: 52px; width: auto;" class="flex-shrink-0" alt="{{ __('faculty_name') }}" loading="lazy" decoding="async">
                            <div>
                                <div class="text-base font-bold text-white font-prompt leading-tight">{{ __('faculty_full_name') }}</div>
                                <div class="text-xs text-white/60 font-prompt mt-0.5">School of Medical Sciences · University of Phayao</div>
                            </div>
                        </div>
                        <p class="text-[13px] leading-relaxed text-white/75 font-prompt">
                            📍 {{ __('faculty_address') }}<br>
                            📞 {{ app()->getLocale() === 'en' ? 'Tel.' : 'โทร.' }} {{ __('faculty_phone') }}<br>
                            ✉️ Email: <a href="mailto:medsci@up.ac.th" class="hover:text-gold transition-colors">medsci@up.ac.th</a><br>
                            🛠️ {{ app()->getLocale() === 'en' ? 'Webmaster' : 'ผู้ดูแลเว็บไซต์' }}: <a href="mailto:wittaya.su@up.ac.th" class="hover:text-gold transition-colors">wittaya.su@up.ac.th</a>
                        </p>
                    </div>
                    <div class="flex gap-2.5 pt-4 border-t border-white/10 mt-4">
                        <a href="{{ $socialFacebook ?: 'https://facebook.com/MedSciUP' }}" target="_blank" rel="noopener" aria-label="Facebook"
                           class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white/70 text-xs hover:bg-gold hover:text-navy transition-all font-bold">f</a>
                        @if(!empty($socialYoutube) && rtrim($socialYoutube, '/') !== 'https://www.youtube.com')
                            <a href="{{ $socialYoutube }}" target="_blank" rel="noopener" aria-label="YouTube"
                               class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white/70 text-xs hover:bg-gold hover:text-navy transition-all font-bold">yt</a>
                        @endif
                        <a href="{{ route('rss') }}" aria-label="RSS Feed" title="RSS ข้อมูลเผยแพร่ล่าสุด"
                           class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white/70 text-[10px] hover:bg-gold hover:text-navy transition-all font-bold">RSS</a>
                    </div>
                </div>

                {{-- Right Box: Visitor Counter Section --}}
                <div class="bg-white/5 border border-white/10 p-6 rounded-2xl backdrop-blur-sm shadow-lg flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between border-b border-white/10 pb-3 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="text-base">📊</span>
                                <span class="text-xs font-bold text-white font-prompt uppercase tracking-wider">{{ app()->getLocale() === 'en' ? 'Visitor Statistics' : 'สถิติผู้เข้าชมเว็บไซต์' }}</span>
                            </div>
                            <span class="flex items-center gap-1.5 text-[10px] text-emerald-400 font-prompt font-semibold bg-emerald-500/10 px-2.5 py-0.5 rounded-full border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> {{ app()->getLocale() === 'en' ? 'Online' : 'ออนไลน์' }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 font-prompt">
                            <!-- Today -->
                            <div class="bg-white/5 border border-white/5 p-3 rounded-xl">
                                <div class="text-[11px] text-white/60 mb-1 flex items-center gap-1">
                                    <span>☀️</span> {{ app()->getLocale() === 'en' ? 'Today' : 'ผู้เข้าชมวันนี้' }}
                                </div>
                                <div class="text-base font-bold text-amber-400 font-mono">
                                    {{ number_format($visitorToday ?? 124) }} <span class="text-[10px] font-normal text-white/40">{{ app()->getLocale() === 'en' ? 'views' : 'คน' }}</span>
                                </div>
                            </div>

                            <!-- Month -->
                            <div class="bg-white/5 border border-white/5 p-3 rounded-xl">
                                <div class="text-[11px] text-white/60 mb-1 flex items-center gap-1">
                                    <span>📅</span> {{ app()->getLocale() === 'en' ? 'This Month' : 'เดือนนี้' }}
                                </div>
                                <div class="text-base font-bold text-sky-400 font-mono">
                                    {{ number_format($visitorMonth ?? 3450) }} <span class="text-[10px] font-normal text-white/40">{{ app()->getLocale() === 'en' ? 'views' : 'คน' }}</span>
                                </div>
                            </div>

                            <!-- Year -->
                            <div class="bg-white/5 border border-white/5 p-3 rounded-xl">
                                <div class="text-[11px] text-white/60 mb-1 flex items-center gap-1">
                                    <span>🗓️</span> {{ app()->getLocale() === 'en' ? 'This Year' : 'ปีนี้' }}
                                </div>
                                <div class="text-base font-bold text-indigo-300 font-mono">
                                    {{ number_format($visitorYear ?? 38240) }} <span class="text-[10px] font-normal text-white/40">{{ app()->getLocale() === 'en' ? 'views' : 'คน' }}</span>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="bg-white/5 border border-white/5 p-3 rounded-xl">
                                <div class="text-[11px] text-white/60 mb-1 flex items-center gap-1">
                                    <span>👥</span> {{ app()->getLocale() === 'en' ? 'Total Visitors' : 'ผู้เข้าชมทั้งหมด' }}
                                </div>
                                <div class="text-base font-bold text-emerald-400 font-mono">
                                    {{ number_format($visitorTotal ?? 185420) }} <span class="text-[10px] font-normal text-white/40">{{ app()->getLocale() === 'en' ? 'views' : 'คน' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Text menu + policies (มาตรฐานเว็บไซต์ภาครัฐ 3.0 ข้อ 8.9) --}}
            <nav aria-label="{{ app()->getLocale() === 'en' ? 'Footer menu' : 'เมนูส่วนท้าย' }}" class="border-t border-white/10 pt-5 mb-4 text-xs font-prompt">
                <ul class="flex flex-wrap justify-center gap-x-4 gap-y-2 text-white/60 mb-3">
                    @foreach($headerMenu as $menu)
                        @if($menu->url && $menu->url !== '#')
                            <li><a href="{{ $menu->url }}" target="{{ $menu->target }}" class="hover:text-gold transition-colors">{{ $menu->title }}</a></li>
                        @endif
                    @endforeach
                    <li><a href="{{ route('sitemap.page') }}" class="hover:text-gold transition-colors">{{ app()->getLocale() === 'en' ? 'Sitemap' : 'ผังเว็บไซต์' }}</a></li>
                    @if(!empty($surveyUrl))
                        <li><a href="{{ $surveyUrl }}" target="_blank" rel="noopener" class="hover:text-gold transition-colors">{{ app()->getLocale() === 'en' ? 'Satisfaction Survey' : 'แบบประเมินความพึงพอใจ' }}</a></li>
                    @endif
                </ul>
                <ul class="flex flex-wrap justify-center gap-x-4 gap-y-2 text-white/50">
                    @foreach(\App\Http\Controllers\Public\SiteController::POLICY_PAGES as $slug => $name)
                        <li><a href="{{ route('pages.show', $slug) }}" class="hover:text-gold transition-colors">{{ $name }}</a></li>
                    @endforeach
                    <li><a href="{{ route('pages.show', 'website-policy') }}#disclaimer" class="hover:text-gold transition-colors">{{ app()->getLocale() === 'en' ? 'Disclaimer' : 'ข้อจำกัดความรับผิด' }}</a></li>
                </ul>
            </nav>

            <div class="border-t border-white/10 pt-5 pb-2 text-center text-xs text-white/40 font-prompt">
                <span>© {{ date('Y') }} {{ __('faculty_full_name') }} · {{ __('all_rights_reserved') }}</span>
                <span class="mx-1.5">|</span>
                <button type="button" 
                        @click="window.dispatchEvent(new CustomEvent('open-cookie-settings'))" 
                        class="hover:text-gold transition-colors underline cursor-pointer text-white/50">
                    🍪 {{ app()->getLocale() === 'en' ? 'Cookie Settings' : 'ตั้งค่าคุกกี้' }}
                </button>
            </div>
        </div>
    </footer>

    {{-- ── COOKIE CONSENT BANNER (PDPA) ── --}}
    <div x-data="{ 
            showConsent: false,
            init() {
                let saved = null;
                try { saved = localStorage.getItem('medsci_cookie_consent'); } catch (e) {}
                if (!saved) {
                    setTimeout(() => { this.showConsent = true; }, 1000);
                }
            },
            acceptAll() {
                try { localStorage.setItem('medsci_cookie_consent', 'all'); } catch (e) {}
                this.showConsent = false;
                if (window.medsciLoadGTM) window.medsciLoadGTM();
            },
            acceptEssential() {
                try { localStorage.setItem('medsci_cookie_consent', 'essential'); } catch (e) {}
                this.showConsent = false;
            }
         }"
         @open-cookie-settings.window="showConsent = true"
         x-cloak
         x-show="showConsent"
         x-transition:enter="transition ease-out duration-400"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-8"
         style="display: none; position: fixed; bottom: 1.25rem; right: 1.25rem; max-width: 440px; width: calc(100% - 2.5rem); z-index: 99999; background-color: #07192E; color: #ffffff; border: 2px solid #C4996C; border-radius: 1rem; box-shadow: 0 20px 35px -5px rgba(0, 0, 0, 0.7); padding: 1.25rem;"
         role="dialog"
         aria-labelledby="cookie-consent-title"
         aria-describedby="cookie-consent-desc">
        
        <div style="display: flex; align-items: flex-start; gap: 0.85rem; margin-bottom: 0.5rem;">
            <div style="width: 2.25rem; height: 2.25rem; border-radius: 0.65rem; background-color: rgba(196, 153, 108, 0.25); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                🍪
            </div>
            <div>
                <div id="cookie-consent-title" style="font-family: 'Prompt', sans-serif; font-size: 0.95rem; font-weight: 700; color: #ffffff; line-height: 1.3;">
                    การใช้งานคุกกี้ (Cookies Notice)
                </div>
                <div id="cookie-consent-desc" style="font-family: 'Sarabun', sans-serif; font-size: 0.825rem; color: #E2E8F0; line-height: 1.55; margin-top: 0.3rem;">
                    เว็บไซต์นี้ใช้คุกกี้ที่จำเป็นต่อการทำงานของระบบ และจะใช้คุกกี้เพื่อการวิเคราะห์การเข้าชมเมื่อท่านกด “ยอมรับ” เท่านั้น ตาม พ.ร.บ. คุ้มครองข้อมูลส่วนบุคคล (PDPA) ศึกษารายละเอียดได้ที่
                    <a href="{{ route('pages.show', 'cookie-policy') }}" style="color: #C4996C; font-weight: 600; text-decoration: underline;">นโยบายคุกกี้</a> และ
                    <a href="{{ route('pages.show', 'privacy-policy') }}" style="color: #C4996C; font-weight: 600; text-decoration: underline;">นโยบายคุ้มครองข้อมูลส่วนบุคคล</a>
                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.5rem; margin-top: 0.85rem; padding-top: 0.75rem; border-top: 1px solid rgba(255, 255, 255, 0.12);">
            <button @click="acceptEssential()" 
                    style="background-color: rgba(255, 255, 255, 0.08); color: #E2E8F0; border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 0.5rem; padding: 0.35rem 0.85rem; font-size: 0.75rem; font-family: 'Prompt', sans-serif; cursor: pointer; transition: all 0.2s;">
                เฉพาะที่จำเป็น
            </button>
            <button @click="acceptAll()" 
                    style="background-color: #C4996C; color: #07192E; font-weight: 700; border: none; border-radius: 0.5rem; padding: 0.35rem 1.1rem; font-size: 0.75rem; font-family: 'Prompt', sans-serif; cursor: pointer; box-shadow: 0 2px 8px rgba(196, 153, 108, 0.3); transition: all 0.2s;">
                ✓ ยอมรับ
            </button>
        </div>
    </div>

    {{-- Alpine.js (bundled with Livewire) --}}
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

    <script>
        (function () {
            var steps = [0.9, 1, 1.1, 1.2, 1.3], key = 'medsci_font_scale', idx = 1;
            try { var v = parseFloat(localStorage.getItem(key)); if (steps.indexOf(v) >= 0) idx = steps.indexOf(v); } catch (e) {}
            function apply() { document.querySelectorAll('[data-font-scale]').forEach(function (el) { el.style.zoom = steps[idx]; }); }
            window.medsciFont = function (d) {
                idx = d === 0 ? 1 : Math.min(steps.length - 1, Math.max(0, idx + d));
                try { localStorage.setItem(key, steps[idx]); } catch (e) {}
                apply();
            };
            apply();
        })();
    </script>

    @stack('scripts')
</body>
</html>
