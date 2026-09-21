<x-public-layout>
    <x-slot name="title">อินทราเน็ตบุคลากร Intranet</x-slot>

    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <h1 class="font-prompt text-3xl font-bold mb-1">
                อินทราเน็ต (Intranet)
            </h1>
            <p class="text-white/70 font-light text-sm">
                ระบบเครือข่ายภายในเฉพาะสำหรับบุคลากร คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
            </p>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12">
        <div class="bg-white rounded-2xl border border-border-gray p-8 shadow-sm max-w-xl mx-auto text-center space-y-6">
            <div class="text-5xl">🔒</div>
            <h2 class="font-prompt text-xl font-bold text-navy">ต้องเข้าใช้งานผ่านเครือข่ายของมหาวิทยาลัยพะเยา</h2>
            <p class="text-sm font-light text-muted leading-relaxed">
                ระบบอินทราเน็ตจำกัดการเข้าถึงเฉพาะผู้ที่เชื่อมต่อเครือข่ายภายในมหาวิทยาลัยพะเยา (UP Wi-Fi / LAN) หรือเชื่อมต่อผ่านระบบ VPN ของมหาวิทยาลัยเท่านั้น
            </p>
            <div class="flex flex-col gap-3 pt-4">
                <a href="https://sso.up.ac.th" class="btn-primary w-full py-3">
                    เข้าสู่ระบบ Single Sign-On (UP M365)
                </a>
                <a href="https://www.citcoms.up.ac.th/" target="_blank" class="text-xs text-teal hover:underline font-semibold">
                    วิธีเชื่อมต่อ VPN มหาวิทยาลัยพะเยา (CITCOMS) →
                </a>
            </div>
        </div>
    </div>
</x-public-layout>
