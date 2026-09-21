<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-prompt text-lg font-bold text-navy">🖼️ จัดการภาพสไลด์โชว์หน้าแรก</h2>
        @if(!$isFormOpen)
            <button wire:click="openForm()" class="bg-gold text-navy font-bold px-4 py-2 text-xs rounded-lg hover:bg-gold-light cursor-pointer shadow-md shadow-gold/10">
                ➕ เพิ่มสไลด์ใหม่
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
                <input type="text" wire:model.live="search" class="form-input text-xs" placeholder="ค้นหาคำพาดหัวในสไลด์...">
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-border-gray text-navy font-bold">
                            <th class="p-3 w-32 text-center">ภาพแบนเนอร์</th>
                            <th class="p-3">คำพาดหัวสไลด์</th>
                            <th class="p-3 w-20 text-center">ลำดับ</th>
                            <th class="p-3 w-24 text-center">สถานะ</th>
                            <th class="p-3 w-32 text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-gray text-navy">
                        @forelse($slidesList as $sl)
                            <tr class="hover:bg-off/50">
                                <td class="p-3 text-center">
                                    <img src="{{ str_starts_with($sl->photo_path, 'http') ? $sl->photo_path : asset('storage/' . ltrim(str_replace('/storage/', '', $sl->photo_path), '/')) }}" class="w-24 h-12 object-cover rounded border border-border-gray mx-auto">
                                </td>
                                <td class="p-3">
                                    <div class="text-[10px] text-gold font-bold">{{ $sl->eyebrow }}</div>
                                    <div class="font-bold">
                                        {{ $sl->title_th }} <span class="text-gold font-extrabold">{{ $sl->title_highlight }}</span> {{ $sl->title_th_end }}
                                    </div>
                                    <div class="text-[10px] text-muted line-clamp-1 mt-0.5">{{ $sl->subtitle }}</div>
                                </td>
                                <td class="p-3 text-center font-bold">
                                    {{ $sl->order_key }}
                                </td>
                                <td class="p-3 text-center">
                                    <span class="px-2 py-0.5 rounded-full font-bold text-[9px] {{ $sl->published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                                        {{ $sl->published ? 'เปิดใช้งาน' : 'ปิดการใช้งาน' }}
                                    </span>
                                </td>
                                <td class="p-3 text-center space-x-1 whitespace-nowrap">
                                    <button wire:click="openForm({{ $sl->id }})" class="bg-teal text-white px-2.5 py-1.5 rounded-lg font-bold hover:bg-teal-dark cursor-pointer">
                                        แก้ไข
                                    </button>
                                    <button onclick="confirm('ยืนยันที่จะลบสไลด์ภาพนี้หรือไม่?') || event.stopImmediatePropagation()" 
                                            wire:click="deleteSlide({{ $sl->id }})" 
                                            class="bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 cursor-pointer">
                                        ลบ
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center text-muted">ไม่พบข้อมูลภาพสไลด์โชว์ในระบบ</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $slidesList->links() }}
            </div>
        </div>
    @else
        {{-- Form Editor --}}
        <div class="bg-white rounded-2xl border border-border-gray shadow-sm p-6 space-y-6">
            <div class="flex justify-between items-center border-b border-border-gray pb-4">
                <h3 class="font-prompt text-base font-bold text-navy">
                    {{ $slideId ? '📝 แก้ไขสไลด์โชว์' : '✨ เพิ่มสไลด์โชว์ใหม่' }}
                </h3>
                <button wire:click="closeForm()" class="text-xs text-muted hover:text-navy cursor-pointer">✕ ยกเลิก</button>
            </div>

            <form wire:submit.prevent="saveSlide" class="space-y-4 text-xs text-navy">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">คำกำกับเล็กหัวสไลด์ (Eyebrow)</label>
                        <input type="text" wire:model="eyebrow" class="form-input" placeholder="เช่น 🔬 School of Medical Sciences">
                    </div>

                    <div>
                        <label class="form-label">ลำดับการแสดงผล (เรียงลำดับน้อยไปมาก) *</label>
                        <input type="number" wire:model="order_key" class="form-input" required>
                    </div>

                    <div>
                        <label class="form-label">ข้อความหลักแถวที่ 1 *</label>
                        <input type="text" wire:model="title_th" class="form-input" placeholder="เช่น แหล่งปัญญาด้าน" required>
                    </div>

                    <div>
                        <label class="form-label">ข้อความเน้นพิเศษ (สีทอง)</label>
                        <input type="text" wire:model="title_highlight" class="form-input" placeholder="เช่น วิทยาศาสตร์การแพทย์">
                    </div>

                    <div>
                        <label class="form-label">ข้อความแถวที่ 2 / ข้อความลงท้าย</label>
                        <input type="text" wire:model="title_th_end" class="form-input" placeholder="เช่น ระดับอาเซียน">
                    </div>

                    <div>
                        <label class="form-label">คำอธิบายข้อความรอง (Subtitle)</label>
                        <input type="text" wire:model="subtitle" class="form-input" placeholder="เช่น มุ่งผลิตบัณฑิตที่มีความสามารถและจริยธรรม...">
                    </div>

                    <div class="md:col-span-2">
                        <label class="form-label">รูปภาพพื้นหลังแบนเนอร์ *</label>
                        <div class="flex gap-2">
                            <input type="text" id="slide_photo_input" wire:model="photo_path" class="form-input" placeholder="เช่น /storage/media/banner_lab.png" required>
                            <button type="button" onclick="openSlidePhotoPicker()" class="bg-teal text-white px-4 py-2.5 font-bold rounded-lg hover:bg-teal-dark cursor-pointer whitespace-nowrap">
                                📂 เลือกรูปภาพแบนเนอร์
                            </button>
                        </div>
                        <p class="text-[10px] text-muted mt-1">แนะนำให้อัปโหลดแบนเนอร์ขนาดแนวนอน (สัดส่วนประมาณ 1920x650px) เข้าสู่คลังภาพและสื่อ แล้วมากดปุ่มนี้เลือกใช้งาน</p>
                    </div>

                    <div>
                        <label class="form-label">ชื่อปุ่มที่ 1 (ปุ่มหลัก)</label>
                        <input type="text" wire:model="primary_btn_text" class="form-input" placeholder="เช่น ดูหลักสูตรทั้งหมด">
                    </div>

                    <div>
                        <label class="form-label">ลิงก์ของปุ่มที่ 1</label>
                        <input type="text" wire:model="primary_btn_url" class="form-input" placeholder="เช่น /programs หรือ https://...">
                    </div>

                    <div>
                        <label class="form-label">ชื่อปุ่มที่ 2 (ปุ่มรอง)</label>
                        <input type="text" wire:model="secondary_btn_text" class="form-input" placeholder="เช่น แนะนำคณะ ▶">
                    </div>

                    <div>
                        <label class="form-label">ลิงก์ของปุ่มที่ 2</label>
                        <input type="text" wire:model="secondary_btn_url" class="form-input" placeholder="เช่น /about">
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <input type="checkbox" wire:model="published" id="published_checkbox" class="w-4 h-4 text-teal border-border-gray rounded focus:ring-teal cursor-pointer">
                        <label for="published_checkbox" class="font-bold text-navy cursor-pointer">เปิดการแสดงผลสไลด์นี้บนหน้าเว็บหลัก</label>
                    </div>
                </div>

                <div class="border-t border-border-gray pt-4 flex justify-end gap-2">
                    <button type="button" wire:click="closeForm()" class="bg-gray-100 text-navy font-bold px-5 py-2.5 rounded-lg hover:bg-gray-200 cursor-pointer">
                        ยกเลิก
                    </button>
                    <button type="submit" class="bg-teal text-white font-bold px-6 py-2.5 rounded-lg hover:bg-teal-dark cursor-pointer shadow-md shadow-teal/10">
                        💾 บันทึกข้อมูลสไลด์
                    </button>
                </div>
            </form>
        </div>
    @endif

    <script>
        function openSlidePhotoPicker() {
            const width = 850;
            const height = 600;
            const left = (screen.width - width) / 2;
            const top = (screen.height - height) / 2;
            window.open('{{ route('admin.media.picker') }}', 'SlidePhotoPicker', `width=${width},height=${height},left=${left},top=${top},scrollbars=yes`);
        }

        window.selectPdfPath = function(url) {
            const input = document.getElementById('slide_photo_input');
            if (input) {
                input.value = url;
                input.dispatchEvent(new Event('input'));
            }
        };
    </script>
</div>
