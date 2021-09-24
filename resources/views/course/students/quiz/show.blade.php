<x-app-layout>
    <x-slot name="header">
        {{ $student->name }}
    </x-slot>

    @livewire('courses.students.quiz.show', ['course' => $course, 'student' => $student, 'quiz' => $quiz])
</x-app-layout>
