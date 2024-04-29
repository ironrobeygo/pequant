@push('scripts')
<script charset="utf-8" src="//cdn.iframe.ly/embed.js?api_key=4697f747519ca5b0c22b50"></script>
@endpush

<div class="flex flex-1 w-full" x-data="{isCourseMenuOpen: @entangle('courseMenuOpen') }">

    <aside class="z-20 hidden w-1/5 overflow-y-auto bg-white lg:block flex-shrink-0">
        <div class="text-gray-500 text-gray-400">
            <div class="p-4 bg-gray-700">
                <div class="flex justify-between">
                    <a href="{{ route('courses') }}" class="flex py-2 mb-4 text-xs font-medium leading-none text-white underline transition-colors duration-150 focus:outline-none">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                        Back to courses
                    </a>
                    @if( !is_null($event) )
                    <a href="{{ $event->url }}" class="bg-mohs-green-500 hover:bg-mohs-green-700 text-white font-bold py-2 px-4 rounded mb-4 text-center text-xs" target="_blank">Join Online Class</a>
                    @endif
                </div>
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
                            <li class="{{ $unit->id == $currentId || $unit->id == $currentId ? 'bg-mohs-orange-500' : '' }}">
                                <a href="#" class="block p-4 border border-gray-50 border-b-0" wire:click.prevent="updateContent({{ $unit->id }}, '{{ $unit->type }}')">
                                    <span class="flex block">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        {{ $unit->name }}
                                    </span>
                                    <span class="block text-sm italic px-6 ml-1">
                                        {{ $unit->type }}
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

    <aside aside class="fixed inset-y-0 z-20 flex-shrink-0 w-3/5 overflow-y-auto bg-white lg:hidden" x-show="isCourseMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="isCourseMenuOpen=false" @keydown.escape="isCourseMenuOpen=false">
        <div class="text-gray-500 text-gray-400">
            <div class="p-4 bg-gray-700">
                <div class="flex justify-between">
                    <a href="{{ route('courses') }}" class="flex py-2 mb-4 text-xs font-medium leading-none text-white underline transition-colors duration-150 focus:outline-none">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                        Back to courses
                    </a>
                    @if( !is_null($event) )
                    <a href="{{ $event->url }}" class="bg-mohs-green-500 hover:bg-mohs-green-700 text-white font-bold py-2 px-4 rounded mb-4 text-center text-xs" target="_blank">Join Online Class</a>
                    @endif
                </div>
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
                            <li class="{{ $unit->id == $currentId || $unit->id == $currentId ? 'bg-mohs-orange-500' : '' }}">
                                <a href="#" class="block p-4 border border-gray-50 border-b-0" wire:click.prevent="updateContent({{ $unit->id }}, '{{ $unit->type }}')">
                                    <span class="flex block">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        {{ $unit->name }}
                                    </span>
                                    <span class="block text-sm italic px-6 ml-1">
                                        {{ $unit->type }}
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

    <div class="w-full p-4 border border-gray-100 bg-gray-100">

        <div class="lg:hidden container px-6 mx-auto mt-6 mb-3 grid">
            <button class="w-4 h-auto" @click="isCourseMenuOpen = !isCourseMenuOpen">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/>
                </svg>
            </button>
        </div>

        @if($title == '')
            <div class="flex h-screen">
                @if($course->description == '')
                    <div class="text-center w-2/3 m-auto">
                        <span class="inline-block m-auto">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </span>
                        <h1 class="text-2xl mb-4">Welcome to {{ $course->name }}</h1> 
                        <p>Please select a unit to start learning</p>               
                    </div>
                

                @else
                <div class="py-40 px-20">
                    <div class="text-center">
                        <span class="inline-block m-auto">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </span>
                        <h1 class="text-2xl mb-4">Welcome to {{ $course->name }}</h1> 
                    </div>
                    <div class="max-w-full ck-content text-justify">
                        {!! $course->description !!}    
                    </div>
                </div>
                @endif
            </div>

        @else
            <div id="document-editor" class="document-editor flex relative border border-gray-100 overflow-y-scroll flex-nowrap flex-col">
                <div wire:loading class="absolute w-full h-screen text-center bg-gray-100 p-20 bg-opacity-75">Processing...</div>
                <div class="document-editor__editable-container">
                    <div class="max-w-full ck-content document-editor__editable">
                        @if(empty($questions))
                        <h2 class="font-bold text-lg mb-2">{{ $title }}</h2>
                        <div class="max-w-full ck-content">
                            {!! $content !!}
                        </div>
                        @else
                        <h2 class="font-bold text-lg mb-2">{{ $title }}</h2>
                            @if(!empty($questions))
                                <ol class="list-decimal">
                                @foreach($questions as $question)
                                <li class="mb-4">
                                    <div>
                                        {!! $question->question !!}
                                    </div>
                                    
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
                                    <textarea class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"></textarea>
                                    @endif

                                    @if($question->type_id == 3)
                                    <input type="file">
                                    @endif
                                </li>
                                @endforeach
                                </ol>
                            @else
                                <p>No questions assigned to this quiz yet</p>
                            @endif

                        @endif
                    </div>
                </div>

                <div class="flex justify-between">
                    @if(!is_null($previous))
                    <a href="#"  wire:click.prevent="updateContent({{ $previous['id'] }}, '{{ $previous['type'] }}')" x-on:click="scrollIntoViewContent()" class="bg-mohs-green-500 hover:bg-mohs-green-700 text-white font-bold py-2 px-4 rounded">
                        Previous
                    </a>
                    @endif
                    @if(!is_null($next))
                    <a href="#"  wire:click.prevent="updateContent({{ $next['id'] }}, '{{ $next['type'] }}')" x-on:click="scrollIntoViewContent()" class="bg-mohs-green-500 hover:bg-mohs-green-700 text-white font-bold py-2 px-4 rounded">
                        Next
                    </a>
                    @endif
                </div>  
            </div>

        @endif
    </div>

</div>

<link rel="stylesheet" type="text/css" href="{{ asset('ckeditor/style.css') }}">

<style type="text/css">
    .document-editor{
        max-height:  100%;
    }

    .document-editor__editable-container{
        padding: 25px;
        background-color:  rgb(250, 250, 250);
    }

    .document-editor__editable{
        width: 21cm;
        min-height: 21cm;
        padding: 1cm;
        border: 1px hsl(0, 0%, 82.7%) solid;
        background: white;
        box-shadow: 0 0 5px hsl(0deg 0% 0% / 10%);
        margin:  0 auto;
    }

    figure.media{
        margin-top: 20px;
        margin-bottom:  20px;
    }

    .document-editor__editable p{
        margin-bottom:  20px;
    }

    .ck-content p,
    .ck-content ol{
        margin-bottom:  20px;
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        Livewire.hook('element.initialized', (el, component) => {
            if(el.tagName == 'OEMBED'){
                iframely.load( el, el.getAttribute('url') );
            }
            
        });
    });

    function scrollIntoViewContent(){
        document.getElementById('document-editor').scroll({top:0,behavior:'smooth'});
    }
</script>