@push('scripts')
<script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>
@endpush

<div class="flex flex-1 w-full">

    <aside class="z-20 hidden w-1/5 overflow-y-auto bg-white md:block flex-shrink-0">
        <div class="text-gray-500 text-gray-400">
            <div class="p-4 bg-gray-700">
                <a href="{{ route('courses') }}" class="flex py-2 mb-4 text-xs font-medium leading-none text-white underline transition-colors duration-150 focus:outline-none">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                    Back to courses
                </a>
                <h2 class="font-semibold text-2xl text-white leading-tight">
                   {{$course->name}}
                </h2>  
            </div>

            <ul class="bg-gray-600 text-white">
                @foreach($course->chapters as $u => $chapter)
                    <li class="border border-b-0">
                        <div class="bg-mohs-green-600 text-white p-4 text-lg">
                           {{ $u + 1 .'. '.$chapter->name }} 
                        </div>
                        <ul>
                            @foreach($chapter->units as $unit)
                            <li>
                                <a href="#" class="block p-4 border border-gray-50 border-b-0" wire:click.prevent="updateContent({{ $unit->id }}, 'unit')">
                                    <span class="flex block">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        {{ $unit->name }}
                                    </span>
                                    <span class="block text-sm italic px-6 ml-1">
                                        unit
                                    </span>
                                </a>
                            </li>
                            @endforeach
                            @foreach($chapter->quizzes as $quiz)
                            <li>
                                <a href="#" class="block p-4 border border-b-0" wire:click.prevent="updateContent({{ $quiz->id }}, 'quiz')">
                                    <span class="flex block">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $quiz->name }}
                                    </span>
                                    <span class="block text-sm italic px-6 ml-1">
                                        quiz
                                    </span>
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>

    <div class="w-full p-4">

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
                        <h2 class="font-bold text-lg mb-2">{{ $title }}</h2>

                            @foreach($questions as $question)
                            <div>
                                <h3><p>{!! $counter++ .'. ' . str_replace('<p>', '', $question->question) !!}</h3>
                                @if($question->type_id == 1)
                                    <ul class="ml-5">
                                    @foreach($question->options as $option)
                                        <li>
                                            {{ $option->value }}
                                        </li>
                                    @endforeach
                                    </ul>
                                @endif

                                @if($question->type_id == 2)
                                <textarea></textarea>
                                @endif

                                @if($question->type_id == 3)
                                <textarea></textarea>
                                @endif
                            </div>
                            @endforeach

                        @endif
                    </div>
                </div>
            </div>

        @endif
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

<script>
    document.querySelectorAll( 'oembed[url]' ).forEach( element => {
        // Create the <a href="..." class="embedly-card"></a> element that Embedly uses
        // to discover the media.
        const anchor = document.createElement( 'a' );

        anchor.setAttribute( 'href', element.getAttribute( 'url' ) );
        anchor.className = 'embedly-card';

        element.appendChild( anchor );
    } );
</script>