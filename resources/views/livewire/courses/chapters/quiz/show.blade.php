<div class="overflow-x-auto">
    <div class="w-full">

        <div class="mb-4 mt-1 mx-1 flex justify-between items-center">
            <input wire:model="search" class="w-1/3 pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white focus:border-mohs-green-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="Search for courses name" aria-label="Search">

            <div class="flex justify-between">
                <span class="inline-block leading-normal text-sm font-semibold pt-2 pr-2">
                    Per Page:    
                </span>
                <select class="inline-block text-sm focus:outline-none form-input" wire:model="perPage">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                </select>
            </div>
        </div>

        <div class="bg-white shadow-md rounded mt-3 mb-6">
            <table class="min-w-max w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Question</th>
                        <th class="py-3 px-6 text-left">Type</th>
                        <th class="py-3 px-6 text-left">Author</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($quiz->questions as $question)
                        @if(auth()->user()->hasRole('admin') || auth()->user()->can('view', $question))
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-4 py-3 text-sm">
                                {{ $question->id }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {!! $question->question !!}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $question->type_id == 1 ? 'Multiple Choice' : 'Open Ended' }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if($question->user->id == auth()->user()->id)
                                    Me
                                @else
                                    {{ $question->user->firstName() }}
                                    @if($question->user->institution_id > 0)
                                        ({{$question->user->institution->alias}})
                                    @else
                                        (Admin)
                                    @endrole
                                @endif

                            </td>
                            <td class="px-4 py-3 text-sm">
                                @role('admin')
                                <span wire:click="updateStatus({{ $question->id }})" class="px-2 py-1 font-semibold leading-tight cursor-pointer {{ $question->active() ? ' text-green-700 bg-green-100' : 'text-orange-700 bg-orange-100' }} rounded-full">
                                    {{ $question->active() ? 'Approved' : 'Pending' }}
                                </span>
                                @else
                                <span class="px-2 py-1 font-semibold leading-tight {{ $question->active() ? ' text-green-700 bg-green-100' : 'text-orange-700 bg-orange-100' }} rounded-full">
                                    {{ $question->active() ? 'Approved' : 'Pending' }}
                                </span>
                                @endrole
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <ul class="flex space-x-2">
                                    <li>
                                        <a href="{{ route('courses.chapters.quiz.questions.show', ['course' => $course->id, 'chapter' => $chapter, 'quiz' => $quiz, 'question' => $question->id]) }}">View</a>
                                    </li>
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->can('update', $question))
                                    <li>
                                        <a href="{{ route('courses.chapters.quiz.questions.edit', ['course' => $course->id, 'chapter' => $chapter, 'quiz' => $quiz, 'question' => $question->id]) }}">Edit</a>
                                    </li>
                                    @endif
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->can('delete', $question))
                                    <li>
                                        <a wire:click.prevent="delete({{ $question->id }})" href="#">Delete</a>
                                    </li>
                                    @endif
                                </ul>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

