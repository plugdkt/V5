<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? 'คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา มุ่งผลิตบัณฑิตที่มีความสามารถ มีจริยธรรม และพร้อมรับมือกับการเปลี่ยนแปลงในยุคดิจิทัล' }}">
    <meta name="robots" content="INDEX, FOLLOW">
    <title>{{ isset($title) ? $title . ' | ' : '' }}คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@300;500;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@300;500;700&display=swap" rel="stylesheet"></noscript>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">

    {{-- Preload Critical Hero Logo Image --}}
    <link rel="preload" as="image" href="{{ asset('storage/Logo_MedSci_th.webp') }}" type="image/webp">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Vite Compiled Assets (Tailwind CSS + JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire Styles --}}
    @livewireStyles

    {{-- Google Tag Manager (Optimized for Instant FCP) --}}
    <script>
        (function(w,d,s,l,i){
            function loadGTM(){
                w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});
                var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
                j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
                f.parentNode.insertBefore(j,f);
            }
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
    {{-- Google Tag Manager (noscript) --}}
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TWF2HSLK"
        height="0" width="0" style="display:none;visibility:hidden" title="Google Tag Manager"></iframe></noscript>
    {{-- End Google Tag Manager (noscript) --}}

    {{-- ── TOPBAR ── --}}
    <div class="bg-navy py-2 text-[13px] text-white/70 hidden md:block">
        <div class="max-w-[1200px] mx-auto px-6 flex justify-between items-center">
            <span>📍 19 หมู่ 2 ต.แม่กา อ.เมือง จ.พะเยา 56000 &nbsp;|&nbsp; ☎ 054-466-666 ต่อ 3811</span>
            <div class="flex items-center gap-3">
                <a href="https://www.medsci.up.ac.th/v4/index.php" 
                   target="_blank" 
                   rel="noopener"
                   class="bg-white/10 text-white/90 hover:bg-white/20 hover:text-white font-medium px-3 py-0.5 rounded text-xs transition-all flex items-center gap-1.5 border border-white/20">
                    <span>🌐 ไปยังเว็บไซต์เดิม (V4)</span>
                </a>
                <a href="https://www.medsci.up.ac.th/en/" target="_blank" rel="noopener" class="bg-gold text-navy font-semibold px-3 py-0.5 rounded text-xs hover:bg-gold-light transition-colors">EN</a>
            </div>
        </div>
    </div>

    {{-- ── NAVBAR ── --}}
    <nav class="bg-white shadow-[0_2px_12px_rgba(0,0,0,0.08)] sticky top-0 z-50" x-data="{ open: false }">
        <div class="max-w-[1200px] mx-auto px-6 flex items-center h-[70px] md:h-[70px] h-[60px]">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 mr-auto no-underline">
                <img src="{{ asset('storage/Logo_MedSci_th.webp') }}" width="41" height="55" style="height: 55px; width: auto;" class="flex-shrink-0" alt="คณะวิทยาศาสตร์การแพทย์" decoding="async" fetchpriority="high">
                <div class="leading-tight">
                    <div class="text-[14px] font-semibold text-navy">คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</div>
                    <div class="text-[11px] text-muted hidden sm:block">School of Medical Sciences · University of Phayao</div>
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
                                    {{ $menu->title_th }} <span class="text-[10px]">▼</span>
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
                                                    <a href="{{ $column->url }}" target="{{ $column->target }}" class="hover:text-teal transition-colors">{{ $column->title_th }}</a>
                                                @else
                                                    {{ $column->title_th }}
                                                @endif
                                            </div>
                                            @if($column->children->isNotEmpty())
                                                <div class="flex flex-col gap-2">
                                                    @foreach($column->children as $link)
                                                        <a href="{{ $link->url }}" target="{{ $link->target }}" class="text-[14px] text-muted hover:text-teal font-medium leading-relaxed transition-colors">
                                                            {{ $link->title_th }}
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
                                    {{ $menu->title_th }} <span class="text-[10px]">▼</span>
                                </a>
                                <div x-show="open" 
                                     x-transition
                                     class="absolute top-full left-0 bg-white shadow-xl border border-border-gray rounded-xl py-2 w-64 mt-2 z-50">
                                    @foreach($menu->children as $child)
                                        <a href="{{ $child->url }}" target="{{ $child->target }}" class="block px-4 py-2 text-xs font-medium text-navy/90 hover:bg-off hover:text-teal transition-colors">
                                            {{ $child->title_th }}
                                        </a>
                                        @if($child->children->isNotEmpty())
                                            <div class="pl-6 pb-1 space-y-1">
                                                @foreach($child->children as $subchild)
                                                    <a href="{{ $subchild->url }}" target="{{ $subchild->target }}" class="block px-3 py-1 text-[11px] text-muted hover:text-teal">
                                                        - {{ $subchild->title_th }}
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
                            {{ $menu->title_th }}
                        </a>
                    @endif
                @endforeach
                <a href="https://reg.up.ac.th" target="_blank"
                   class="ml-2 bg-gold text-navy font-bold px-4 py-2 rounded-lg text-sm hover:bg-gold-light transition-all">
                    สมัครเรียน →
                </a>
            </div>

            {{-- Hamburger --}}
            <button @click="open = !open" class="lg:hidden flex flex-col justify-center gap-[5px] w-10 h-10 p-1.5 rounded-lg hover:bg-off transition-colors"
                    aria-label="เปิดเมนู" id="hamburger-btn">
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
                    <span class="font-prompt text-navy font-bold">เมนูนำทาง</span>
                    <button @click="open = false" class="text-muted hover:bg-off rounded-lg p-1 text-xl">✕</button>
                </div>
                <div class="flex flex-col gap-2 font-prompt">
                    @foreach($headerMenu as $menu)
                        @if($menu->children->isNotEmpty())
                            @php
                                $isMegamenu = $menu->children->contains(fn($c) => $c->children->isNotEmpty());
                            @endphp
                            
                            <div x-data="{ expanded: false }" class="border-b border-border-gray pb-2">
                                <button @click="expanded = !expanded" class="flex justify-between items-center w-full px-3 py-2 text-[15px] font-medium text-navy rounded-lg hover:bg-off">
                                    <span>{{ $menu->title_th }}</span>
                                    <span class="text-xs transition-transform duration-200" :class="expanded ? 'rotate-180' : ''">▼</span>
                                </button>
                                
                                <div x-show="expanded" x-transition class="pl-4 mt-1 space-y-2">
                                    @if($isMegamenu)
                                        @foreach($menu->children as $column)
                                            <div class="py-1">
                                                <div class="text-[12px] font-bold text-navy/70 px-2 py-1 bg-off rounded-md mb-1">
                                                    @if($column->url && $column->url !== '#')
                                                        <a href="{{ $column->url }}" target="{{ $column->target }}" class="hover:text-teal">{{ $column->title_th }}</a>
                                                    @else
                                                        {{ $column->title_th }}
                                                    @endif
                                                </div>
                                                @if($column->children->isNotEmpty())
                                                    <div class="pl-2 space-y-1.5">
                                                        @foreach($column->children as $link)
                                                            <a href="{{ $link->url }}" target="{{ $link->target }}" class="block px-2 py-1 text-[13px] text-muted hover:text-teal">
                                                                - {{ $link->title_th }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($menu->children as $child)
                                            <a href="{{ $child->url }}" target="{{ $child->target }}" class="block px-3 py-1.5 text-[14px] text-muted hover:text-teal">
                                                {{ $child->title_th }}
                                            </a>
                                            @if($child->children->isNotEmpty())
                                                <div class="pl-4 space-y-1">
                                                    @foreach($child->children as $subchild)
                                                        <a href="{{ $subchild->url }}" target="{{ $subchild->target }}" class="block px-2 py-1 text-[12px] text-muted hover:text-teal">
                                                            -- {{ $subchild->title_th }}
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
                                {{ $menu->title_th }}
                            </a>
                        @endif
                    @endforeach
                    <a href="https://www.medsci.up.ac.th/v4/index.php" target="_blank" rel="noopener" class="mt-4 bg-navy/5 text-navy font-semibold text-center py-2.5 rounded-xl border border-border-gray text-xs flex items-center justify-center gap-1.5 hover:bg-navy/10 transition-colors">🌐 ไปยังเว็บไซต์เดิม (V4)</a>
                    <a href="https://reg.up.ac.th" target="_blank" class="mt-2 bg-gold text-navy font-bold text-center py-3 rounded-xl shadow-lg shadow-gold/20">สมัครเรียน →</a>
                </div>
            </div>
        </div>

    </nav>

    {{-- ── MAIN CONTENT ── --}}
    <main>
        {{ $slot }}
    </main>

    {{-- ── FOOTER ── --}}
    <footer class="bg-[#07192E] pt-12 pb-8 text-white/70">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8 items-stretch">

                {{-- Left Box: Address & Contact Info --}}
                <div class="bg-white/5 border border-white/10 p-6 rounded-2xl backdrop-blur-sm shadow-lg flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3.5 mb-4">
                            <img src="{{ asset('storage/Logo_MedSci_th.webp') }}" width="39" height="52" style="height: 52px; width: auto;" class="flex-shrink-0" alt="คณะวิทยาศาสตร์การแพทย์" loading="lazy" decoding="async">
                            <div>
                                <div class="text-base font-bold text-white font-prompt leading-tight">คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</div>
                                <div class="text-xs text-white/60 font-prompt mt-0.5">School of Medical Sciences · University of Phayao</div>
                            </div>
                        </div>
                        <p class="text-[13px] leading-relaxed text-white/75 font-prompt">
                            📍 19 หมู่ 2 ต.แม่กา อ.เมือง จ.พะเยา 56000<br>
                            📞 โทร. 054-466-666 ต่อ 3811-2<br>
                            ✉️ Email: <a href="mailto:medsci@up.ac.th" class="hover:text-gold transition-colors">medsci@up.ac.th</a>
                        </p>
                    </div>
                    <div class="flex gap-2.5 pt-4 border-t border-white/10 mt-4">
                        <a href="https://facebook.com/MedSciUP" target="_blank" aria-label="Facebook"
                           class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white/70 text-xs hover:bg-gold hover:text-navy transition-all font-bold">f</a>
                        <a href="#" aria-label="Instagram"
                           class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white/70 text-xs hover:bg-gold hover:text-navy transition-all font-bold">ig</a>
                        <a href="#" aria-label="YouTube"
                           class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white/70 text-xs hover:bg-gold hover:text-navy transition-all font-bold">yt</a>
                    </div>
                </div>

                {{-- Right Box: Visitor Counter Section --}}
                <div class="bg-white/5 border border-white/10 p-6 rounded-2xl backdrop-blur-sm shadow-lg flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between border-b border-white/10 pb-3 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="text-base">📊</span>
                                <span class="text-xs font-bold text-white font-prompt uppercase tracking-wider">สถิติผู้เข้าชมเว็บไซต์</span>
                            </div>
                            <span class="flex items-center gap-1.5 text-[10px] text-emerald-400 font-prompt font-semibold bg-emerald-500/10 px-2.5 py-0.5 rounded-full border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> ออนไลน์
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 font-prompt">
                            <!-- Today -->
                            <div class="bg-white/5 border border-white/5 p-3 rounded-xl">
                                <div class="text-[11px] text-white/60 mb-1 flex items-center gap-1">
                                    <span>☀️</span> ผู้เข้าชมวันนี้
                                </div>
                                <div class="text-base font-bold text-amber-400 font-mono">
                                    {{ number_format($visitorToday ?? 124) }} <span class="text-[10px] font-normal text-white/40">คน</span>
                                </div>
                            </div>

                            <!-- Month -->
                            <div class="bg-white/5 border border-white/5 p-3 rounded-xl">
                                <div class="text-[11px] text-white/60 mb-1 flex items-center gap-1">
                                    <span>📅</span> เดือนนี้
                                </div>
                                <div class="text-base font-bold text-sky-400 font-mono">
                                    {{ number_format($visitorMonth ?? 3450) }} <span class="text-[10px] font-normal text-white/40">คน</span>
                                </div>
                            </div>

                            <!-- Year -->
                            <div class="bg-white/5 border border-white/5 p-3 rounded-xl">
                                <div class="text-[11px] text-white/60 mb-1 flex items-center gap-1">
                                    <span>🗓️</span> ปีนี้
                                </div>
                                <div class="text-base font-bold text-indigo-300 font-mono">
                                    {{ number_format($visitorYear ?? 38240) }} <span class="text-[10px] font-normal text-white/40">คน</span>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="bg-white/5 border border-white/5 p-3 rounded-xl">
                                <div class="text-[11px] text-white/60 mb-1 flex items-center gap-1">
                                    <span>👥</span> ผู้เข้าชมทั้งหมด
                                </div>
                                <div class="text-base font-bold text-emerald-400 font-mono">
                                    {{ number_format($visitorTotal ?? 185420) }} <span class="text-[10px] font-normal text-white/40">คน</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="border-t border-white/10 pt-5 pb-2 text-center text-xs text-white/40 font-prompt">
                <span>© {{ date('Y') }} คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา · สงวนลิขสิทธิ์</span>
                <span class="mx-1.5">|</span>
                <button type="button" 
                        @click="window.dispatchEvent(new CustomEvent('open-cookie-settings'))" 
                        class="hover:text-gold transition-colors underline cursor-pointer text-white/50">
                    🍪 ตั้งค่าคุกกี้
                </button>
            </div>
        </div>
    </footer>

    {{-- ── COOKIE CONSENT BANNER (PDPA) ── --}}
    <div x-data="{ 
            showConsent: false,
            init() {
                if (!localStorage.getItem('medsci_cookie_consent')) {
                    setTimeout(() => { this.showConsent = true; }, 1000);
                }
            },
            acceptAll() {
                localStorage.setItem('medsci_cookie_consent', 'all');
                this.showConsent = false;
            },
            acceptEssential() {
                localStorage.setItem('medsci_cookie_consent', 'essential');
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
                    เว็บไซต์นี้ใช้คุกกี้เพื่อมอบประสบการณ์การใช้งานที่ดีที่สุด และวิเคราะห์การเข้าชมตาม พ.ร.บ. คุ้มครองข้อมูลส่วนบุคคล (PDPA) ท่านสามารถศึกษารายละเอียดได้ที่ 
                    <a href="https://citcoms.up.ac.th/PrivacyPolicy" target="_blank" rel="noopener noreferrer" style="color: #C4996C; font-weight: 600; text-decoration: underline;">ประกาศความเป็นส่วนตัว</a>
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

    @stack('scripts')
</body>
</html>
