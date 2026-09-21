<x-public-layout>
    <x-slot name="title">โครงสร้างองค์กร</x-slot>

    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <h1 class="font-prompt text-3xl font-bold mb-1">
                โครงสร้างองค์กร
            </h1>
            <p class="text-white/70 font-light text-sm">
                โครงสร้างการบริหารงาน คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
            </p>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12">
        <div class="bg-white rounded-2xl border border-border-gray p-6 md:p-10 shadow-sm text-center">
            <h2 class="font-prompt text-xl font-bold text-navy mb-8">แผนผังโครงสร้างการบริหารคณะวิทยาศาสตร์การแพทย์</h2>
            
            {{-- Simple chart structure using styled boxes --}}
            <div class="flex flex-col items-center gap-8 max-w-2xl mx-auto">
                <div class="bg-navy text-white px-6 py-3 rounded-lg shadow-md font-semibold text-sm">
                    คณบดีคณะวิทยาศาสตร์การแพทย์
                </div>
                
                <div class="w-0.5 h-8 bg-border-gray"></div>
                
                <div class="bg-gold text-navy px-6 py-3 rounded-lg shadow-md font-semibold text-sm">
                    คณะกรรมการประจำคณะ
                </div>

                <div class="w-0.5 h-8 bg-border-gray"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full">
                    <div class="border border-border-gray p-4 rounded-xl flex flex-col items-center gap-3">
                        <div class="bg-teal text-white px-4 py-2 rounded-lg font-semibold text-xs mb-2">
                            ฝ่ายบริหารและบริการวิชาการ
                        </div>
                        <span class="text-xs text-muted">งานบริหารงานทั่วไป</span>
                        <span class="text-xs text-muted">งานบริการวิชาการและวิจัย</span>
                        <span class="text-xs text-muted">งานแผนงานและคลัง</span>
                    </div>

                    <div class="border border-border-gray p-4 rounded-xl flex flex-col items-center gap-3">
                        <div class="bg-teal text-white px-4 py-2 rounded-lg font-semibold text-xs mb-2">
                            ฝ่ายวิชาการและสาขาวิชา
                        </div>
                        <span class="text-xs text-muted">สาขาวิชาจุลชีววิทยาและปรสิตวิทยา</span>
                        <span class="text-xs text-muted">สาขาวิชาชีวเคมี</span>
                        <span class="text-xs text-muted">สาขาวิชาโภชนาการและการกำหนดอาหาร</span>
                        <span class="text-xs text-muted">กลุ่มวิชากายวิภาคศาสตร์และสรีรวิทยา</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
