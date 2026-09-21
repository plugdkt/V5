<x-public-layout>
    <x-slot name="title">ตารางใช้รถยนต์และรถตู้คณะ</x-slot>

    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <div class="text-[11px] text-gold uppercase tracking-wider font-bold mb-1">E-Service & Utilities</div>
                <h1 class="font-prompt text-3xl font-bold mb-1">
                    ตารางใช้รถตู้คณะฯ
                </h1>
                <p class="text-white/70 font-light text-sm">
                    ตรวจสอบวันเวลาการใช้รถตู้ ของคณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
                </p>
            </div>
            
            <a href="https://www.medsci.up.ac.th/msc_acc/sso/login.php?client_id=car_booking&redirect_uri=https%3A%2F%2Fwww.medsci.up.ac.th%2Fcar_booking%2Fsso%2Fcallback.php" 
               target="_blank" 
               class="bg-gold hover:bg-gold-light text-navy font-bold px-6 py-3 rounded-xl transition-all shadow-lg shadow-gold/20 shrink-0 flex items-center gap-2 group transform hover:-translate-y-0.5">
                <span>🚐</span> 
                <span>กดเพื่อจองใช้รถตู้ (ระบบจองรถ)</span> 
                <span class="group-hover:translate-x-1 transition-transform">→</span>
            </a>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-10 space-y-6">
        {{-- Navigation & Quick Help Info --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-off p-4 rounded-xl border border-border-gray text-xs">
            <div class="flex items-center gap-2">
                <a href="{{ route('services') }}" class="text-teal hover:underline font-semibold flex items-center gap-1">
                    ← กลับไปที่ศูนย์บริการ E-Service
                </a>
            </div>
            <div class="text-muted font-light">
                * หากต้องการยื่นใบคำขอจองใช้รถ กรุณากดปุ่มสีทอง <strong>"กดเพื่อจองใช้รถตู้"</strong> ด้านบนขวาเพื่อล็อกอินเข้าระบบ
            </div>
        </div>

       

        {{-- Calendar Embed Container --}}
        <div class="bg-white p-2 md:p-4 rounded-2xl border border-border-gray shadow-sm">
            <div class="w-full overflow-hidden rounded-xl">
                <iframe src="https://www.medsci.up.ac.th/car_booking/calendar_embed.php" 
                        width="100%" 
                        height="700px" 
                        style="border:none; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
                </iframe>
            </div>
        </div>
        {{-- Warning Notice Box & Form Download for External Personnel --}}
        <div class="bg-amber-50 border border-amber-200/80 rounded-2xl p-5 md:p-6 text-xs text-amber-900 space-y-4 shadow-sm">
            <div class="font-bold flex items-center gap-2 text-sm text-amber-950 font-prompt">
                <span class="text-base">⚠️</span> หมายเหตุสำคัญการจองใช้รถตู้:
            </div>
            <ul class="list-disc pl-5 space-y-1.5 font-medium leading-relaxed text-amber-900">
                <li>ระบบการจองออนไลน์นี้ให้บริการ <strong class="text-amber-950 font-bold">เฉพาะบุคลากร คณะวิทยาศาสตร์การแพทย์ เท่านั้น</strong></li>
                <li>บุคลากรภายนอกคณะที่ประสงค์จะจองใช้รถ กรุณาติดต่อ <strong class="text-amber-950 font-bold">คุณฌัชกานต์ (กบ) หมายเลขภายใน 3811</strong> เพื่อประสานงานการจองใช้รถโดยตรง</li>
            </ul>

            {{-- Download Card for External Personnel Form --}}
            <div class="mt-3 pt-4 border-t border-amber-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white/80 p-4 rounded-xl border border-amber-200 shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-xl shrink-0 border border-blue-100">
                        📄
                    </div>
                    <div>
                        <div class="font-bold text-navy text-xs font-prompt">แบบฟอร์มขออนุมัติใช้รถยนต์ส่วนกลาง (สำหรับบุคลากรภายนอกคณะ)</div>
                        <div class="text-[11px] text-muted mt-0.5">ไฟล์แบบฟอร์มเอกสาร Microsoft Word (.docx)</div>
                    </div>
                </div>
                <a href="{{ asset('storage/medsci_doc/car_booking_3.docx') }}" 
                   download="แบบฟอร์มขออนุมัติใช้รถยนต์ส่วนกลาง_สำหรับบุคลากรภายนอกคณะ.docx"
                   class="inline-flex items-center gap-2 bg-[#07192E] hover:bg-navy-light text-white font-medium px-4 py-2.5 rounded-lg text-xs transition-all shadow-sm shrink-0">
                    <span>📥</span>
                    <span>ดาวน์โหลดแบบฟอร์ม (.DOCX)</span>
                </a>
            </div>
        </div>
        
    </div>
</x-public-layout>
