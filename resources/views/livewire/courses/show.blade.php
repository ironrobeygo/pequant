<div class="container mx-auto" x-data="{ showLiveZoom: false }">
    <div class="flex -mx-4 sm:-mx-8 px-4 sm:px-8 overflow-x-auto space-x-4">
        <div class="w-3/4">
            @if($course->chapters->count() > 0)
                @foreach($course->chapters as $key => $chapter)
                    <div class="mb-2">
                        <div class="-mx-4 sm:-mx-8 px-2 sm:px-8 py-2 overflow-x-auto">
                            <div class="bg-white shadow-md rounded-md overflow-hidden">
                                <div class="flex justify-between items-center px-5 py-3 text-gray-700 border-b">
                                    <h3 class="text-l">Chapter {{ $key + 1 }} : {{ $chapter->name }}</h3>
                                    <ul class="flex space-x-2">
                                        <li>
                                            <a href="{{ route('courses.chapters.show', ['course' => $course->id, 'chapter' => $chapter->id]) }}" class="px-2 py-1 font-semibold leading-tight cursor-pointer hover:text-white hover:bg-yellow-500 rounded-full text-sm">View</a>
                                        </li>
                                        @role('admin')
                                        <li>
                                            <a href="{{ route('courses.chapters.units.add', ['course' => $course->id, 'chapter' => $chapter->id]) }}" class="px-2 py-1 font-semibold leading-tight cursor-pointer hover:text-white hover:bg-mohs-green-500 rounded-full text-sm">Add Unit</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('courses.chapters.quiz.add', ['course' => $course->id, 'chapter' => $chapter->id]) }}" class="px-2 py-1 font-semibold leading-tight cursor-pointer hover:text-white hover:bg-mohs-green-500 rounded-full text-sm">Add Quiz</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('courses.chapters.edit', ['course' => $course->id, 'chapter' => $chapter->id]) }}" class="px-2 py-1 font-semibold leading-tight cursor-pointer hover:text-white hover:bg-mohs-green-500 rounded-full text-sm">Edit</a>
                                        </li>
                                        <li>
                                            <a href="#" wire:click.prevent="deleteChapter({{$chapter->id}})" class="px-2 py-1 font-semibold leading-tight cursor-pointer hover:text-white hover:bg-red-500 rounded-full text-sm">Delete</a>
                                        </li>
                                        @endrole
                                    </ul>
                                </div>
                                @if($chapter->content)
                                <div class="w-full px-5 py-3">
                                    {{ $chapter->content }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <ul class="sortableList" data-chapter_id="{{ $chapter->id }}">
                        @foreach($chapter->units as $u => $unit)
                            <li class="flex" data-order="{{ $unit->order }}" data-unit_id="{{ $unit->id }}">
                                <span class="inline-block pt-3 mr-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </span>
                                <div class="w-full -mx-4 sm:-mx-8 px-2 sm:px-8 pb-2 overflow-x-auto">
                                    <div class="bg-white shadow-md rounded-md overflow-hidden">
                                        <div class="flex justify-between items-center px-5 py-3 text-gray-700 border-b">
                                            <h3 class="text-l">
                                                {{ $unit->name }}
                                                <span class="text-xs italic block">Unit {{$unit->order}}</span>
                                            </h3>
                                            <ul class="flex space-x-2">
                                                @role('admin')
                                                <li>
                                                    <a href="{{ route('courses.chapters.units.edit', ['course' => $course->id, 'chapter' => $chapter->id, 'unit' => $unit->id]) }}" class="px-2 py-1 font-semibold leading-tight cursor-pointer hover:text-white hover:bg-mohs-green-500 rounded-full text-sm">Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#" wire:click.prevent="deleteUnit({{$unit->id}})" class="px-2 py-1 font-semibold leading-tight cursor-pointer hover:text-white hover:bg-red-500 rounded-full text-sm">Delete</a>
                                                </li>
                                                @endrole
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        @foreach($chapter->quizzes as $k => $quiz)
                            <li class="flex">
                                <span class="inline-block pt-3 mr-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </span>
                                <div class="w-full -mx-4 sm:-mx-8 px-2 sm:px-8 pb-2 overflow-x-auto">
                                    <div class="bg-white shadow-md rounded-md overflow-hidden">
                                        <div class="flex justify-between items-center px-5 py-3 text-gray-700 border-b">
                                            <h3 class="text-l">
                                                {{ $quiz->name }}
                                                <span class="text-xs italic block">Quiz</span>
                                            </h3>
                                            <ul class="flex space-x-2">
                                                <li>
                                                    <a href="{{ route('courses.chapters.quiz.show', ['course' => $course->id, 'chapter' => $chapter->id, 'quiz' => $quiz->id]) }}" class="px-2 py-1 font-semibold leading-tight cursor-pointer hover:text-white hover:bg-yellow-500 rounded-full text-sm">View</a>
                                                </li>
                                                @role('admin')
                                                <li>
                                                    <a href="{{ route('courses.chapters.quiz.edit', ['course' => $course->id, 'chapter' => $chapter->id, 'quiz' => $quiz->id]) }}" class="px-2 py-1 font-semibold leading-tight cursor-pointer hover:text-white hover:bg-mohs-green-500 rounded-full text-sm">Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#" wire:click.prevent="deleteQuiz({{ $quiz->id }})" class="px-2 py-1 font-semibold leading-tight cursor-pointer hover:text-white hover:bg-red-500 rounded-full text-sm">Delete</a>
                                                </li>
                                                @endrole
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                @endforeach
            @else
                <p>This course doesn't have a chapter yet!</p>
            @endif
        </div>
        <div class="w-1/4 mb-2">
            @hasanyrole('admin|instructor')
            <a wire:click.prevent="hostZoomLive" x-on:click="showLiveZoom = true" class="flex items-center justify-between px-4 py-3 mb-4 cursor-pointer text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none">
                Host Live Class 
                <span class="ml-2" aria-hidden="true">+</span>
            </a>
            @endhasanyrole
            <div class="w-full bg-white shadow-md rounded-md rounded-md overflow-hidden p-4 mb-4">
                <ul>
                    <li class="mb-2">
                        <span class="font-bold">Category:</span> {{ $course->category->name }}
                    </li>
                    @role('admin')
                    <li class="mb-2">
                        <span class="font-bold block">Instructor:</span>
                        <span class="block">{{ $course->instructor->name }}</span>
                    </li>
                    <li class="mb-2">
                        <span class="font-bold block">Institution:</span>
                        <span class="block">({{$course->institution->alias}})</span>
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

            @hasanyrole('instructor|admin')
            <div class="w-full bg-white shadow-md rounded-md rounded-md overflow-hidden p-4">
                <p class="text-center text-l">Students Enrolled</p>
                <p class="text-center text-8xl font-bold my-5">{{ $count }}</p>
                <p class="text-center">
                    <a href="{{ route('courses.students', ['course' => $course]) }}" class="w-1/2 mx-auto text-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none">
                        Enrolled Student(s)
                    </a>
                </p>
            </div>
            @endhasanyrole

            <div id="zoom-dev" x-show="showLiveZoom" class="absolute border border-gray-500 text-center">
                <div class="divHeader bg-mohs-green-500 text-white cursor-move text-2xl p-2" style="width: 606px;">
                    Live Class
                </div>
                <iframe src="{{ $zoomSignature }}" width="100%" height="583px" allow="camera;microphone" style="border: none;"></iframe>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script type="text/javascript">
    var nestedSortables = document.querySelectorAll('.sortableList');
    // List with handle
    for (var i = 0; i < nestedSortables.length; i++) {
        new Sortable.create(nestedSortables[i], {
            group: 'units',
            animation: 150,
            onEnd: function (evt) {
                var itemEl = evt.item;  // dragged HTMLElement
                var newEl = evt.to;

                var unitOrder = itemEl.getAttribute('data-order');
                var unitId = itemEl.getAttribute('data-unit_id');
                var chapterId = newEl.getAttribute('data-chapter_id');

                Livewire.emit('reOrderUnit', { 'unitId': unitId, 'order': evt.newIndex + 1, 'chapterId': chapterId });
            },
        });
    }

    // Make the DIV element draggable:
    dragElement(document.getElementById("zoom-dev"));

    function dragElement(elmnt) {
        var pos1 = 0,
            pos2 = 0,
            pos3 = 0,
            pos4 = 0;
        if (document.getElementById(elmnt.id + "header")) {
            // if present, the header is where you move the DIV from:
            document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
        } else {
            // otherwise, move the DIV from anywhere inside the DIV:
            elmnt.onmousedown = dragMouseDown;
        }

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            // get the mouse cursor position at startup:
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            // call a function whenever the cursor moves:
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            // calculate the new cursor position:
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;
            // set the element's new position:
            elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
            elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
        }

        function closeDragElement() {
            // stop moving when mouse button is released:
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }
</script>
