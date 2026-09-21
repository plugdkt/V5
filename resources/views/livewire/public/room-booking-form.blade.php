<div class="grid grid-cols-1 lg:grid-cols-[1fr_400px] gap-8">
    {{-- Left Content: Room Info & Schedule --}}
    <div class="space-y-6">
        {{-- Room Selector --}}
        <div class="bg-white rounded-2xl border border-border-gray p-5 shadow-sm">
            <label class="form-label">เลือกห้องประชุม</label>
            <select wire:model.live="selectedRoomId" class="form-select">
                @foreach($rooms as $rm)
                    <option value="{{ $rm->id }}">{{ $rm->name }} (ความจุ {{ $rm->capacity }} ที่นั่ง)</option>
                @endforeach
            </select>
            
            @if($currentRoom)
                <div class="mt-4 flex flex-col md:flex-row gap-6 items-start">
                    @if($currentRoom->image)
                        <img src="{{ asset('storage/' . $currentRoom->image) }}" class="w-full md:w-48 h-32 rounded-xl object-cover border border-border-gray">
                    @endif
                    <div class="text-xs text-navy font-light space-y-1.5 flex-grow">
                        <h4 class="font-prompt font-bold text-sm text-navy mb-1">📍 {{ $currentRoom->location ?? 'ไม่ระบุสถานที่' }}</h4>
                        <p>{{ $currentRoom->description }}</p>
                        @if($currentRoom->amenities)
                            <div class="flex flex-wrap gap-1.5 mt-2">
                                @foreach($currentRoom->amenities as $am)
                                    <span class="bg-navy/5 text-navy px-2 py-0.5 rounded text-[10px] uppercase font-bold">{{ $am }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- Schedule View --}}
        <div class="bg-white rounded-2xl border border-border-gray p-5 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h3 class="font-prompt text-sm font-bold text-navy">🗓️ ตารางการใช้งานห้องประชุม</h3>
                <input type="date" wire:model.live="selectedDate" class="form-input max-w-xs text-xs py-1.5 px-3">
            </div>

            <div class="space-y-3">
                @forelse($bookings as $bk)
                    <div class="border-l-4 p-4 bg-off rounded-r-xl border-teal flex justify-between items-center gap-4 flex-wrap">
                        <div class="min-w-0">
                            <span class="text-[10px] font-bold text-teal block mb-1">
                                ⏱ {{ $bk->start_datetime->locale('th')->translatedFormat('H:i') }} - {{ $bk->end_datetime->locale('th')->translatedFormat('H:i น.') }}
                            </span>
                            <h4 class="font-prompt text-sm font-bold text-navy leading-snug line-clamp-1">
                                {{ $bk->title }}
                            </h4>
                            <span class="text-[10px] text-muted block mt-1">ผู้จอง: {{ $bk->user ? $bk->user->name : 'เจ้าหน้าที่' }}</span>
                        </div>
                        <span class="badge {{ $bk->status === 'approved' ? 'badge-green' : 'badge-amber' }}">
                            {{ $bk->status === 'approved' ? 'อนุมัติแล้ว' : 'รอการอนุมัติ' }}
                        </span>
                    </div>
                @empty
                    <div class="text-center text-muted text-xs py-10 border border-dashed border-border-gray rounded-xl">
                        ไม่มีคิวจองในวันที่เลือก สามารถจองได้
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Right Content: Booking Form --}}
    <div class="bg-white rounded-2xl border border-border-gray p-6 shadow-sm h-fit">
        <h3 class="font-prompt text-base font-bold text-navy mb-6 pb-2 border-b border-border-gray flex items-center gap-2">
            <span>📝</span> ส่งคำขอจองห้องประชุม
        </h3>

        @if($successMessage)
            <div class="bg-green-50 border border-green-200 text-green-700 text-xs rounded-xl p-4 mb-4">
                {{ $successMessage }}
            </div>
        @endif

        @if($errorMessage)
            <div class="bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl p-4 mb-4">
                {{ $errorMessage }}
            </div>
        @endif

        @if(Auth::check())
            <form wire:submit.prevent="submitBooking" class="space-y-4">
                <div>
                    <label class="form-label">หัวข้อการประชุม</label>
                    <input type="text" wire:model="title" class="form-input" placeholder="เช่น ประชุมหลักสูตร" required>
                </div>
                
                <div>
                    <label class="form-label">วัตถุประสงค์</label>
                    <textarea wire:model="purpose" rows="2" class="form-input" placeholder="ระบุรายละเอียดสั้น ๆ"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">เวลาเริ่ม</label>
                        <input type="time" wire:model="start_time" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">เวลาสิ้นสุด</label>
                        <input type="time" wire:model="end_time" class="form-input" required>
                    </div>
                </div>

                <div>
                    <label class="form-label">จำนวนผู้เข้าร่วม (คน)</label>
                    <input type="number" wire:model="attendees" class="form-input" min="1" required>
                </div>

                <button type="submit" class="btn-primary w-full py-3">
                    ส่งคำขอจอง
                </button>
            </form>
        @else
            <div class="text-center py-6 space-y-4">
                <p class="text-xs text-muted leading-relaxed">
                    ระบบจองห้องประชุมออนไลน์สงวนสิทธิ์การเข้าใช้งานเฉพาะบุคลากร คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา เท่านั้น
                </p>
                <a href="{{ route('login') }}" class="btn-primary w-full py-3 inline-block">
                    เข้าสู่ระบบด้วย UP SSOเพื่อจองห้องประชุม
                </a>
            </div>
        @endif
    </div>
</div>
