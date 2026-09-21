<x-public-layout>
    <x-slot name="title">ตารางปฏิบัติงานสำนักงานฯ - คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</x-slot>

    {{-- ── HERO SECTION ── --}}
    <div class="relative py-16 md:py-20 text-white overflow-hidden bg-navy border-b border-white/10">
        {{-- Dark brand color overlay gradient --}}
        <div class="absolute inset-0 bg-gradient-to-r from-[#07162B] to-[#0B2545] z-0"></div>
        
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="space-y-3">
                    {{-- Breadcrumbs --}}
                    <div class="flex items-center gap-2 text-xs text-gold font-semibold uppercase tracking-wider">
                        <a href="{{ route('home') }}" class="hover:underline transition-all">หน้าแรก</a>
                        <span class="text-white/40">/</span>
                        <a href="{{ route('contact') }}" class="hover:underline transition-all">ติดต่อเรา</a>
                        <span class="text-white/40">/</span>
                        <span class="text-white/80">ตารางปฏิบัติงานสำนักงานฯ</span>
                    </div>
                    
                    {{-- Title --}}
                    <h1 class="font-prompt text-3xl md:text-4xl font-bold tracking-tight text-white leading-tight">
                        ตารางปฏิบัติงานสำนักงานฯ
                    </h1>
                    
                    {{-- Gold separator --}}
                    <div class="w-16 h-1 bg-gold rounded-full"></div>
                    
                    {{-- Description --}}
                    <p class="text-white/80 font-light text-sm md:text-base max-w-2xl leading-relaxed">
                        ตรวจสอบสถานะและตารางการปฏิบัติงานของบุคลากรสายสนับสนุน สำนักงานคณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
                    </p>
                </div>

                {{-- Action Button --}}
                <a href="https://www.medsci.up.ac.th/office_status/" 
                   target="_blank" 
                   rel="noopener"
                   class="bg-gold hover:bg-gold-light text-navy font-bold px-5 py-3 rounded-xl transition-all shadow-lg shadow-gold/20 shrink-0 flex items-center gap-2 group text-xs md:text-sm">
                    <span>📋</span>
                    <span>เปิดระบบเต็มจอ (Office Status)</span>
                    <span class="group-hover:translate-x-1 transition-transform">↗</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ── MAIN CONTENT SECTION ── --}}
    <div class="bg-off py-12">
        <div class="max-w-[1200px] mx-auto px-6 space-y-8">
            
            {{-- Navigation & Quick Notice Bar --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-xl border border-border-gray text-xs shadow-sm">
                <div class="flex items-center gap-2">
                    <a href="{{ route('contact') }}" class="text-teal hover:underline font-semibold flex items-center gap-1 font-prompt">
                        ← กลับไปหน้าติดต่อเรา
                    </a>
                </div>
                <div class="text-muted font-light">
                    * ข้อมูลสถานะการปฏิบัติงาน (ปฏิบัติงาน / ลา / ไปราชการ) จะอัปเดตแบบ Real-time ตามระบบของสำนักงานฯ
                </div>
            </div>

            {{-- Embed Container --}}
            <div class="bg-white p-3 md:p-6 rounded-2xl border border-border-gray shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-border-gray/60">
                    <div class="flex items-center gap-2.5">
                        <div class="w-2.5 h-2.5 rounded-full bg-teal"></div>
                        <h2 class="font-prompt text-base md:text-lg font-bold text-navy">
                            ระบบแสดงสถานะการปฏิบัติงานบุคลากรสำนักงานคณะฯ
                        </h2>
                    </div>
                    <span class="text-[11px] text-muted font-medium bg-off px-3 py-1 rounded-full border border-border-gray font-prompt hidden sm:inline-block">
                        Real-time Status
                    </span>
                </div>

                <div class="w-full overflow-hidden rounded-xl bg-gray-50 border border-gray-100">
                    <iframe id="office-status-iframe"
                            src="https://www.medsci.up.ac.th/office_status/embed.php?mode=week" 
                            width="100%" 
                            height="1200" 
                            frameborder="0" 
                            scrolling="no"
                            style="border:0; width:100%; height:1200px; overflow:hidden; display:block; transition: height 0.2s ease;" 
                            allowfullscreen
                            class="w-full rounded-xl">
                    </iframe>
                </div>
                <script>
                    (function() {
                        var iframe = document.getElementById('office-status-iframe');
                        if (!iframe) return;

                        function setHeight(h) {
                            if (h && h > 200) {
                                iframe.style.height = (parseInt(h, 10) + 15) + 'px';
                            }
                        }

                        // 1. Listen to postMessage from embed
                        window.addEventListener('message', function(event) {
                            if (event.data && (event.data.type === 'office_status_resize' || event.data.type === 'msc-widget-resize')) {
                                setHeight(event.data.height);
                            }
                        });

                        // 2. Direct same-origin fallback
                        function checkSameOriginHeight() {
                            try {
                                var doc = iframe.contentDocument || iframe.contentWindow.document;
                                if (doc && doc.body) {
                                    var content = doc.querySelector('.embed-content');
                                    var h = content ? (content.offsetTop + content.offsetHeight + 25) : Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight);
                                    setHeight(h);
                                }
                            } catch (e) {}
                        }

                        iframe.addEventListener('load', function() {
                            checkSameOriginHeight();
                            setTimeout(checkSameOriginHeight, 200);
                            setTimeout(checkSameOriginHeight, 600);
                            setTimeout(checkSameOriginHeight, 1500);
                        });

                        window.addEventListener('resize', function() {
                            checkSameOriginHeight();
                        });
                    })();
                </script>
            </div>

            {{-- Dean's Office Contact Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card p-6 bg-white shadow-sm border border-border-gray rounded-2xl flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl shrink-0 border border-blue-100">
                        📍
                    </div>
                    <div>
                        <h3 class="font-prompt font-bold text-navy text-sm mb-1">ที่ตั้งสำนักงาน</h3>
                        <p class="text-xs text-muted font-light leading-relaxed">
                            สำนักงานคณะวิทยาศาสตร์การแพทย์ อาคารเรียนรวม มหาวิทยาลัยพะเยา 19 หมู่ 2 ต.แม่กา อ.เมือง จ.พะเยา 56000
                        </p>
                    </div>
                </div>

                <div class="card p-6 bg-white shadow-sm border border-border-gray rounded-2xl flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl shrink-0 border border-emerald-100">
                        📞
                    </div>
                    <div>
                        <h3 class="font-prompt font-bold text-navy text-sm mb-1">โทรศัพท์ติดต่อ</h3>
                        <p class="text-xs text-muted font-light leading-relaxed">
                            โทรศัพท์กลาง: 054-466-666 ต่อ 3811 - 3812
                        </p>
                    </div>
                </div>

                <div class="card p-6 bg-white shadow-sm border border-border-gray rounded-2xl flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl shrink-0 border border-amber-100">
                        ✉️
                    </div>
                    <div>
                        <h3 class="font-prompt font-bold text-navy text-sm mb-1">ช่องทางออนไลน์</h3>
                        <p class="text-xs text-muted font-light leading-relaxed">
                            อีเมล: medsci@up.ac.th<br>
                            Facebook: คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-public-layout>