<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-prompt text-lg font-bold text-navy">🌐 จัดการบริการออนไลน์ E-Service</h2>
        @if(!$isFormOpen)
            <button wire:click="openForm()" class="font-bold px-4 py-2 text-xs rounded-lg hover:opacity-90 cursor-pointer shadow-md" style="background-color: #8D38C9; color: #FFFFFF;">
                ➕ เพิ่มบริการใหม่
            </button>
        @endif
    </div>

    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-xs mb-6 font-semibold">
            {{ session('message') }}
        </div>
    @endif

    @if(!$isFormOpen)
        {{-- Search & Table List --}}
        <div class="bg-white rounded-2xl border border-border-gray shadow-sm p-4 space-y-4">
            <div class="flex gap-2">
                <input type="text" wire:model.live="search" class="form-input text-xs" placeholder="ค้นหาชื่อบริการ, คำอธิบาย หรือประเภทกลุ่มผู้ใช้...">
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-border-gray text-navy font-bold">
                            <th class="p-3 w-16 text-center">ลำดับ</th>
                            <th class="p-3 w-44">ประเภทกลุ่มผู้ใช้</th>
                            <th class="p-3 w-40">หัวข้อติดบอร์ด (Badge)</th>
                            <th class="p-3">ชื่อบริการออนไลน์</th>
                            <th class="p-3">ลิงก์ระบบ / คู่มือ</th>
                            <th class="p-3 w-24 text-center">สถานะ</th>
                            <th class="p-3 w-32 text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-gray text-navy">
                        @forelse($services as $sv)
                            <tr class="hover:bg-off/50">
                                <td class="p-3 text-center font-bold">
                                    {{ $sv->sort_order }}
                                </td>
                                <td class="p-3 space-y-1">
                                    @if(is_array($sv->category))
                                        @foreach($sv->category as $cat)
                                            <span class="px-2 py-0.5 rounded font-bold text-[9px] block w-max {{ $cat === 'student' ? 'bg-blue-100 text-blue-800' : ($cat === 'staff' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                                                {{ $cat === 'student' ? '🎓 สำหรับนิสิต' : ($cat === 'staff' ? '💼 สำหรับบุคลากร' : '🌐 สำหรับบุคคลทั่วไป') }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="px-2 py-0.5 rounded font-bold text-[9px] block w-max {{ $sv->category === 'student' ? 'bg-blue-100 text-blue-800' : ($sv->category === 'staff' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                                            {{ $sv->category === 'student' ? '🎓 สำหรับนิสิต' : ($sv->category === 'staff' ? '💼 สำหรับบุคลากร' : '🌐 สำหรับบุคคลทั่วไป') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    @if($sv->badge_text)
                                        <span class="badge badge-gold" style="color: #c4996c; border: 1px solid rgba(196,153,108,0.2);">{{ $sv->badge_text }}</span>
                                    @else
                                        <span class="text-gray-400 font-light">-</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <div class="font-bold">{{ $sv->title }}</div>
                                    <div class="text-[10px] text-muted line-clamp-2 mt-0.5">{{ $sv->description }}</div>
                                </td>
                                <td class="p-3 space-y-1">
                                    @php
                                        $displayUrl = $sv->url;
                                        if (!str_starts_with($sv->url, 'http') && !str_starts_with($sv->url, '#') && Route::has($sv->url)) {
                                            $displayUrl = route($sv->url);
                                        }
                                    @endphp
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[10px] font-bold text-gray-400">ระบบ:</span>
                                        <a href="{{ $displayUrl }}" target="_blank" class="text-[#8D38C9] hover:underline font-semibold break-all text-[11px]">
                                            {{ $sv->url }} ↗
                                        </a>
                                    </div>
                                    @if($sv->manual_url)
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-[10px] font-bold text-gray-400">คู่มือ:</span>
                                            <a href="{{ $sv->manual_url }}" target="_blank" class="text-orange-500 hover:underline break-all text-[11px]">
                                                {{ $sv->manual_url }} ↗
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-3 text-center">
                                    <span class="px-2 py-0.5 rounded-full font-bold text-[9px] {{ $sv->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                                        {{ $sv->is_active ? 'เปิดใช้งาน' : 'ปิดใช้งาน' }}
                                    </span>
                                </td>
                                <td class="p-3 text-center space-x-1 whitespace-nowrap">
                                    <button wire:click="openForm({{ $sv->id }})" class="px-2.5 py-1.5 rounded-lg font-bold hover:opacity-90 cursor-pointer" style="background-color: #8D38C9; color: #FFFFFF;">
                                        แก้ไข
                                    </button>
                                    <button onclick="confirm('ยืนยันที่จะลบบริการออนไลน์นี้หรือไม่?') || event.stopImmediatePropagation()" 
                                            wire:click="deleteService({{ $sv->id }})" 
                                            class="bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 cursor-pointer">
                                        ลบ
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-10 text-center text-muted">ไม่พบข้อมูลบริการ E-Service ในระบบ</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $services->links() }}
            </div>
        </div>
    @else
        {{-- Form Editor --}}
        <div class="bg-white rounded-2xl border border-border-gray shadow-sm p-6 space-y-6">
            <div class="flex justify-between items-center border-b border-border-gray pb-4">
                <h3 class="font-prompt text-base font-bold text-navy">
                    {{ $serviceId ? '📝 แก้ไขข้อมูลบริการ E-Service' : '✨ เพิ่มบริการ E-Service ใหม่' }}
                </h3>
                <button wire:click="closeForm()" class="text-xs text-muted hover:text-navy cursor-pointer">✕ ยกเลิก</button>
            </div>

            <form wire:submit.prevent="saveService" class="space-y-6 text-xs text-navy">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Category (Checkboxes for Multi-group selection) -->
                    <div class="md:col-span-2">
                        <label class="form-label">กลุ่มผู้ใช้บริการ (เลือกได้มากกว่า 1 กลุ่ม) <span class="text-red-500">*</span></label>
                        <div class="flex flex-wrap gap-4 mt-2">
                            <label class="flex items-center gap-2 cursor-pointer font-semibold select-none">
                                <input type="checkbox" wire:model="category" value="student" class="rounded border-border-gray text-[#8D38C9] focus:ring-[#8D38C9] w-4 h-4">
                                🎓 สำหรับนิสิตปัจจุบัน (Student)
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer font-semibold select-none">
                                <input type="checkbox" wire:model="category" value="staff" class="rounded border-border-gray text-[#8D38C9] focus:ring-[#8D38C9] w-4 h-4">
                                💼 สำหรับบุคลากร (Staff)
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer font-semibold select-none">
                                <input type="checkbox" wire:model="category" value="general" class="rounded border-border-gray text-[#8D38C9] focus:ring-[#8D38C9] w-4 h-4">
                                🌐 สำหรับบุคคลทั่วไป (General Public)
                            </label>
                        </div>
                        @error('category') <span class="text-red-500 text-[10px] block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Badge Text -->
                    <div>
                        <label class="form-label">หัวข้อป้ายติดหน้าการ์ด (Badge Text) เช่น SOFTWARE, REGISTRATION</label>
                        <input type="text" wire:model="badge_text" class="form-input text-xs" placeholder="ตัวอย่าง: SOFTWARE">
                        @error('badge_text') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label class="form-label">ชื่อบริการ E-Service <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="title" class="form-input text-xs" placeholder="ตัวอย่าง: ระบบบริการการศึกษา REG">
                        @error('title') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="form-label">คำอธิบายรายละเอียดสั้นๆ <span class="text-red-500">*</span></label>
                        <textarea wire:model="description" class="form-input text-xs min-h-[80px]" placeholder="รายละเอียดของบริการที่จะแสดงใต้หัวข้อ..."></textarea>
                        @error('description') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <!-- URL -->
                    <div>
                        <label class="form-label">ลิงก์ทางเข้าของระบบ (URL หรือ Laravel Route Name) <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="url" class="form-input text-xs" placeholder="ตัวอย่าง: https://reg.up.ac.th หรือ booking.rooms">
                        <p class="text-[9px] text-muted mt-1">หากเป็นลิงก์ภายในคณะ ให้ใส่เฉพาะ Route Name เช่น booking.rooms ระบบจะแปลงลิงก์อัตโนมัติ</p>
                        @error('url') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <!-- Manual URL -->
                    <div>
                        <label class="form-label">ลิงก์สำหรับเปิดดูคู่มือการใช้งาน (ถ้ามี)</label>
                        <input type="text" wire:model="manual_url" class="form-input text-xs" placeholder="ตัวอย่าง: https://coop.up.ac.th/downloads/manual_v1.pdf">
                        @error('manual_url') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label class="form-label">ลำดับการแสดงผล <span class="text-red-500">*</span></label>
                        <input type="number" wire:model="sort_order" class="form-input text-xs" placeholder="0">
                        @error('sort_order') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <!-- Active state -->
                    <div>
                        <label class="form-label">เปิด/ปิด การใช้งานระบบบริการ</label>
                        <div class="flex items-center gap-2 mt-2">
                            <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-border-gray text-[#8D38C9] focus:ring-[#8D38C9] w-4 h-4 cursor-pointer">
                            <label for="is_active" class="cursor-pointer font-semibold select-none">เปิดใช้งาน</label>
                        </div>
                        @error('is_active') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-6 border-t border-border-gray">
                    <button type="button" wire:click="closeForm()" class="bg-gray-100 hover:bg-gray-200 text-navy font-semibold px-4 py-2 rounded-lg cursor-pointer transition-colors">
                        ✕ ยกเลิก
                    </button>
                    <button type="submit" class="hover:opacity-90 font-bold px-5 py-2 rounded-lg cursor-pointer transition-colors shadow" style="background-color: #8D38C9; color: #FFFFFF;">
                        💾 บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
