<x-app-layout>
    <x-slot name="header">
        {{ __('Announcements') }}
        <a href="{{ route('announcements.add') }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-pequant-blue-600 border border-transparent rounded-lg active:pequant-blue-600 hover:pequant-blue-700 focus:outline-none">
            Add Announcement
            <span class="ml-2" aria-hidden="true">+</span>
        </a>
    </x-slot>

    @livewire('announcement.index')
</x-app-layout>
