<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-prompt text-lg font-bold text-navy">💼 จัดการรายชื่อผู้บริหารคณะ</h2>
        @if(!$isFormOpen)
            <button wire:click="openForm()" class="bg-gold text-navy font-bold px-4 py-2 text-xs rounded-lg hover:bg-gold-light cursor-pointer shadow-md shadow-gold/10">
                ➕ เพิ่มผู้บริหารใหม่
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
                <input type="text" wire:model.live="search" class="form-input text-xs" placeholder="ค้นหาตามชื่อ หรือ ตำแหน่งบริหาร...">
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-border-gray text-navy font-bold">
                            <th class="p-3 w-16 text-center">รูป</th>
                            <th class="p-3">ชื่อ-นามสกุล</th>
                            <th class="p-3">ตำแหน่งบริหาร</th>
                            <th class="p-3 w-20 text-center">ลำดับ</th>
                            <th class="p-3 w-32 text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-gray text-navy">
                        @forelse($executivesList as $exec)
                            <tr class="hover:bg-off/50">
                                <td class="p-3 text-center">
                                    <img src="{{ $exec->photo_path ? (str_starts_with($exec->photo_path, 'http') ? $exec->photo_path : asset(ltrim($exec->photo_path, '/'))) : asset('v4/images/Logo_up.png') }}" class="w-10 h-10 rounded-full object-cover mx-auto border border-border-gray">
                                </td>
                                <td class="p-3">
                                    <div class="font-bold">{{ $exec->name_th }}</div>
                                    <div class="text-[10px] text-muted">{{ $exec->name_en }}</div>
                                </td>
                                <td class="p-3">
                                    <span class="bg-teal/10 text-teal text-[10px] font-bold px-2 py-0.5 rounded-full inline-block">
                                        {{ $exec->position_th }}
                                    </span>
                                    <div class="text-[9px] text-muted mt-0.5">{{ $exec->position_en }}</div>
                                </td>
                                <td class="p-3 text-center font-bold">
                                    {{ $exec->order_key }}
                                </td>
                                <td class="p-3 text-center space-x-1 whitespace-nowrap">
                                    <button wire:click="openForm({{ $exec->id }})" class="bg-teal text-white px-2.5 py-1.5 rounded-lg font-bold hover:bg-teal-dark cursor-pointer">
                                        แก้ไข
                                    </button>
                                    <button onclick="confirm('ยืนยันที่จะลบผู้บริหารท่านนี้หรือไม่?') || event.stopImmediatePropagation()" 
                                            wire:click="deleteExecutive({{ $exec->id }})" 
                                            class="bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 cursor-pointer">
                                        ลบ
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center text-muted">ไม่พบข้อมูลรายชื่อผู้บริหารในระบบ</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $executivesList->links() }}
            </div>
        </div>
    @else
        {{-- Form Editor --}}
        <div class="bg-white rounded-2xl border border-border-gray shadow-sm p-6 space-y-6">
            <div class="flex justify-between items-center border-b border-border-gray pb-4">
                <h3 class="font-prompt text-base font-bold text-navy">
                    {{ $executiveId ? '📝 แก้ไขข้อมูลผู้บริหาร' : '✨ เพิ่มข้อมูลผู้บริหารใหม่' }}
                </h3>
                <button wire:click="closeForm()" class="text-xs text-muted hover:text-navy cursor-pointer">✕ ยกเลิก</button>
            </div>

            <form wire:submit.prevent="saveExecutive" class="space-y-4 text-xs text-navy">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">ชื่อ-นามสกุล (ภาษาไทย) *</label>
                        <input type="text" wire:model="name_th" class="form-input" placeholder="เช่น ผศ.ดร.สมชาย ใจดี" required>
                    </div>

                    <div>
                        <label class="form-label">ชื่อ-นามสกุล (ภาษาอังกฤษ)</label>
                        <input type="text" wire:model="name_en" class="form-input" placeholder="เช่น Asst.prof. Dr.Somchai Jaidee">
                    </div>

                    <div>
                        <label class="form-label">ตำแหน่งบริหาร (ภาษาไทย) *</label>
                        <input type="text" wire:model="position_th" class="form-input" placeholder="เช่น รองคณบดีฝ่ายบริหาร" required>
                    </div>

                    <div>
                        <label class="form-label">ตำแหน่งบริหาร (ภาษาอังกฤษ)</label>
                        <input type="text" wire:model="position_en" class="form-input" placeholder="เช่น Vice Dean for Administration">
                    </div>

                    <div>
                        <label class="form-label">อีเมลติดต่อ</label>
                        <input type="email" wire:model="email" class="form-input" placeholder="เช่น somchai.ja@up.ac.th">
                    </div>

                    <div>
                        <label class="form-label">เบอร์โทรศัพท์ติดต่อ</label>
                        <input type="text" wire:model="phone" class="form-input" placeholder="เช่น โทร 054 466 666 ต่อ 3207">
                    </div>

                    <div class="md:col-span-2">
                        <label class="form-label">แนบรูปภาพผู้บริหาร</label>
                        <div class="flex gap-2">
                            <input type="text" id="photo_path_input" wire:model="photo_path" class="form-input" placeholder="เช่น /storage/media/filename.jpg">
                            <button type="button" onclick="openPhotoPicker()" class="bg-teal text-white px-4 py-2.5 font-bold rounded-lg hover:bg-teal-dark cursor-pointer whitespace-nowrap">
                                📂 เลือกจากคลังสื่อ
                            </button>
                        </div>
                        <p class="text-[10px] text-muted mt-1">แนะนำให้อัปโหลดรูปภาพแนวตั้งผ่านคลังรูปภาพและสื่อ แล้วมากดปุ่มเลือกรูปภาพนี้ไปแสดงผล</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="form-label">งานภายใต้การกำกับดูแล (ระบุบรรทัดละ 1 งาน - แสดงผลในการ์ดรองคณบดี)</label>
                        <textarea wire:model="duties" class="form-input h-24" placeholder="งานบริหารงานทั่วไป&#10;งานพัสดุ&#10;งานงบประมาณ"></textarea>
                    </div>

                    <div>
                        <label class="form-label">ลำดับการแสดงผล (จัดเรียงจากน้อยไปมาก - เช่น คณบดี=1, รองคณบดี=2, 3, 4) *</label>
                        <input type="number" wire:model="order_key" class="form-input" required>
                    </div>
                </div>

                <div class="border-t border-border-gray pt-4 flex justify-end gap-2">
                    <button type="button" wire:click="closeForm()" class="bg-gray-100 text-navy font-bold px-5 py-2.5 rounded-lg hover:bg-gray-200 cursor-pointer">
                        ยกเลิก
                    </button>
                    <button type="submit" class="bg-teal text-white font-bold px-6 py-2.5 rounded-lg hover:bg-teal-dark cursor-pointer shadow-md shadow-teal/10">
                        💾 บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    @endif

    <script>
        function openPhotoPicker() {
            const width = 850;
            const height = 600;
            const left = (screen.width - width) / 2;
            const top = (screen.height - height) / 2;
            window.open('{{ route('admin.media.picker') }}', 'PhotoPicker', `width=${width},height=${height},left=${left},top=${top},scrollbars=yes`);
        }

        window.selectPdfPath = function(url) {
            const input = document.getElementById('photo_path_input');
            if (input) {
                input.value = url;
                input.dispatchEvent(new Event('input'));
            }
        };
    </script>
</div>
