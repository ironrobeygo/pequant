<x-course-view-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           {{$course->name}}
        </h2>
    </x-slot>

    @livewire('user.student.show', ['course' => $course])

</x-course-view-layout>
