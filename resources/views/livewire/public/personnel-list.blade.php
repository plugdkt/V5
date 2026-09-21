<div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-8">
    {{-- Left Sidebar: Departments --}}
    <div class="space-y-4">
        <div class="bg-white rounded-2xl border border-border-gray p-5 shadow-sm">
            <h3 class="font-prompt text-sm font-bold text-navy mb-4 pb-2 border-b border-border-gray">
                สาขาวิชา / ฝ่ายงาน
            </h3>
            <div class="flex flex-col gap-1">
                <button wire:click="selectDepartment('')"
                        class="text-left px-3 py-2.5 rounded-lg text-xs font-semibold cursor-pointer transition-colors {{ empty($selectedDepartmentId) ? 'bg-navy text-white' : 'hover:bg-off text-navy' }}">
                    📁 ทั้งหมด
                </button>
                @foreach($departments as $dept)
                    <button wire:click="selectDepartment({{ $dept->id }})"
                            class="text-left px-3 py-2.5 rounded-lg text-xs font-semibold cursor-pointer transition-colors {{ $selectedDepartmentId == $dept->id ? 'bg-navy text-white' : 'hover:bg-off text-navy' }}">
                        📁 {{ $dept->name_th }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right Content: Directory --}}
    <div class="space-y-6">
        {{-- Search input --}}
        <div class="relative max-w-md">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-input pr-10" placeholder="🔍 ค้นหารายชื่อบุคลากร...">
            @if($search)
                <button wire:click="$set('search', '')" class="absolute right-3 top-1/2 -translate-y-1/2 text-muted hover:text-navy text-sm">✕</button>
            @endif
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
            @php
                $normalizePersonPhoto = function($path) {
                    if (filter_var($path, FILTER_VALIDATE_URL)) {
                        $parsed = parse_url($path);
                        $path = $parsed['path'] ?? $path;
                    }
                    $path = str_replace('/V5/public/storage/', '', $path);
                    $path = str_replace('/storage/', '', $path);
                    return asset('storage/' . ltrim($path, '/'));
                };
            @endphp

            @forelse($personnel as $person)
                <div class="card border border-border-gray p-5 flex flex-col items-center text-center">
                    {{-- Photo --}}
                    <div class="w-24 h-24 rounded-full overflow-hidden mb-4 border border-border-gray bg-teal/5 flex items-center justify-center flex-shrink-0">
                        @if($person->photo)
                            <img src="{{ $normalizePersonPhoto($person->photo) }}" alt="{{ $person->firstname_th }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-3xl text-teal/40 font-bold font-prompt">
                                {{ mb_substr($person->firstname_th, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    
                    {{-- Position Info --}}
                    <span class="text-[9px] font-bold tracking-wider uppercase text-teal mb-1 bg-teal/10 px-2 py-0.5 rounded">
                        {{ $person->position ? $person->position->name_th : 'บุคลากร' }}
                    </span>
                    
                    <h4 class="font-prompt text-sm font-bold text-navy mb-1 leading-snug">
                        {{ $person->full_name_th }}
                    </h4>
                    
                    @if($person->academic_position)
                        <span class="text-xs text-gold font-semibold mb-1">{{ $person->academic_position }}</span>
                    @endif

                    <span class="text-[10px] text-muted mb-4">{{ $person->department ? $person->department->name_th : '' }}</span>
                    
                    {{-- Contact Info --}}
                    <div class="border-t border-border-gray w-full pt-3 flex flex-col gap-1 text-[11px] text-muted items-center">
                        @if($person->email)
                            <span class="truncate max-w-full">📧 {{ $person->email }}</span>
                        @endif
                        @if($person->phone)
                            <span>📞 {{ $person->phone }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full card p-16 text-center text-muted border border-border-gray">
                    📭 ไม่พบรายชื่อบุคลากรที่ค้นหา
                </div>
            @endforelse
        </div>
    </div>
</div>
