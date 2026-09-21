<x-public-layout>
    @php
        $slidesData = ($slides->isNotEmpty() ? $slides : collect([
            (object)[
                'photo_path' => '/storage/media/banner_lab.png',
                'eyebrow' => '🔬 School of Medical Sciences · University of Phayao',
                'title_th' => 'แหล่งปัญญาด้าน',
                'title_highlight' => 'วิทยาศาสตร์การแพทย์',
                'title_th_end' => 'ระดับอาเซียน',
                'subtitle' => 'มุ่งผลิตบัณฑิตที่มีความสามารถ มีจริยธรรม และพร้อมรับมือกับการเปลี่ยนแปลงในยุคดิจิทัล',
                'primary_btn_text' => 'ดูหลักสูตรทั้งหมด',
                'primary_btn_url' => route('programs'),
                'secondary_btn_text' => 'แนะนำคณะ ▶',
                'secondary_btn_url' => route('about')
            ]
        ]))->map(fn($slide) => [
            'bg' => (function($path) {
                if (filter_var($path, FILTER_VALIDATE_URL)) {
                    $parsed = parse_url($path);
                    $path = $parsed['path'] ?? $path;
                }
                $path = str_replace(['/V5/public/storage/', '/storage/'], '', $path);
                $cleanPath = ltrim($path, '/');
                $webpPath = preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $cleanPath);
                if (file_exists(public_path('storage/' . $webpPath))) {
                    return asset('storage/' . $webpPath);
                }
                return asset('storage/' . $cleanPath);
            })($slide->photo_path),
            'eyebrow' => $slide->eyebrow ?? '',
            'titleTh' => $slide->title_th,
            'titleHighlight' => $slide->title_highlight ?? '',
            'titleThEnd' => $slide->title_th_end ?? '',
            'subtitle' => $slide->subtitle ?? '',
            'primaryBtnText' => $slide->primary_btn_text ?? '',
            'primaryBtnUrl' => $slide->primary_btn_url ?? '#',
            'secondaryBtnText' => $slide->secondary_btn_text ?? '',
            'secondaryBtnUrl' => $slide->secondary_btn_url ?? '#'
        ]);
    @endphp

    @php
        $firstSlideBg = $slidesData->first()['bg'] ?? asset('storage/media/banner_lab.png');
        $firstSlideMobileBg = preg_replace('/\.webp$/i', '_mobile.webp', $firstSlideBg);
        $cleanMobileCheck = ltrim(str_replace(['/V5/public/storage/', '/storage/'], '', $firstSlideMobileBg), '/');
        if (!file_exists(public_path('storage/' . $cleanMobileCheck))) {
            $firstSlideMobileBg = $firstSlideBg;
        }
    @endphp

    @push('head')
        <link rel="preload" as="image" href="{{ $firstSlideMobileBg }}" type="image/webp" media="(max-width: 768px)" fetchpriority="high">
        <link rel="preload" as="image" href="{{ $firstSlideBg }}" type="image/webp" media="(min-width: 769px)" fetchpriority="high">
    @endpush

    {{-- ── HERO SLIDESHOW SECTION ── --}}
    <section class="relative min-h-[560px] flex items-center overflow-hidden text-white bg-navy"
             x-data="slideshowComponent()">

        <!-- Initial Server-Rendered Background Image for Instant LCP Discovery -->
        <div class="absolute inset-0 z-0 overflow-hidden" x-show="activeSlide === 0">
            <picture>
                <source media="(max-width: 768px)" srcset="{{ $firstSlideMobileBg }}" type="image/webp">
                <source media="(min-width: 769px)" srcset="{{ $firstSlideBg }}" type="image/webp">
                <img src="{{ $firstSlideMobileBg }}" 
                     srcset="{{ $firstSlideMobileBg }} 768w, {{ $firstSlideBg }} 1600w"
                     sizes="100vw"
                     alt="คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา" 
                     fetchpriority="high" 
                     decoding="sync" 
                     class="w-full h-full object-cover">
            </picture>
            <div class="absolute inset-0 bg-gradient-to-r from-[#040f1e]/90 from-30% to-[#040f1e]/40"></div>
        </div>

        <!-- Background Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 z-0 bg-cover bg-center bg-no-repeat transition-all duration-1000"
                 :style="'background-image: linear-gradient(to right, rgba(4, 15, 30, 0.9) 30%, rgba(4, 15, 30, 0.4) 100%), url(' + slide.bg + ')'">
            </div>
        </template>

        <!-- Decorative background elements -->
        <div class="absolute right-[-60px] top-[50%] translate-y-[-50%] w-[480px] h-[480px] opacity-[0.07] border-2 border-gold rounded-full pointer-events-none hidden md:block z-10">
            <div class="absolute inset-[40px] border-2 border-gold rounded-full"></div>
            <div class="absolute inset-[80px] border-2 border-teal rounded-full"></div>
        </div>

        <!-- Content Container -->
        <div class="max-w-[1200px] mx-auto px-6 py-20 relative z-20 grid grid-cols-1 lg:grid-cols-[1fr_auto] gap-[60px] items-center w-full">
            
            <!-- Dynamic Slide Text (Server-Rendered Solid Slide 0 for Zero CLS & Instant LCP) -->
            <div class="min-h-[300px] flex flex-col justify-center">
                @foreach($slidesData as $index => $slide)
                    <div x-show="activeSlide === {{ $index }}"
                         @if($index !== 0)
                             style="display: none;"
                             x-transition:enter="transition ease-out duration-700 delay-300"
                             x-transition:enter-start="opacity-0 translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0"
                         @endif
                         class="space-y-5">
                        
                        <div class="inline-block bg-gold/20 border border-gold/40 text-gold text-xs font-semibold tracking-wider uppercase px-3.5 py-1.5 rounded-full">
                            {{ $slide['eyebrow'] }}
                        </div>
                        
                        <h1 class="font-prompt text-[clamp(26px,4vw,48px)] font-bold leading-tight">
                            <span>{{ $slide['titleTh'] }}</span><br>
                            <span class="text-gold">{{ $slide['titleHighlight'] }}</span><br>
                            <span>{{ $slide['titleThEnd'] }}</span>
                        </h1>
                        
                        <p class="text-base sm:text-lg text-white/80 font-light max-w-[520px] leading-relaxed">
                            {{ $slide['subtitle'] }}
                        </p>
                        
                        @if(!empty($slide['primaryBtnText']) || !empty($slide['secondaryBtnText']))
                            <div class="flex flex-wrap gap-3 pt-4">
                                @if(!empty($slide['primaryBtnText']))
                                    <a href="{{ $slide['primaryBtnUrl'] }}" class="btn-primary">
                                        {{ $slide['primaryBtnText'] }}
                                    </a>
                                @endif
                                @if(!empty($slide['secondaryBtnText']))
                                    <a href="{{ $slide['secondaryBtnUrl'] }}" class="btn-outline-white">
                                        {{ $slide['secondaryBtnText'] }}
                                    </a>
                                @endif
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>

            <!-- Stats Box (Right Side) -->
            <div class="grid grid-cols-3 lg:grid-cols-1 gap-2.5 sm:gap-4 w-full lg:w-[200px] animate-slide-up z-20">
                <div class="glass rounded-xl p-3 sm:p-5 text-center flex flex-col justify-center">
                    <div class="font-prompt text-xl sm:text-2xl lg:text-3xl font-bold text-gold leading-none mb-1 whitespace-nowrap">3</div>
                    <div class="text-[10px] sm:text-[11px] text-white/70 leading-snug">หลักสูตรที่เปิดสอน</div>
                </div>
                <div class="glass rounded-xl p-3 sm:p-5 text-center flex flex-col justify-center">
                    <div class="font-prompt text-xl sm:text-2xl lg:text-3xl font-bold text-gold leading-none mb-1 whitespace-nowrap">{{ $staffCount }}<span class="text-sm sm:text-base lg:text-lg font-bold">+</span></div>
                    <div class="text-[10px] sm:text-[11px] text-white/70 leading-snug">บุคลากรและอาจารย์</div>
                </div>
                <div class="glass rounded-xl p-3 sm:p-5 text-center flex flex-col justify-center">
                    <div class="font-prompt text-xl sm:text-2xl lg:text-3xl font-bold text-gold leading-none mb-1 whitespace-nowrap">95<span class="text-sm sm:text-base lg:text-lg font-bold">%</span></div>
                    <div class="text-[10px] sm:text-[11px] text-white/70 leading-snug">บัณฑิตได้งานใน 1 ปี</div>
                </div>
            </div>
        </div>

        <!-- Slider Pagination Dots -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex gap-3 z-30">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        class="w-3 h-3 rounded-full transition-all duration-300 cursor-pointer"
                        :class="activeSlide === index ? 'bg-gold w-8' : 'bg-white/40 hover:bg-white/60'"
                        :aria-label="'ไปยังสไลด์ที่ ' + (index + 1)">
                </button>
            </template>
        </div>

        <!-- Next/Prev Buttons (Desktop) -->
        <button @click="prev()" 
                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);"
                class="hidden md:flex w-10 h-10 rounded-full bg-black/20 hover:bg-black/40 items-center justify-center text-white border border-white/10 hover:border-white/30 z-30 transition-all cursor-pointer"
                aria-label="สไลด์ก่อนหน้า">
            ◀
        </button>
        <button @click="next()" 
                style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);"
                class="hidden md:flex w-10 h-10 rounded-full bg-black/20 hover:bg-black/40 items-center justify-center text-white border border-white/10 hover:border-white/30 z-30 transition-all cursor-pointer"
                aria-label="สไลด์ถัดไป">
            ▶
        </button>
    </section>

    <script>
        function slideshowComponent() {
            return {
                activeSlide: 0,
                slides: @json($slidesData),
                timer: null,
                next() {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                },
                prev() {
                    this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
                },
                init() {
                    // Delay auto-transition to keep initial Slide 0 solid for instant LCP
                    setTimeout(() => {
                        this.timer = setInterval(() => {
                            this.next();
                        }, 8000);
                    }, 5000);
                }
            };
        }
    </script>



    {{-- ── QUICK ACCESS BAR ── --}}
    <div class="bg-navy-dark text-white py-0 border-y border-white/5">
        <div class="max-w-[1200px] mx-auto grid grid-cols-2 md:grid-cols-4">
            <!-- 1. สำหรับผู้สนใจศึกษาต่อ -->
            <a href="{{ route('public.admission') }}" class="flex flex-col items-center gap-2 py-5 border-r border-white/5 hover:bg-white/5 transition-all text-center">
                <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center text-lg mb-1">🎓</div>
                <span class="text-xs font-semibold text-white/80 font-prompt">สำหรับผู้สนใจศึกษาต่อ</span>
            </a>
            <!-- 2. สำหรับนิสิต -->
            <a href="{{ route('services', ['target' => 'student']) }}" class="flex flex-col items-center gap-2 py-5 border-r border-white/5 hover:bg-white/5 transition-all text-center">
                <div class="w-10 h-10 rounded-lg bg-teal/30 flex items-center justify-center text-lg mb-1">✏️</div>
                <span class="text-xs font-semibold text-white/80 font-prompt">สำหรับนิสิตปัจจุบัน</span>
            </a>
            <!-- 3. สำหรับบุคลากร -->
            <a href="{{ route('services', ['target' => 'staff']) }}" class="flex flex-col items-center gap-2 py-5 border-r border-white/5 hover:bg-white/5 transition-all text-center">
                <div class="w-10 h-10 rounded-lg bg-gold/20 flex items-center justify-center text-lg mb-1">💼</div>
                <span class="text-xs font-semibold text-white/80 font-prompt">สำหรับบุคลากร</span>
            </a>
            <!-- 4. สำหรับผู้สนใจทั่วไป -->
            <a href="{{ route('services', ['target' => 'general']) }}" class="flex flex-col items-center gap-2 py-5 hover:bg-white/5 transition-all text-center">
                <div class="w-10 h-10 rounded-lg bg-purple-500/20 flex items-center justify-center text-lg mb-1">🌐</div>
                <span class="text-xs font-semibold text-white/80 font-prompt">สำหรับบุคคลทั่วไป</span>
            </a>
        </div>
    </div>

    {{-- ── SLIDING BANNERS SECTION ── --}}
    @if(isset($banners) && $banners->isNotEmpty())
    <section class="hidden lg:block bg-gray-50 border-b border-border-gray py-10" x-data="{ activeBanner: 0, totalBanners: {{ $banners->count() }} }" x-init="setTimeout(() => { setInterval(() => { activeBanner = (activeBanner + 1) % totalBanners }, 8000) }, 5000)">
        <div class="max-w-[1200px] mx-auto px-6 relative">
            <div style="height: 576px;" class="relative overflow-hidden rounded-2xl shadow-lg bg-[#07162B] group w-full">
                <!-- Slides Container -->
                @foreach($banners as $index => $banner)
                    @php
                        $img = $banner->image;
                        if (filter_var($img, FILTER_VALIDATE_URL)) {
                            $parsed = parse_url($img);
                            $img = $parsed['path'] ?? $img;
                        }
                        $cleanImg = ltrim(str_replace(['/V5/public/storage/', '/storage/'], '', $img), '/');
                        $webpImg = preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $cleanImg);
                        if (file_exists(public_path('storage/' . $webpImg))) {
                            $img = asset('storage/' . $webpImg);
                        } else {
                            $img = asset('storage/' . $cleanImg);
                        }
                        $hasLink = !empty($banner->link) && $banner->link !== '#';
                    @endphp
                    
                    @if($hasLink)
                        <a href="{{ $banner->link }}"
                    @else
                        <div
                    @endif
                         x-show="activeBanner === {{ $index }}"
                         x-transition:enter="transition ease-out duration-1000"
                         x-transition:enter-start="opacity-0 scale-102"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-500"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute inset-0 z-0 bg-cover bg-center bg-no-repeat transition-all duration-1000 block"
                         style="background-image: linear-gradient(to top, rgba(4, 15, 30, 0.3) 0%, rgba(4, 15, 30, 0) 100%), url('{{ $img }}');">
                         
                         @if(!empty($banner->title))
                             <!-- Optional Slide content overlay -->
                             <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10 bg-gradient-to-t from-black/60 to-transparent">
                                 <div class="font-prompt text-lg md:text-2.5xl font-bold text-white leading-tight drop-shadow-md">
                                     {{ $banner->title }}
                                 </div>
                             </div>
                         @endif
                         
                    @if($hasLink)
                        </a>
                    @else
                        </div>
                    @endif
                @endforeach

                <!-- Navigation Controls inside the box -->
                <button @click="activeBanner = (activeBanner - 1 + totalBanners) % totalBanners" 
                        aria-label="แบนเนอร์ก่อนหน้า"
                        style="position: absolute; left: 1.5rem; top: 50%; transform: translateY(-50%);"
                        class="w-10 h-10 rounded-full bg-black/30 hover:bg-black/50 text-white flex items-center justify-center text-xs border border-white/10 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer z-20">
                    ◀
                </button>
                <button @click="activeBanner = (activeBanner + 1) % totalBanners" 
                        aria-label="แบนเนอร์ถัดไป"
                        style="position: absolute; right: 1.5rem; top: 50%; transform: translateY(-50%);"
                        class="w-10 h-10 rounded-full bg-black/30 hover:bg-black/50 text-white flex items-center justify-center text-xs border border-white/10 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer z-20">
                    ▶
                </button>

                <!-- Navigation Dots -->
                <div class="absolute top-4 right-4 flex gap-2 z-20 bg-black/20 px-3 py-1.5 rounded-full backdrop-blur-sm">
                    @foreach($banners as $index => $banner)
                        <button @click="activeBanner = {{ $index }}" 
                                class="w-2 h-2 rounded-full transition-all duration-300 cursor-pointer"
                                :class="activeBanner === {{ $index }} ? 'bg-gold w-4' : 'bg-white/40 hover:bg-white/60'">
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ── COURSES SECTION ── --}}
    <section class="py-16 bg-off">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-10">
                <div>
                    <div class="section-eyebrow">หลักสูตรที่เปิดสอน</div>
                    <h2 class="section-title">เลือกเส้นทางของคุณ</h2>
                    <div class="gold-line"></div>
                </div>
                <a href="{{ route('programs') }}" class="text-sm font-semibold text-teal hover:underline whitespace-nowrap">ข้อมูลหลักสูตรทั้งหมด →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($programs as $program)
                    @php
                        $headerBg = 'background: linear-gradient(to right, ' . ($program->hero_color_from ?? '#064731') . ', ' . ($program->hero_color_to ?? '#0B2545') . ');';
                        if (!empty($program->hero_image)) {
                            $imgUrl = asset('storage/' . ltrim(str_replace('/storage/', '', $program->hero_image), '/'));
                            $headerBg = 'background: linear-gradient(to bottom, rgba(4, 15, 30, 0.2), rgba(4, 15, 30, 0.8)), url(\'' . $imgUrl . '\') center/cover no-repeat;';
                        }
                        
                        $icon = '🎓';
                        if ($program->slug === 'microbiology') { $icon = '🦠'; }
                        elseif ($program->slug === 'biochemistry') { $icon = '🧪'; }
                        elseif ($program->slug === 'nutrition') { $icon = '🥗'; }
                    @endphp
                    <a href="{{ route('programs.detail', $program->slug) }}" class="card card-hover overflow-hidden flex flex-col h-full bg-white rounded-2xl border border-border-gray shadow-sm">
                        <div class="h-40 relative p-5 flex flex-col justify-end text-white" style="{{ $headerBg }}">
                            <div class="absolute top-5 right-5 w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-2xl">{{ $icon }}</div>
                            <div class="text-[10px] text-white/70 tracking-wider uppercase font-bold">{{ $program->degree_abbr_en }}</div>
                            <h3 class="font-prompt text-base font-bold leading-snug">
                                {{ str_starts_with($program->title_th, 'หลักสูตร') ? str_replace('หลักสูตร', '', $program->title_th) : $program->title_th }}
                            </h3>
                        </div>
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <p class="text-xs text-muted font-light mb-5 line-clamp-3">
                                {{ $program->overview }}
                            </p>
                            <div class="flex gap-4 border-t border-border-gray pt-4 text-xs text-navy">
                                <span>⏱ <strong>{{ $program->duration_years ?? 4 }} ปี</strong></span>
                                <span>📚 <strong>{{ $program->credits }}</strong> หน่วยกิต</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── NEWS SECTION ── --}}
    <section class="py-16 bg-white">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-10">
                <div>
                    <div class="section-eyebrow">ข่าวสารล่าสุด</div>
                    <h2 class="section-title">ความเคลื่อนไหวของคณะ</h2>
                    <div class="gold-line"></div>
                </div>
            </div>

            <div class="w-full min-h-[680px] bg-gray-50 rounded-2xl flex items-center justify-center border border-gray-100" id="news-iframe-container">
                <iframe data-src="https://www.medsci.up.ac.th/msc_news/embed.php?type=news&category=all&show_tabs=1&limit=8&layout=grid&theme=light" 
                        title="ข่าวประชาสัมพันธ์และกิจกรรม คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา"
                        style="border:none; width:100%; height:620px; overflow:hidden;" 
                        scrolling="no" 
                        class="w-full rounded-2xl">
                </iframe>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var container = document.getElementById("news-iframe-container");
                    if (!container) return;
                    var iframe = container.querySelector("iframe");
                    if (!iframe) return;
                    var loadIframe = function() {
                        if (iframe.dataset.src) {
                            iframe.src = iframe.dataset.src;
                            iframe.removeAttribute("data-src");
                        }
                    };
                    if ("IntersectionObserver" in window) {
                        var observer = new IntersectionObserver(function(entries) {
                            entries.forEach(function(entry) {
                                if (entry.isIntersecting) {
                                    loadIframe();
                                    observer.disconnect();
                                }
                            });
                        }, { rootMargin: "300px" });
                        observer.observe(container);
                    } else {
                        loadIframe();
                    }
                });
            </script>

        </div>
    </section>

    {{-- ── SERVICES GRID SECTION ── --}}
    <section class="py-16 bg-off">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="mb-10">
                <div class="section-eyebrow">บริการออนไลน์</div>
                <h2 class="section-title">E-Service</h2>
                <div class="gold-line"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <a href="{{ route('booking.rooms') }}" target="_blank" class="card bg-white hover:border-teal hover:shadow-teal border border-border-gray p-6 text-center group shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-teal/10 flex items-center justify-center text-2xl mx-auto mb-4 group-hover:scale-110 transition-transform">📅</div>
                    <h3 class="text-sm font-bold text-navy mb-1 group-hover:text-teal transition-colors">จองห้องประชุม</h3>
                    <p class="text-[11px] text-muted">ตรวจสอบและจองห้องประชุมออนไลน์</p>
                </a>
                <a href="https://www.medsci.up.ac.th/room_booking/dashboard" target="_blank" class="card bg-white hover:border-teal hover:shadow-teal border border-border-gray p-6 text-center group shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-green-100 text-green-700 flex items-center justify-center text-2xl mx-auto mb-4 group-hover:scale-110 transition-transform">📚</div>
                    <h3 class="text-sm font-bold text-navy mb-1 group-hover:text-teal transition-colors">จอง Co-Learning Space</h3>
                    <p class="text-[11px] text-muted">พื้นที่ทำงานกลุ่มสำหรับนิสิต</p>
                </a>
                <a href="{{ route('services.car-schedule') }}" class="card bg-white hover:border-teal hover:shadow-teal border border-border-gray p-6 text-center group shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-2xl mx-auto mb-4 group-hover:scale-110 transition-transform">🚐</div>
                    <h3 class="text-sm font-bold text-navy mb-1 group-hover:text-teal transition-colors">ตารางใช้รถ</h3>
                    <p class="text-[11px] text-muted">ตรวจสอบสถานะและคิวรถตู้คณะ</p>
                </a>
                <a href="{{ route('downloads.index') }}" class="card bg-white hover:border-teal hover:shadow-teal border border-border-gray p-6 text-center group shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-2xl mx-auto mb-4 group-hover:scale-110 transition-transform">📄</div>
                    <h3 class="text-sm font-bold text-navy mb-1 group-hover:text-teal transition-colors">ดาวน์โหลดแบบฟอร์ม</h3>
                    <p class="text-[11px] text-muted">แบบฟอร์มเอกสารต่าง ๆ</p>
                </a>
            </div>
        </div>
    </section>

    {{-- ── STATS BAND ── --}}
    <section class="bg-stats-gradient py-12 text-white">
        <div class="max-w-[1200px] mx-auto px-6 grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center p-4 border-r border-white/10 last:border-0">
                <div class="font-prompt text-4xl font-bold text-gold mb-1 leading-none">
                    {{ $yearsOfExcellence }}<span class="text-2xl font-normal">+</span>
                </div>
                <div class="text-xs text-white/70 font-light uppercase tracking-wide">ปีแห่งความเป็นเลิศ</div>
            </div>
            <div class="text-center p-4 border-r border-white/10 last:border-0">
                <div class="font-prompt text-4xl font-bold text-gold mb-1 leading-none">
                    {{ $staffCount }}<span class="text-2xl font-normal">+</span>
                </div>
                <div class="text-xs text-white/70 font-light uppercase tracking-wide">คณาจารย์และบุคลากร</div>
            </div>
            <div class="text-center p-4 border-r border-white/10 last:border-0">
                <div class="font-prompt text-4xl font-bold text-gold mb-1 leading-none">
                    {{ $alumniCount }}<span class="text-2xl font-normal">+</span>
                </div>
                <div class="text-xs text-white/70 font-light uppercase tracking-wide">บัณฑิตสำเร็จการศึกษา</div>
            </div>
            <div class="text-center p-4 last:border-0">
                <div class="font-prompt text-4xl font-bold text-gold mb-1 leading-none">
                    {{ $researchCount }}<span class="text-2xl font-normal">+</span>
                </div>
                <div class="text-xs text-white/70 font-light uppercase tracking-wide">ผลงานตีพิมพ์วิจัย</div>
            </div>
        </div>
    </section>

    {{-- ── RESEARCH & INNOVATION EMBED ── --}}
    <section class="py-16 bg-off border-t border-border-gray/40">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8">
                <div>
                    <div class="section-eyebrow">งานวิจัยและนวัตกรรม</div>
                    <h2 class="section-title">ข้อมูลผลงานวิจัย คณะวิทยาศาสตร์การแพทย์</h2>
                    <div class="gold-line"></div>
                </div>
                <a href="https://www.medsci.up.ac.th/msc_researchV2/" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold text-teal hover:underline whitespace-nowrap flex items-center gap-1.5 font-prompt">
                    <span>ระบบข้อมูลงานวิจัย</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>

            <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-border-gray/80 overflow-hidden">
                <!-- MSC Research Embed Widget -->
                <iframe class="msc-research-widget w-full" src="https://www.medsci.up.ac.th/msc_researchV2/embed.php?type=stats_recent&theme=light&limit=3" width="100%" height="600" frameborder="0" style="border:none; width:100%; overflow:hidden;"></iframe>
                <script src="https://www.medsci.up.ac.th/msc_researchV2/embed.js"></script>
            </div>
        </div>
    </section>

    {{-- ── FEATURED VIDEO & CALENDAR ── --}}
    <section class="py-16 bg-white border-t border-border-gray/40">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-10">
                <div>
                    <div class="section-eyebrow">สื่อประชาสัมพันธ์และกิจกรรม</div>
                    <h2 class="section-title">วิดีโอแนะนำคณะและปฏิทินกิจกรรม</h2>
                    <div class="gold-line"></div>
                </div>
                <a href="{{ route('calendar.index') }}" class="text-sm font-semibold text-teal hover:underline whitespace-nowrap">
                    ดูปฏิทินกิจกรรมทั้งหมด →
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                {{-- YouTube Video Column --}}
                <div class="card p-6 md:p-8 shadow-sm bg-white rounded-2xl border border-border-gray flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2.5 mb-5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-2.5 h-2.5 rounded-full bg-gold"></div>
                                <h3 class="font-prompt text-base md:text-lg font-bold text-navy">🎬 วิดีโอแนะนำคณะ</h3>
                            </div>
                            <span class="text-[11px] text-muted font-medium bg-off px-2.5 py-1 rounded-full border border-border-gray">MedSci Video</span>
                        </div>
                        
                        <!-- YouTube Facade (Zero initial JS / CSS / Cookies) -->
                        <div class="relative w-full overflow-hidden rounded-2xl shadow-md border border-gray-100 bg-black group cursor-pointer" 
                             style="padding-top: 56.25%;" 
                             id="yt-video-facade"
                             onclick="this.innerHTML='<iframe src=\'https://www.youtube-nocookie.com/embed/yPIDkt8P9SQ?autoplay=1\' title=\'วิดีโอแนะนำคณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา\' style=\'position:absolute;top:0;left:0;width:100%;height:100%;border:0;\' allow=\'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\' allowfullscreen class=\'rounded-2xl\'></iframe>';">
                            
                            <!-- Video Thumbnail Image -->
                            <img src="https://i.ytimg.com/vi/yPIDkt8P9SQ/hqdefault.jpg" 
                                 alt="วิดีโอแนะนำคณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา" 
                                 loading="lazy"
                                 decoding="async"
                                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                            
                            <!-- Dark Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20"></div>

                            <!-- Play Button Overlay -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-red-600/90 text-white flex items-center justify-center shadow-2xl group-hover:bg-red-600 group-hover:scale-110 transition-all duration-300">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10 fill-current translate-x-0.5" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="absolute bottom-3 left-4 right-4 text-white text-xs font-medium drop-shadow">
                                คลิกเพื่อเล่นวิดีโอแนะนำคณะ
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-border-gray/60 flex items-center justify-between text-xs text-muted font-prompt">
                        <span>คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</span>
                        <a href="https://www.youtube.com/watch?v=yPIDkt8P9SQ" target="_blank" class="text-teal hover:underline font-semibold flex items-center gap-1">
                            <span>ดูบน YouTube</span> ↗
                        </a>
                    </div>
                </div>

                {{-- Calendar Column (Embedded Calendar Iframe) --}}
                <div class="card p-6 md:p-8 shadow-sm bg-white rounded-2xl border border-border-gray flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2.5 mb-5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-2.5 h-2.5 rounded-full bg-gold"></div>
                                <h3 class="font-prompt text-base md:text-lg font-bold text-navy">📅 ปฏิทินกิจกรรม</h3>
                            </div>
                            <a href="{{ route('calendar.index') }}" class="text-xs text-teal hover:underline font-semibold font-prompt">
                                เปิดปฏิทินเต็มจอ →
                            </a>
                        </div>
                        
                        <div class="w-full min-h-[510px] bg-gray-50 rounded-2xl flex items-center justify-center border border-gray-100" id="calendar-iframe-container">
                            <iframe data-src="https://www.medsci.up.ac.th/msc_news/embed.php?type=calendar&limit=5&layout=list&theme=purple" 
                                    title="ปฏิทินกิจกรรม คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา"
                                    style="border:none; width:100%; height:510px; overflow:hidden;" 
                                    scrolling="no" 
                                    class="w-full rounded-2xl">
                            </iframe>
                        </div>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                var calContainer = document.getElementById("calendar-iframe-container");
                                if (!calContainer) return;
                                var calIframe = calContainer.querySelector("iframe");
                                if (!calIframe) return;
                                var loadCalIframe = function() {
                                    if (calIframe.dataset.src) {
                                        calIframe.src = calIframe.dataset.src;
                                        calIframe.removeAttribute("data-src");
                                    }
                                };
                                if ("IntersectionObserver" in window) {
                                    var calObserver = new IntersectionObserver(function(entries) {
                                        entries.forEach(function(entry) {
                                            if (entry.isIntersecting) {
                                                loadCalIframe();
                                                calObserver.disconnect();
                                            }
                                        });
                                    }, { rootMargin: "300px" });
                                    calObserver.observe(calContainer);
                                } else {
                                    loadCalIframe();
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>

