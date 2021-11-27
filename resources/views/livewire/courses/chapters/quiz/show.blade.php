<div class="overflow-x-auto">
    <div class="w-full">

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
                <tbody id="sortableList" class="text-gray-600 text-sm font-light">
                    @if(count($questions) > 0)
                        @foreach($questions as $question)
                            @if(auth()->user()->hasRole('admin') || auth()->user()->can('view', $question))
                            <tr class="border-b border-gray-200 hover:bg-gray-100 draggable" data-id="{{ $question->id }}" data-order="{{ $question->order }}">
                                <td class="px-4 py-3 text-sm">
                                    {{ $question->id }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {!! substr(strip_tags($question->question), 0, 20) !!}...
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @switch($question->type_id)
                                        @case(1)
                                            Multiple Choice
                                        @break

                                        @case(2)
                                            Open Ended
                                        @break

                                        @case(3)
                                            File Upload
                                        @break

                                        @case(4)
                                            Identification
                                        @break
                                    @endswitch
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
                    @else
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td colspan="6" class="px-4 py-3 text-sm text-center">
                                No question added to this quiz yet
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script type="text/javascript">
    var el = document.getElementById('sortableList');
    new Sortable.create(el, {
        group: 'questions',
        animation: 150,
        filter: '.ignore-elements',
        draggable: '.draggable',
        onEnd: function (evt) {
            var itemEl = evt.item;  // dragged HTMLElement
            var newEl = evt.to;

            var questionOrder = itemEl.getAttribute('data-order');
            var questionId = itemEl.getAttribute('data-id');

            Livewire.emit('reOrderQuestion', { 'id': questionId, 'order': evt.newIndex + 1 });
        },
    });
</script>