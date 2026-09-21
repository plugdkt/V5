<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0B2545] leading-tight font-prompt">
            {{ __('จัดการบทความวิชาการและผลงานวิจัย') }}
        </h2>
    </x-slot>

    @livewire('admin.academic-article-manager')
</x-admin-layout>
