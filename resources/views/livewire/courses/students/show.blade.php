<div class="container mx-auto">
    <div class="flex -mx-4 sm:-mx-8 px-4 sm:px-8 overflow-x-auto space-x-4">
        <div class="w-3/4">
            @if($course->chapters->count() > 0)
                @foreach($course->chapters as $key => $chapter)
                    <div class="mb-2">
                        <div class="-mx-4 sm:-mx-8 px-2 sm:px-8 py-2 overflow-x-auto">
                            <div class="bg-white shadow-md rounded-md overflow-hidden">
                                <div class="flex justify-between items-center px-5 py-3 text-gray-700 border-b">
                                    <h3 class="text-l">Chapter {{ $key + 1 }} : {{ $chapter->name }}</h3>
                                </div>
                                @if($chapter->content)
                                <div class="w-full px-5 py-3">
                                    {{ $chapter->content }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @foreach($chapter->units as $u => $unit)
                            <div class="flex">
                                <span class="inline-block pt-3 mr-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </span>
                                <div class="w-full -mx-4 sm:-mx-8 px-2 sm:px-8 pb-2 overflow-x-auto">
                                    <div class="bg-white shadow-md rounded-md overflow-hidden">
                                        <div class="flex justify-between items-center px-5 py-3 text-gray-700 border-b">
                                            <h3 class="text-l">{{ $unit->name }}</h3>

                                            @if(in_array($unit->id, $student->studentProgressCompleted()))
                                            <div class="flex">
                                                <span class="text-sm italic text-mohs-green-500">
                                                    Completed in {{ number_format($student->getCompletionTime($unit->id)->duration / 60, 2) }} hour(s)
                                                </span>
                                            </div>
                                            @endif

                                            @if($unit->type == 'quiz')

                                                @if( $student->getQuizScore($unit->id) !== false && $student->getQuizScore($unit->id)->completed == 0)
                                                <span class="px-2 py-1 font-semibold leading-tight text-mohs-green-700 bg-mohs-green-100 rounded-full">
                                                    Completed
                                                </span>
                                                @elseif( $student->getQuizScore($unit->id) === false )
                                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                                    Not submitted
                                                </span>
                                                @else
                                                <a href="{{ route('courses.students.quiz.show', ['course' => $course, 'student' => $student, 'quiz' => $unit]) }}" class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                                                    Submitted
                                                </a>
                                                @endif
                                            @endif
                                        </div>
                                        @if($unit->type == 'quiz')
                                        <div class="w-full px-5 py-3">
                                            @php
                                                $quizTotal = \App\Models\Quiz::find($unit->id)->getQuizTotal();
                                            @endphp
                                            Score: {{ $student->getQuizScore($unit->id) !== false ? $student->getQuizScore($unit->id)->score : 0 }}/{{ $quizTotal }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <p>This course doesn't have a chapter yet!</p>
            @endif
        </div>
        <div class="w-1/4 mb-2">
            <div class="w-full bg-white shadow-md rounded-md rounded-md overflow-hidden p-4 mb-4">
                <ul>
                    <li class="mb-2">
                        <span class="font-bold">Course:</span> {{ $course->name }}
                    </li>
                    <li class="mb-2">
                        <span class="font-bold">Category:</span> {{ $course->category->name }}
                    </li>
                    @role('admin')
                    <li class="mb-2">
                        <span class="font-bold block">Instructors:</span>
                    </li>
                    @endrole
                    <li class="mb-2">
                        <span class="font-bold">Date Created:</span> {{ $course->created_at->format('F d, Y') }}
                    </li>
                    <li class="mb-2">
                        <span class="font-bold">Date Updated:</span> {{ $course->updated_at->format('F d, Y') }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
