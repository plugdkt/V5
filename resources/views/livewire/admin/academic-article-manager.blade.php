<div class="py-6">
    <!-- Top Action Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 style="color: #0B2545;" class="text-2xl font-bold font-prompt">📚 จัดการบทความวิชาการและผลงานวิจัย</h1>
            <p class="text-xs text-gray-500">จัดการ เพิ่ม แก้ไข และลบบทความวิชาการสำหรับแสดงผลบนหน้าเว็บไซต์</p>
        </div>
        <button wire:click="openForm" style="background-color: #0B2545; color: #FFFFFF;" class="font-bold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 shadow-md hover:bg-[#133C55] transition-all cursor-pointer">
            <span>➕ เพิ่มบทความใหม่</span>
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 text-xs font-prompt">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filter & Search Controls -->
    <div class="bg-white p-4 rounded-2xl border border-gray-200 mb-6 flex flex-col md:flex-row gap-4 justify-between items-center shadow-sm">
        <div class="relative w-full md:w-80">
            <input type="text" wire:model.live="search" placeholder="🔍 ค้นหาชื่อเรื่อง, ผู้แต่ง, สาขาวิชา..." class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-[#0B2545] focus:bg-white font-prompt">
        </div>
        <div class="flex items-center gap-2 w-full md:w-auto font-prompt">
            <span class="text-xs text-gray-600 font-bold">สาขาวิชา:</span>
            <select wire:model.live="categoryFilter" class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-[#0B2545]">
                <option value="all">ทั้งหมด</option>
                <option value="biochemistry">ชีวเคมี</option>
                <option value="microbiology">จุลชีววิทยาและปรสิตวิทยา</option>
                <option value="nutrition">โภชนาการและการกำหนดอาหาร</option>
                <option value="physiology">สรีรวิทยา</option>
                <option value="anatomy">กายวิภาคศาสตร์</option>
                <option value="other">หมวดหมู่อื่นๆ</option>
            </select>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <table class="w-full text-left text-xs font-prompt">
            <thead class="bg-gray-50 text-gray-700 border-b border-gray-200 uppercase font-bold">
                <tr>
                    <th class="p-4">ลำดับ</th>
                    <th class="p-4">ชื่อเรื่องบทความ / งานวิจัย</th>
                    <th class="p-4">ผู้แต่ง / ผู้วิจัย</th>
                    <th class="p-4">สาขาวิชา</th>
                    <th class="p-4">สถานะ</th>
                    <th class="p-4 text-right">จัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($articles as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-400 font-mono">{{ $item->sort_order }}</td>
                        <td class="p-4">
                            <div style="color: #0B2545;" class="font-bold text-sm max-w-md leading-snug">{{ $item->title }}</div>
                            @if($item->link_url)
                                <a href="{{ $item->link_url }}" target="_blank" class="text-[11px] text-sky-600 hover:underline inline-flex items-center gap-1 mt-1">
                                    🔗 ลิงก์บทความฉบับเต็ม
                                </a>
                            @endif
                        </td>
                        <td class="p-4 text-slate-700 font-medium">{{ $item->author ?: '-' }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] bg-slate-100 text-slate-700 font-semibold border border-slate-200">
                                {{ $item->badge }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($item->is_active)
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold">แสดงผล</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] bg-rose-50 text-rose-700 border border-rose-200 font-bold">ซ่อนไว้</span>
                            @endif
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <button wire:click="openForm({{ $item->id }})" class="px-3 py-1.5 bg-sky-50 text-sky-700 border border-sky-200 hover:bg-sky-100 rounded-lg transition-all cursor-pointer font-semibold">
                                ✏️ แก้ไข
                            </button>
                            <button onclick="confirm('ยืนยันการลบบทความนี้?') || event.stopImmediatePropagation()" wire:click="deleteArticle({{ $item->id }})" class="px-3 py-1.5 bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 rounded-lg transition-all cursor-pointer font-semibold">
                                🗑️ ลบ
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400 font-prompt">
                            ไม่พบบทความวิชาการในระบบ
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-100">
            {{ $articles->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    @if($isFormOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs">
            <div class="bg-white border border-gray-200 w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                <div style="background-color: #0B2545; color: #FFFFFF;" class="p-5 flex justify-between items-center">
                    <h3 class="font-bold text-base font-prompt text-white">
                        {{ $articleId ? '✏️ แก้ไขบทความวิชาการ' : '➕ เพิ่มบทความวิชาการใหม่' }}
                    </h3>
                    <button wire:click="closeForm" class="text-white/80 hover:text-white text-xl cursor-pointer">✕</button>
                </div>
                
                <form wire:submit.prevent="saveArticle" class="p-6 overflow-y-auto space-y-4 font-prompt text-xs text-slate-800">
                    <div>
                        <label class="block text-slate-700 mb-1 font-bold">ชื่อเรื่องบทความ / งานวิจัย <span class="text-rose-500">*</span></label>
                        <input type="text" wire:model="title" class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 text-slate-900 focus:border-[#0B2545] focus:bg-white focus:outline-none">
                        @error('title') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-slate-700 mb-1 font-bold">ผู้แต่ง / ผู้วิจัย</label>
                            <input type="text" wire:model="author" placeholder="เช่น ผศ.ดร.ศุภชัย เจริญสิน" class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 text-slate-900 focus:border-[#0B2545] focus:bg-white focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1 font-bold">สาขาวิชา</label>
                            <input type="text" wire:model="division" placeholder="เช่น ชีวเคมี / โภชนาการและการกำหนดอาหาร" class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 text-slate-900 focus:border-[#0B2545] focus:bg-white focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-slate-700 mb-1 font-bold">หมวดหมู่สำหรับกรองหน้าเว็บ <span class="text-rose-500">*</span></label>
                            <select wire:model="category" class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 text-slate-900 focus:border-[#0B2545] focus:bg-white focus:outline-none">
                                <option value="biochemistry">🧬 ชีวเคมี</option>
                                <option value="microbiology">🔬 จุลชีววิทยาและปรสิตวิทยา</option>
                                <option value="nutrition">🥗 โภชนาการและการกำหนดอาหาร</option>
                                <option value="physiology">⚡ สรีรวิทยา</option>
                                <option value="anatomy">🦴 กายวิภาคศาสตร์</option>
                                <option value="other">📚 หมวดหมู่อื่นๆ</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1 font-bold">ลิงก์บทความฉบับเต็ม / URL (PubMed/Journal)</label>
                            <input type="url" wire:model="link_url" placeholder="https://..." class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 text-slate-900 focus:border-[#0B2545] focus:bg-white focus:outline-none">
                            @error('link_url') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1 font-bold">บทคัดย่อ / สรุปเนื้อหา (Abstract)</label>
                        <textarea wire:model="abstract" rows="4" placeholder="สรุปเนื้อหา หรือ บทคัดย่อภาษาไทย/อังกฤษ..." class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 text-slate-900 focus:border-[#0B2545] focus:bg-white focus:outline-none"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-slate-700 mb-1 font-bold">วันที่เผยแพร่</label>
                            <input type="date" wire:model="published_at" class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 text-slate-900 focus:border-[#0B2545] focus:bg-white focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1 font-bold">ลำดับการจัดเรียง</label>
                            <input type="number" wire:model="sort_order" class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 text-slate-900 focus:border-[#0B2545] focus:bg-white focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1 font-bold">สถานะการแสดงผล</label>
                            <select wire:model="is_active" class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 text-slate-900 focus:border-[#0B2545] focus:bg-white focus:outline-none">
                                <option value="1">แสดงผลหน้าเว็บ</option>
                                <option value="0">ซ่อนไว้</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
                        <button type="button" wire:click="closeForm" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl cursor-pointer font-bold">ยกเลิก</button>
                        <button type="submit" style="background-color: #0B2545; color: #FFFFFF;" class="px-5 py-2.5 hover:bg-[#133C55] font-bold rounded-xl cursor-pointer shadow-md">บันทึกข้อมูล</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
