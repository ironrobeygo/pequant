<div class="relative mt-2" x-data="{ showSticky: false }">
    <h2 class="font-semibold text-xl leading-loose text-gray-800 leading-tight flex justify-between mb-4">
       {{$course->name}}

        <a href="{{ $course->schedule->join_url }}" target="_blank" class="flex items-center justify-between px-4 py-3 cursor-pointer text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none">
            Join Live Class 
            <span class="ml-2" aria-hidden="true">+</span>
        </a>
    </h2>

    <div class="flex -mx-4 sm:-mx-8 px-4 sm:px-8 space-x-4">
        <div class="w-1/4 mb-2">
            <ul class="border border-b-1 border-t-0 border-r-0 border-l-0">
            @foreach($course->chapters as $chapter)
                <li>
                    <div class="px-4 py-5 border border-b-0">
                        {{ $chapter->name }}
                    </div>
                    <ul>
                        @foreach($chapter->units as $unit)
                        <li class="flex justify-between px-4 py-5 border border-b-0">
                            <a href="#" class="flex" wire:click.prevent="updateContent({{ $unit->id }}, 'unit')">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                {{ $unit->name }}
                            </a>

                            @if(in_array($unit->id, $visited))
                            <input type="checkbox" class="mt-1" wire:change="progressUpdate({{ $unit->id }})" {{ in_array($unit->id, $progress) ? 'checked' : '' }}>
                            @endif
                        </li>
                        @endforeach
                        @foreach($chapter->quizzes as $quiz)
                        <li>
                            <a href="#" class="flex px-4 py-5 border border-b-0" wire:click.prevent="updateContent({{ $quiz->id }}, 'quiz')">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $quiz->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach                
            </ul>
        </div>
        <div class="w-3/4">

            <div id="zoom-dev" x-show="showSticky" class="sticky top-0 w-full border border-gray-500 text-center top-0 left-0 mb-4 z-50">
                <iframe src="{{ $zoomSignature }}" width="100%" height="400px" allow="camera;microphone;cross-origin-isolated" style="border: none;"></iframe>
            </div>

            @if($title == '')

                <div class="text-center p-40 border border-gray-100 bg-gray-100">
                    <span class="inline-block m-auto">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </span>
                    <h1 class="text-2xl">Welcome to {{ $course->name }}</h1>     
                    <p>Please select a unit to start learning</p>               
                </div>

            @else

                @if($video != '')
                <iframe width="100%" height="500" src="https://www.youtube.com/embed/{{ $video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="mb-4"></iframe>
                @endif
                <div class="document-editor flex relative border border-gray-100 overflow-y-scroll flex-nowrap flex-col">
                    <div wire:loading class="absolute w-full h-screen text-center bg-gray-100 p-20 bg-opacity-75">Processing...</div>
                    <div class="document-editor__editable-container">
                        <div class="document-editor__editable">
                            @if(empty($questions))
                            <h2 class="font-bold text-lg mb-2">{{ $title }}</h2>
                            {!! $content !!}
                            @else
                            <form wire:submit.prevent="submitQuiz">
                            <h2 class="font-bold text-lg mb-2">{{ $title }}</h2>

                                @foreach($questions as $question)
                                <div class="pb-2 mb-2">
                                    <h3 class="font-bold mb-2 flex"><span>{{ $counter++.'.' }}</span> <span>{!! $question->question !!}</span></h3>
                                    @if($question->type_id == 1)
                                        <ul>
                                        @php $answerType = $this->getAnswerCount($question->options) @endphp
                                        @foreach($question->options as $option)
                                            <li class="flex">
                                                <input type="{{ $answerType }}" class="mt-1 mr-2" name="submitQuiz[{{ $question->quiz_id }}][{{ $question->id }}]" wire:model.defer="submitQuiz.{{$question->quiz_id}}.{{$question->id}}">
                                                <span>{{ $option->value }}</span>
                                            </li>
                                        @endforeach
                                        </ul>
                                    @endif

                                    @if($question->type_id == 2)
                                    <textarea class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" name="submitQuiz[{{ $question->quiz_id }}][{{ $question->id }}]" wire:model.defer="submitQuiz.{{$question->quiz_id}}.{{$question->id}}"></textarea>
                                    @endif

                                    @if($question->type_id == 3)
                                    <input type="file" name="submitQuiz[{{ $question->quiz_id }}][{{ $question->id }}]" wire:model.defer="submitQuiz.{{$question->quiz_id}}.{{$question->id}}">
                                    @endif
                                </div>
                                @endforeach
                                <div class="flex justify-end mt-6">
                                    <button type="submit" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none">Submit Quiz</button>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style type="text/css">
    .document-editor{
        max-height:  700px;
    }

    .document-editor__editable-container{
        padding: 25px;
        background-color:  rgb(250, 250, 250);
    }

    .document-editor__editable{
        width: 21cm;
        min-height: 21cm;
        padding: 2cm;
        border: 1px hsl(0, 0%, 82.7%) solid;
        background: white;
        box-shadow: 0 0 5px hsl(0deg 0% 0% / 10%);
        margin:  0 auto;
    }

</style>


<!-- <script type="text/javascript">
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
</script> -->