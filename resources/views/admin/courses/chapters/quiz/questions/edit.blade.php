<x-app-layout>
    <x-slot name="header">
        {{ __('Update question') }}
        <div class="flex justify-items space-x-2">
            <a href="{{ route('courses.chapters.quiz.show', ['course' => $course->id, 'chapter' => $chapter, 'quiz' => $quiz]) }}" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-pequant-blue-600 border border-transparent rounded-lg active:pequant-blue-600 hover:pequant-blue-700 focus:outline-none">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                Back to {{ $quiz->name }}
            </a>
        </div>
    </x-slot>

    @livewire('courses.chapters.quiz.questions.edit', ['course' => $course, 'chapter' => $chapter, 'quiz' => $quiz, 'question' => $question])
</x-app-layout>
