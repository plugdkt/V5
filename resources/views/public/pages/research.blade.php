<x-public-layout>
    <x-slot name="title">งานวิจัยและนวัตกรรม</x-slot>

    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <h1 class="font-prompt text-3xl font-bold mb-1">
                งานวิจัยและนวัตกรรม
            </h1>
            <p class="text-white/70 font-light text-sm">
                การขับเคลื่อนงานวิจัยทางวิทยาศาสตร์การแพทย์และนวัตกรรมสุขภาพ คณะวิทยาศาสตร์การแพทย์
            </p>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12 space-y-10">
        {{-- Research Themes --}}
        <div class="bg-white rounded-2xl border border-border-gray p-6 md:p-10 shadow-sm space-y-6">
            <h2 class="font-prompt text-xl font-bold text-navy border-b border-border-gray pb-3">กลุ่มงานวิจัยและนวัตกรรมหลัก</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm font-light text-muted">
                <div class="border border-border-gray p-6 rounded-xl space-y-2">
                    <span class="text-2xl">🦠</span>
                    <h3 class="font-prompt font-bold text-navy text-base">โรคติดเชื้อและจุลชีววิทยาประยุกต์</h3>
                    <p>การศึกษาเชื้อก่อโรค กลไกการดื้อยา การพัฒนาสารสกัดสมุนไพรในการยับยั้งเชื้อแบคทีเรียและเชื้อราก่อโรค</p>
                </div>
                
                <div class="border border-border-gray p-6 rounded-xl space-y-2">
                    <span class="text-2xl">🧪</span>
                    <h3 class="font-prompt font-bold text-navy text-base">การค้นพบยาและฤทธิ์ทางชีวภาพของสารธรรมชาติ</h3>
                    <p>การคัดกรองสารสกัดจากพืชสมุนไพรท้องถิ่นในการต้านมะเร็ง ต้านอนุมูลอิสระ และการป้องกันโรคเรื้อรัง</p>
                </div>

                <div class="border border-border-gray p-6 rounded-xl space-y-2">
                    <span class="text-2xl">🥗</span>
                    <h3 class="font-prompt font-bold text-navy text-base">โภชนบำบัดเชิงลึกและการกำหนดอาหารเฉพาะโรค</h3>
                    <p>งานวิจัยด้านการพัฒนาผลิตภัณฑ์อาหารสุขภาพสำหรับผู้สูงอายุ ผู้ป่วยเบาหวาน และโรคไต</p>
                </div>

                <div class="border border-border-gray p-6 rounded-xl space-y-2">
                    <span class="text-2xl">🧠</span>
                    <h3 class="font-prompt font-bold text-navy text-base">สรีรวิทยาประยุกต์และวิทยาศาสตร์สุขภาพเชิงป้องกัน</h3>
                    <p>สรีรวิทยาการออกกำลังกาย กลไกความชรา และพฤติกรรมสุขภาพที่ช่วยป้องกันโรคไม่ติดต่อเรื้อรัง (NCDs)</p>
                </div>
            </div>
        </div>

        {{-- Statistics Summary --}}
        <div class="bg-stats-gradient rounded-2xl p-8 text-white grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            <div>
                <div class="font-prompt text-4xl font-bold text-gold leading-none mb-1">370+</div>
                <div class="text-xs text-white/70">ผลงานวิจัยที่ตีพิมพ์ระดับนานาชาติ</div>
            </div>
            <div>
                <div class="font-prompt text-4xl font-bold text-gold leading-none mb-1">15+</div>
                <div class="text-xs text-white/70">สิทธิบัตร/อนุสิทธิบัตรที่ขึ้นทะเบียน</div>
            </div>
            <div>
                <div class="font-prompt text-4xl font-bold text-gold leading-none mb-1">50+ ล้าน</div>
                <div class="text-xs text-white/70">ทุนวิจัยที่ได้รับสนับสนุนจากภายนอก</div>
            </div>
        </div>
    </div>
</x-public-layout>
