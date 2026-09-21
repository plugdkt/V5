<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-prompt text-lg font-bold text-navy">🖼️ จัดการแบนเนอร์ประชาสัมพันธ์หน้าหลัก</h2>
        @if(!$isFormOpen)
            <button wire:click="openForm()" class="bg-gold text-navy font-bold px-4 py-2 text-xs rounded-lg hover:bg-gold-light cursor-pointer shadow-md shadow-gold/10">
                ➕ เพิ่มแบนเนอร์ใหม่
            </button>
        @endif
    </div>

    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-xs mb-6">
            {{ session('message') }}
        </div>
    @endif

    @if(!$isFormOpen)
        {{-- Search & Table List --}}
        <div class="bg-white rounded-2xl border border-border-gray shadow-sm p-4 space-y-4">
            <div class="flex gap-2">
                <input type="text" wire:model.live="search" class="form-input text-xs" placeholder="ค้นหาชื่อแบนเนอร์...">
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-border-gray text-navy font-bold">
                            <th class="p-3 w-32 text-center">ภาพแบนเนอร์</th>
                            <th class="p-3">หัวข้อประชาสัมพันธ์</th>
                            <th class="p-3">ลิงก์ปลายทาง</th>
                            <th class="p-3 w-20 text-center">ลำดับ</th>
                            <th class="p-3 w-24 text-center">สถานะ</th>
                            <th class="p-3 w-32 text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-gray text-navy">
                        @forelse($bannersList as $bn)
                            <tr class="hover:bg-off/50">
                                <td class="p-3 text-center">
                                    <img src="{{ asset('storage/' . ltrim(str_replace('/storage/', '', $bn->image), '/')) }}" class="w-24 h-12 object-cover rounded border border-border-gray mx-auto">
                                </td>
                                <td class="p-3 font-semibold">
                                    {{ $bn->title }}
                                </td>
                                <td class="p-3 text-muted break-all">
                                    {{ $bn->link }}
                                </td>
                                <td class="p-3 text-center font-bold">
                                    {{ $bn->order }}
                                </td>
                                <td class="p-3 text-center">
                                    <span class="px-2 py-0.5 rounded-full font-bold text-[9px] {{ $bn->active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                                        {{ $bn->active ? 'เปิดใช้งาน' : 'ปิดการใช้งาน' }}
                                    </span>
                                </td>
                                <td class="p-3 text-center space-x-1 whitespace-nowrap">
                                    <button wire:click="openForm({{ $bn->id }})" class="bg-teal text-white px-2.5 py-1.5 rounded-lg font-bold hover:bg-teal-dark cursor-pointer">
                                        แก้ไข
                                    </button>
                                    <button onclick="confirm('ยืนยันที่จะลบแบนเนอร์นี้หรือไม่?') || event.stopImmediatePropagation()" 
                                            wire:click="deleteBanner({{ $bn->id }})" 
                                            class="bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 cursor-pointer">
                                        ลบ
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-muted">ไม่พบข้อมูลแบนเนอร์ประชาสัมพันธ์ในระบบ</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $bannersList->links() }}
            </div>
        </div>
    @else
        {{-- Form Editor --}}
        <div class="bg-white rounded-2xl border border-border-gray shadow-sm p-6 space-y-6">
            <div class="flex justify-between items-center border-b border-border-gray pb-4">
                <h3 class="font-prompt text-base font-bold text-navy">
                    {{ $bannerId ? '📝 แก้ไขแบนเนอร์ประชาสัมพันธ์' : '✨ เพิ่มแบนเนอร์ประชาสัมพันธ์ใหม่' }}
                </h3>
                <button wire:click="closeForm()" class="text-xs text-muted hover:text-navy cursor-pointer">✕ ยกเลิก</button>
            </div>

            <form wire:submit.prevent="saveBanner" class="space-y-4 text-xs text-navy">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">หัวข้อประชาสัมพันธ์ (ไม่จำเป็นต้องระบุ)</label>
                        <input type="text" wire:model="title" class="form-input" placeholder="เช่น ยินดีต้อนรับสู่คณะวิทยาศาสตร์การแพทย์ (ถ้าเว้นว่างจะไม่แสดงข้อความทับรูป)">
                    </div>

                    <div>
                        <label class="form-label">ลำดับการแสดงผล *</label>
                        <input type="number" wire:model="order" class="form-input" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">เส้นทางรูปภาพ (เก็บในระบบจัดการสื่อ) *</label>
                        <div class="flex gap-2">
                            <input type="text" id="banner_image_input" wire:model="image" class="form-input" placeholder="เช่น storage/media/banner_campus.png" required>
                            <button type="button" onclick="openBannerPhotoPicker()" class="bg-teal text-white px-4 py-2 font-bold rounded-lg hover:bg-teal-dark cursor-pointer whitespace-nowrap">
                                📂 เลือกรูปภาพ
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">ลิงก์ปลายทาง (เมื่อกดแบนเนอร์)</label>
                        <input type="text" wire:model="link" class="form-input" placeholder="เช่น /about หรือ https://reg.up.ac.th">
                    </div>
                </div>

                <div>
                    <label class="form-label">สถานะแบนเนอร์ *</label>
                    <select wire:model="active" class="form-select" required>
                        <option value="1">เปิดการใช้งาน (Active)</option>
                        <option value="0">ปิดการใช้งาน (Inactive)</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 border-t border-border-gray pt-4">
                    <button type="button" wire:click="closeForm()" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-bold hover:bg-gray-200 cursor-pointer">
                        ✕ ยกเลิก
                    </button>
                    <button type="submit" class="bg-gold text-navy px-6 py-2 rounded-lg font-bold hover:bg-gold-light cursor-pointer shadow-md shadow-gold/10">
                        💾 บันทึกข้อมูลแบนเนอร์
                    </button>
                </div>
            </form>
        </div>
    @endif

    <script>
        function openBannerPhotoPicker() {
            const width = 850;
            const height = 600;
            const left = (screen.width - width) / 2;
            const top = (screen.height - height) / 2;
            window.open('{{ route('admin.media.picker') }}', 'BannerPhotoPicker', `width=${width},height=${height},left=${left},top=${top},scrollbars=yes`);
        }

        window.selectPdfPath = function(url) {
            const bannerInput = document.getElementById('banner_image_input');
            if (bannerInput) {
                let path = url;
                if (path.includes('/storage/')) {
                    path = path.split('/storage/')[1];
                } else if (path.includes('storage/')) {
                    path = path.split('storage/')[1];
                }
                path = path.replace(/^\/+/, '');
                
                bannerInput.value = path;
                bannerInput.dispatchEvent(new Event('input'));
            }
        };
    </script>
</div>
