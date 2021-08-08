<x-app-layout>
    <x-slot name="header">
        {{ $student->name }}
    </x-slot>

    @livewire('courses.students.show', ['course' => $course, 'student' => $student])
</x-app-layout>
