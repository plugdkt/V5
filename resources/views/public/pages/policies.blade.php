<x-public-layout>
    <x-slot name="title">แผน / นโยบาย / มาตรการ</x-slot>

    <!-- Hero Banner (V5 Style) -->
    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <h1 class="font-prompt text-3xl font-bold mb-1">
                แผน / นโยบาย / มาตรการ
            </h1>
            <p class="text-white/70 font-light text-sm">
                คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
            </p>
        </div>
    </div>

    <!-- Main Accordion Content Area -->
    <div class="max-w-[1000px] mx-auto px-6 py-12">
        @forelse($categories as $category)
            <div class="mb-10 last:mb-0">
                
                <!-- Category Heading (V4 Style) -->
                <h2 class="font-prompt text-sm md:text-base font-bold text-[#0C00D3] mb-4 pb-2 border-b border-border-gray uppercase tracking-wide">
                    {{ $category->name }}
                </h2>

                @php
                    $groups = $category->documents->groupBy('group_name');
                @endphp

                <!-- Accordions for groups -->
                <div class="space-y-4">
                    @foreach($groups as $groupName => $docs)
                        <div x-data="{ open: true }" class="border border-border-gray rounded-lg overflow-hidden bg-white shadow-sm">
                            
                            <!-- Accordion Header Button -->
                            <button @click="open = !open" 
                                    class="w-full flex justify-between items-center py-3.5 px-5 text-left font-prompt font-bold text-navy hover:bg-off/50 transition-all cursor-pointer select-none">
                                <span class="flex items-center gap-2.5 text-xs md:text-sm">
                                    <span class="text-teal">📄</span>
                                    <span>{{ $groupName }}</span>
                                </span>
                                <svg class="w-4 h-4 text-muted transition-transform duration-200" 
                                     :class="open ? 'rotate-180' : ''" 
                                     fill="none" 
                                     stroke="currentColor" 
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Accordion Content Body -->
                            <div x-show="open" 
                                 x-collapse 
                                 x-cloak
                                 class="border-t border-border-gray p-6 bg-off/10">
                                
                                @php
                                    $subgroups = $docs->groupBy(function($d) {
                                        return $d->sub_group_name ?: '_none_';
                                    });
                                @endphp

                                <div class="space-y-6">
                                    @foreach($subgroups as $subgroupName => $subDocs)
                                        <div class="space-y-3">
                                            @if($subgroupName !== '_none_')
                                                <!-- Year Subgroup Header -->
                                                <h4 class="font-prompt text-xs font-bold text-navy border-b border-border-gray pb-1 mb-2">
                                                    {{ $subgroupName }}
                                                </h4>
                                            @endif

                                            <!-- Bulleted Link List (V4 Style) -->
                                            <ul class="list-disc pl-5 space-y-2.5 text-xs md:text-sm text-navy">
                                                @foreach($subDocs as $doc)
                                                    <li class="hover:text-teal transition-colors">
                                                        <a href="{{ $doc->file_path }}" 
                                                           target="_blank" 
                                                           class="hover:underline font-medium leading-normal break-all">
                                                            {{ $doc->title }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl border border-border-gray shadow-sm p-16 text-center text-muted">
                <span class="text-4xl block mb-3">📁</span>
                <p class="font-prompt text-sm font-semibold">อยู่ระหว่างการจัดเตรียมข้อมูลและเอกสารแผนงาน</p>
            </div>
        @endforelse
    </div>
</x-public-layout>
