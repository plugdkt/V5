<x-public-layout>
    <x-slot name="title">{{ __('featured_programs') }}</x-slot>
    <x-slot name="description">{{ app()->getLocale() === 'en' ? 'Undergraduate programs at the School of Medical Sciences, University of Phayao: Microbiology, Biochemistry, Nutrition and Dietetics.' : 'หลักสูตรระดับปริญญาตรี คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา: สาขาจุลชีววิทยา, ชีวเคมีและชีววิทยาโมเลกุล, โภชนาการและการกำหนดอาหาร' }}</x-slot>

    @push('head')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "{{ app()->getLocale() === 'en' ? 'Home' : 'หน้าแรก' }}",
          "item": "{{ route('home') }}"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "{{ __('featured_programs') }}",
          "item": "{{ route('programs') }}"
        }
      ]
    }
    </script>
    @endpush

    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <h1 class="font-prompt text-3xl font-bold mb-1">
                หลักสูตรที่เปิดสอน
            </h1>
            <p class="text-white/70 font-light text-sm">
                ระดับปริญญาตรี คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
            </p>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($programs as $program)
                <div class="card border border-border-gray overflow-hidden flex flex-col h-full">
                    {{-- Hero gradient with optional image --}}
                    <div class="h-40 relative p-5 flex flex-col justify-end text-white overflow-hidden"
                         style="background: linear-gradient(to right, {{ $program->hero_color_from }}, {{ $program->hero_color_to }})">
                        @if($program->hero_image)
                            <img src="{{ asset('storage/' . $program->hero_image) }}"
                                 alt="{{ $program->title_th }}"
                                 class="absolute inset-0 w-full h-full object-cover opacity-30">
                        @endif
                        <div class="relative z-10">
                            <span class="text-[10px] text-white/60 tracking-wider uppercase font-bold block">{{ $program->degree_abbr_en }}</span>
                            <h3 class="font-prompt text-lg font-bold leading-snug">{{ $program->title_th }}</h3>
                        </div>
                    </div>

                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="badge badge-teal mb-3">{{ $program->degree_abbr_th }}</span>
                            @if($program->overview)
                                <p class="text-sm text-muted font-light mb-6 leading-relaxed">
                                    {{ \Illuminate\Support\Str::limit($program->overview, 120) }}
                                </p>
                            @else
                                <p class="text-sm text-muted font-light mb-6">
                                    {{ $program->title_en }}
                                </p>
                            @endif
                        </div>
                        <div class="flex justify-between items-center border-t border-border-gray pt-4">
                            <span class="text-xs text-navy font-semibold">
                                {{ $program->credits }} หน่วยกิต · {{ $program->duration_years }} ปี
                            </span>
                            <a href="{{ route('programs.detail', $program->slug) }}" class="text-xs font-bold text-teal hover:underline">
                                รายละเอียดหลักสูตร →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20 text-muted">
                    <p class="text-lg">ยังไม่มีหลักสูตรที่เปิดสอน</p>
                </div>
            @endforelse
        </div>
    </div>
</x-public-layout>
