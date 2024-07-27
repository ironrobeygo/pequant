<x-app-layout>
    <x-slot name="header">
        {{ __('Create unit') }}
        <a href="{{ route('courses.show', ['course' => $course->id]) }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-pequant-blue-600 border border-transparent rounded-lg active:pequant-blue-600 hover:pequant-blue-700 focus:outline-none">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
            Back to course
        </a>
    </x-slot>

    @livewire('courses.chapters.units.add', ['course' => $course, 'chapter' => $chapter])
</x-app-layout>
