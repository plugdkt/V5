<div>
    {{-- Calendar Header --}}
    <div class="flex justify-between items-center mb-6">
        <button wire:click="prevMonth" class="p-1.5 hover:bg-off rounded-lg text-navy text-sm font-bold border border-border-gray cursor-pointer">◀</button>
        <span class="font-prompt font-bold text-sm text-navy">{{ $monthName }}</span>
        <button wire:click="nextMonth" class="p-1.5 hover:bg-off rounded-lg text-navy text-sm font-bold border border-border-gray cursor-pointer">▶</button>
    </div>

    {{-- Weekday Names --}}
    <div class="grid grid-cols-7 gap-1 text-center text-xs font-semibold text-muted mb-2 border-b border-border-gray pb-2">
        <div class="text-red-500">อา.</div>
        <div>จ.</div>
        <div>อ.</div>
        <div>พ.</div>
        <div>พฤ.</div>
        <div>ศ.</div>
        <div class="text-blue-500">ส.</div>
    </div>

    {{-- Days Grid --}}
    <div class="grid grid-cols-7 gap-1 text-center mb-6">
        {{-- Empty cells before start day of month --}}
        @for($i = 0; $i < $dayOfWeekOffset; $i++)
            <div class="aspect-square"></div>
        @endfor

        {{-- Days of month --}}
        @for($day = 1; $day <= $daysInMonth; $day++)
            @php
                $dateStr = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
                $isToday = $dateStr === date('Y-m-d');
                $isSelected = $dateStr === $selectedDate;
                $hasEvent = in_array($dateStr, $daysWithEvents);
            @endphp
            <button wire:click="selectDate('{{ $dateStr }}')"
                    class="aspect-square rounded-lg flex flex-col items-center justify-center relative text-xs transition-colors cursor-pointer
                           {{ $isSelected ? 'bg-navy text-white font-bold' : ($isToday ? 'bg-gold/20 text-navy font-bold border border-gold' : 'hover:bg-off text-navy') }}">
                <span>{{ $day }}</span>
                @if($hasEvent)
                    <span class="absolute bottom-1 w-1 h-1 rounded-full {{ $isSelected ? 'bg-gold' : 'bg-teal' }}"></span>
                @endif
            </button>
        @endfor
    </div>

    {{-- Selected Date Events --}}
    <div class="border-t border-border-gray pt-5">
        <h4 class="font-prompt text-xs font-bold text-navy mb-4 flex items-center justify-between">
            <span>📅 กิจกรรมวันที่ {{ Carbon\Carbon::parse($selectedDate)->locale('th')->translatedFormat('d F Y') }}</span>
            <span class="badge badge-navy">{{ count($events) }} กิจกรรม</span>
        </h4>

        <div class="space-y-3">
            @forelse($events as $event)
                <div class="border-l-4 p-3.5 bg-off rounded-r-xl transition-all hover:bg-white border-gold flex flex-col gap-1">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-teal">
                        ⏱ {{ $event->all_day ? 'ทั้งวัน' : $event->start_date->locale('th')->translatedFormat('H:i') . ' - ' . $event->end_date->locale('th')->translatedFormat('H:i น.') }}
                    </span>
                    <h5 class="text-sm font-bold text-navy leading-snug">
                        {{ $event->title }}
                    </h5>
                    @if($event->location)
                        <span class="text-[11px] text-muted flex items-center gap-1 mt-1">
                            📍 {{ $event->location }}
                        </span>
                    @endif
                </div>
            @empty
                <div class="text-center text-muted text-xs py-8">
                    ไม่มีกิจกรรมสำหรับวันนี้
                </div>
            @endforelse
        </div>
    </div>
</div>
