<x-public-layout>
    <x-slot name="title">ผู้บริหาร</x-slot>

    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <h1 class="font-prompt text-3xl font-bold mb-1">
                ผู้บริหารคณะ
            </h1>
            <p class="text-white/70 font-light text-sm">
                คณะผู้บริหาร คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
            </p>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12">
        @php
            $normalizePhoto = function($path) {
                if (!$path) {
                    return asset('v4/images/Logo_up.png');
                }
                if (filter_var($path, FILTER_VALIDATE_URL)) {
                    $parsed = parse_url($path);
                    $path = $parsed['path'] ?? $path;
                }
                $path = str_replace('/V5/public/storage/', '', $path);
                $path = str_replace('/storage/', '', $path);
                return asset('storage/' . ltrim($path, '/'));
            };

            // Separate dean from vice-deans/assistants
            $dean = $executives->first(function($e) {
                return str_contains($e->position_th, 'คณบดี') && !str_contains($e->position_th, 'รองคณบดี') && !str_contains($e->position_th, 'ผู้ช่วยคณบดี');
            });
            $others = $executives->filter(function($e) use ($dean) {
                return !$dean || $e->id !== $dean->id;
            });
        @endphp

        {{-- Dean Card --}}
        @if($dean)
            <div class="flex justify-center mb-12">
                <div class="border border-border-gray rounded-2xl p-8 bg-off text-center max-w-sm w-full shadow-sm hover:shadow-md transition-all">
                    <img class="w-60 h-60 rounded-full object-cover mx-auto mb-6 border-4 border-gold shadow-md" 
                         src="{{ $normalizePhoto($dean->photo_path) }}" 
                         alt="{{ $dean->name_th }}">
                    <h3 class="font-prompt text-base font-bold text-navy mb-1">{{ $dean->name_th }}</h3>
                    @if($dean->name_en)
                        <p class="text-xs text-muted mb-2 font-medium">{{ $dean->name_en }}</p>
                    @endif
                    <p class="text-xs text-gold font-bold uppercase tracking-wide bg-gold/10 py-1.5 px-3 rounded-full inline-block mb-4">{{ $dean->position_th }}</p>
                    
                    @if($dean->email || $dean->phone)
                        <div class="border-t border-border-gray pt-4 text-xs text-muted flex flex-col gap-1">
                            @if($dean->email) <span>📧 {{ $dean->email }}</span> @endif
                            @if($dean->phone) <span>📞 {{ $dean->phone }}</span> @endif
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Vice Deans & Other Executives Grid --}}
        @if($others->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                @foreach($others as $exec)

                    <div class="border border-border-gray rounded-2xl p-6 bg-white text-center shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                        <div>
                            <img class="w-52 h-52 rounded-full object-cover mx-auto mb-6 border-2 border-border-gray shadow-sm" 
                                 src="{{ $normalizePhoto($exec->photo_path) }}" 
                                 alt="{{ $exec->name_th }}">
                            <h4 class="font-prompt text-sm font-bold text-navy mb-1">{{ $exec->name_th }}</h4>
                            @if($exec->name_en)
                                <p class="text-xs text-muted mb-2 font-medium">{{ $exec->name_en }}</p>
                            @endif
                            <p class="text-xs text-teal font-bold uppercase tracking-wide bg-teal/10 py-1 px-3 rounded-full inline-block mb-4">{{ $exec->position_th }}</p>
                            
                            @if($exec->email || $exec->phone)
                                <div class="border-t border-border-gray pt-3 text-xs text-muted flex flex-col gap-1 mb-4">
                                    @if($exec->email) <span>📧 {{ $exec->email }}</span> @endif
                                    @if($exec->phone) <span>📞 {{ $exec->phone }}</span> @endif
                                </div>
                            @endif
                        </div>
                        
                        @if($exec->duties)
                            <div class="bg-off p-4 rounded-xl text-left text-xs leading-relaxed text-muted mt-auto">
                                <strong class="text-navy block mb-1">💼 งานภายใต้การกำกับดูแล:</strong>
                                <ul class="list-disc pl-4 space-y-0.5">
                                    @foreach(explode("\n", str_replace("\r", "", $exec->duties)) as $duty)
                                        @if(trim($duty))
                                            <li>{{ trim($duty) }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-public-layout>
