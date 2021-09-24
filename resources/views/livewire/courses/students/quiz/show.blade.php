<div class="container mx-auto">
    <div class="flex -mx-4 sm:-mx-8 px-4 sm:px-8 overflow-x-auto space-x-4">
        <div class="w-3/4">
            <div class="mb-2">
                <div class="w-full -mx-4 sm:-mx-8 px-2 sm:px-8 pb-2 overflow-x-auto">
                    <div class="bg-white shadow-md rounded-md overflow-hidden p-5">
                        <form wire:submit.prevent="submitQuizScore">
                        <h2 class="font-bold text-lg mb-2">{{ $quiz->name }}</h2>
                            @foreach($questions as $question)
                            <div class="pb-2 mb-2">
                                <h3 class="font-bold mb-2 flex"><span>{!! $counter++ .'. ' .$question->question !!}</span></h3>
                                @if($question->type_id == 1)
                                    <ul>
                                    @php $answerType = $this->getAnswerCount($question->options) @endphp
                                    @foreach($question->options as $option)
                                        <li class="flex">
                                            @if($answerType == 'checkbox')
                                            <input type="checkbox" class="mt-1 mr-2" {{ in_array($option->id,json_decode($answers[$question->id]['answer'])) ? 'checked ' : '' }}disabled>
                                            @else
                                            <input type="radio" class="mt-1 mr-2" {{ in_array($option->id,json_decode($answers[$question->id]['answer'])) ? 'checked ' : '' }}disabled>
                                            @endif
                                            <span>{{ $option->value }}</span>
                                        </li>
                                    @endforeach
                                    </ul>
                                @endif

                                @if($question->type_id == 2)
                                <textarea class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" disabled>{{$answers[$question->id]['answer']}}</textarea>
                                @endif

                                @if($question->type_id == 3)
                                    <a href="{{ $student->getMedia('quiz')->where('id', $answers[$question->id]['answer'])->first()->getFullUrl() }}" target="_blank">Click to view</a>
                                @endif

                                <div class="mt-5 mb-5">
                                    <span class="block font-bold">Add Score <span class="text-sm italic">(Max Point: {{ $question->weight }})</span></span>
                                    <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1" type="number" name="submitScore[$answers[$question->id]['answer_id']]" wire:model.defer="submitScore.{{ $answers[$question->id]['answer_id'] }}">
                                </div>
                                    
                            </div>
                            @endforeach
                            <div class="flex justify-end mt-6">
                                <button type="submit" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none">Submit Score</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
