<x-app-layout>
    <x-slot name="header">
        {{ $course->name . ' ' . __('Students') }}
    </x-slot>

    @livewire('courses.students.index', ['course' => $course])
</x-app-layout>
