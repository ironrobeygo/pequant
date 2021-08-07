<x-app-layout>
    <x-slot name="header">
        {{ __('Students') }}
        <div class="flex space-x-4">
            <a href="{{ route('students.add') }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none">
                Add Student
                <span class="ml-2" aria-hidden="true">+</span>
            </a>
        </div>
    </x-slot>

    @livewire('user.student.index')
</x-app-layout>

