<x-app-layout>
    <x-slot name="header">
        {{ $course->name }}
        <div class="flex justify-items space-x-2">
	        <a href="{{ route('courses') }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none">
	            Add Chapter
	            <span class="ml-2" aria-hidden="true">+</span>
	        </a>
	        <a href="{{ route('courses') }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none">
	            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
	            Back to courses
	        </a>
        </div>
    </x-slot>

    @livewire('courses.show', ['course' => $course])

</x-app-layout>
