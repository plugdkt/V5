<div>
    @if(session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-xs rounded-xl p-4 mb-6">
            {{ session('message') }}
        </div>
    @endif

    {{-- Controls --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <input type="text" wire:model.live.debounce.300ms="search" class="form-input max-w-xs text-xs" placeholder="🔍 ค้นหาหัวข้อประชุม / ชื่อผู้จอง...">
        
        <select wire:model.live="filterStatus" class="form-select max-w-xs text-xs py-1.5 px-3">
            <option value="">ทั้งหมด (ทุกสถานะ)</option>
            <option value="pending">รอการอนุมัติ (Pending)</option>
            <option value="approved">อนุมัติแล้ว (Approved)</option>
            <option value="rejected">ปฏิเสธแล้ว (Rejected)</option>
            <option value="cancelled">ยกเลิกแล้ว (Cancelled)</option>
        </select>
    </div>

    {{-- Bookings Table --}}
    <div class="overflow-hidden border border-border-gray rounded-xl">
        <table class="table w-full text-left text-xs font-light text-navy">
            <thead class="bg-off font-prompt font-bold text-navy border-b border-border-gray">
                <tr>
                    <th class="p-4" width="20%">ห้องประชุม</th>
                    <th class="p-4" width="35%">หัวข้อประชุม / ผู้จอง</th>
                    <th class="p-4" width="20%">วัน/เวลา</th>
                    <th class="p-4 text-center" width="5%">คน</th>
                    <th class="p-4" width="10%">สถานะ</th>
                    <th class="p-4 text-center" width="10%">การจัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-gray bg-white">
                @forelse($bookings as $bk)
                    <tr class="hover:bg-off/50">
                        <td class="p-4 font-bold text-navy">
                            {{ $bk->room->name }}
                        </td>
                        <td class="p-4">
                            <h4 class="font-bold text-navy text-sm mb-0.5">{{ $bk->title }}</h4>
                            @if($bk->purpose)
                                <p class="text-muted text-[10px] mb-1 italic">วัตถุประสงค์: {{ $bk->purpose }}</p>
                            @endif
                            <span class="text-muted text-[10px]">ผู้จอง: {{ $bk->user ? $bk->user->name : 'Legacy User' }} ({{ $bk->user ? $bk->user->email : '' }})</span>
                        </td>
                        <td class="p-4 text-muted">
                            <span class="font-semibold block text-navy">{{ $bk->start_datetime->locale('th')->translatedFormat('d M Y') }}</span>
                            <span class="block text-[10px] mt-0.5">⏱ {{ $bk->start_datetime->locale('th')->translatedFormat('H:i') }} - {{ $bk->end_datetime->locale('th')->translatedFormat('H:i น.') }}</span>
                        </td>
                        <td class="p-4 text-center font-bold text-navy">
                            {{ $bk->attendees }}
                        </td>
                        <td class="p-4">
                            <span class="badge {{ $bk->status === 'approved' ? 'badge-green' : ($bk->status === 'pending' ? 'badge-amber' : ($bk->status === 'rejected' ? 'badge-red' : 'badge-navy')) }}">
                                {{ $bk->status === 'approved' ? 'อนุมัติแล้ว' : ($bk->status === 'pending' ? 'รออนุมัติ' : ($bk->status === 'rejected' ? 'ปฏิเสธ' : 'ยกเลิก')) }}
                            </span>
                            @if($bk->status === 'rejected' && $bk->note)
                                <span class="block text-[9px] text-red-600 mt-1 italic">หมายเหตุ: {{ $bk->note }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-center space-x-1 whitespace-nowrap">
                            @if($bk->status === 'pending')
                                <button wire:click="approveBooking({{ $bk->id }})" class="bg-green-100 text-green-700 px-2.5 py-1.5 rounded-lg font-bold hover:bg-green-200 cursor-pointer">
                                    อนุมัติ
                                </button>
                                <button wire:click="openRejectModal({{ $bk->id }})" class="bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 cursor-pointer">
                                    ปฏิเสธ
                                </button>
                            @else
                                <span class="text-muted text-[10px]">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center text-muted">ไม่พบข้อมูลคำขอจองห้องประชุม</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>

    {{-- Reject Modal --}}
    @if($isRejectModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white rounded-2xl border border-border-gray max-w-md w-full p-6 shadow-2xl space-y-4">
                <h3 class="font-prompt text-base font-bold text-navy">❌ ระบุเหตุผลการปฏิเสธคำขอจอง</h3>
                
                <form wire:submit.prevent="rejectBooking" class="space-y-4">
                    <div>
                        <label class="form-label">หมายเหตุ / เหตุผลการปฏิเสธ</label>
                        <input type="text" wire:model="rejectReason" class="form-input" placeholder="เช่น ห้องประชุมชนกับคิวกิจกรรมหลักสูตร" required>
                    </div>

                    <div class="flex justify-end gap-3 pt-3">
                        <button type="button" wire:click="closeRejectModal" class="border border-border-gray text-navy px-4 py-2 rounded-lg text-xs hover:bg-off cursor-pointer">ยกเลิก</button>
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-red-700 cursor-pointer">ยืนยันปฏิเสธ</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
