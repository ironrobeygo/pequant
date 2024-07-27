<x-app-layout>
    <x-slot name="header">
        {{ __('Students') }}
        <div class="flex space-x-4">
            <a href="{{ route('students') }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-pequant-blue-600 border border-transparent rounded-lg active:pequant-blue-600 hover:pequant-blue-700 focus:outline-none">
                Back to students
                <span class="ml-2" aria-hidden="true">+</span>
            </a>
        </div>
    </x-slot>

    @livewire('user.student.show')
</x-app-layout>

