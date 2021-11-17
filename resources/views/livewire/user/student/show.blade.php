@push('scripts')
<script charset="utf-8" src="//cdn.iframe.ly/embed.js?api_key=4697f747519ca5b0c22b50"></script>
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
                    <li class="border border-b-0" x-data="{show:false}">
                        <div class="bg-mohs-green-600 text-white p-4 text-lg cursor-pointer" @click="show=!show">
                           {{ $u + 1 .'. '.$chapter->name }} 
                        </div>
                        <ul x-show="show">
                            @foreach($chapter->units as $unit)
                            <li class="flex p-4 border-b">
                                <span>
                                    @if($unit->type == 'unit')
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    @endif
                                    @if(in_array($unit->id, $visited))
                                    <input type="checkbox" class="leading-loose ml-1 mr-2 z-50" wire:change="progressUpdate({{ $unit->id }})" {{ in_array($unit->id, $progress) ? 'checked' : '' }}>
                                    @endif
                                </span>
                                <a href="#" class="block" wire:click.prevent="updateContent({{ $unit->id }}, '{{ $unit->type }}')">
                                    <span>
                                        {{ $unit->name }}
                                    </span>
                                    <span class="block text-sm italic">
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

        @if($title == '')

            @if($course->description == '')
            <div class="text-center p-40">
                <span class="inline-block m-auto">
                    <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </span>
                <h1 class="text-2xl">Welcome to {{ $course->name }}</h1>     
                <p>Please select a unit to start learning</p>               
            </div>
            @else
            <div class="py-40 px-20">
                <div class="text-center">
                    <span class="inline-block m-auto">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </span>
                    <h1 class="text-2xl">Welcome to {{ $course->name }}</h1> 
                </div>
                {!! $course->description !!}
            </div>
            @endif

        @elseif($status != '')

            <div class="text-center p-40 border border-gray-100 bg-gray-100">
                <span class="inline-block m-auto">
                    <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
                <h1 class="text-2xl">{{ $status }}</h1>     
                <p class="mb-4">{{ $quizMessage }}</p>

                @if($showRetake)    
                    <a href="#" wire:click.prevent="retakeQuiz({{$currentQuiz->id}})" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none">Retake Quiz</a> 
                @endif
            </div>

            <div class="flex justify-between">
                @if(!is_null($previous))
                <a href="#"  wire:click.prevent="updateContent({{ $previous['id'] }}, '{{ $previous['type'] }}')" class="bg-mohs-green-500 hover:bg-mohs-green-700 text-white font-bold py-2 px-4 rounded">
                    Previous
                </a>
                @endif
                @if(!is_null($next))
                <a href="#"  wire:click.prevent="updateContent({{ $next['id'] }}, '{{ $next['type'] }}')" class="bg-mohs-green-500 hover:bg-mohs-green-700 text-white font-bold py-2 px-4 rounded">
                    Next
                </a>
                @endif
            </div>   

        @else

            <div class="document-editor flex relative border border-gray-100 overflow-y-scroll flex-nowrap flex-col">
                <div class="document-editor__editable-container">

                    <div class="document-editor__editable">
                        @if(empty($questions))
                        <h2 class="font-bold text-lg mb-2">{{ $title }}</h2>
                        <div class="ck-content">
                            {!! $content !!}
                        </div>
                        @else
                        <form wire:submit.prevent="submitQuiz">
                        <h2 class="font-bold text-lg mb-2">{{ $title }}</h2>
                            @if($currentQuiz->isExpired())
                                <p class="text-red-500">This quiz has already expired!</p>
                            @elseif(count($questions) == 0 )
                                <p>No questions added for this quiz yet. Please come back later.</p>
                            @else
                                @foreach($questions as $question)
                                <div class="pb-2 mb-2">
                                    <h3 class="font-bold mb-2 flex"><span class="mr-1 inline-block">{{ $counter++.'.' }}</span> {!! strip_tags($question->question, "<p>") !!}</h3>
                                    @if($question->type_id == 1)
                                        <ul>
                                        @php $answerType = $this->getAnswerCount($question->options) @endphp
                                        @foreach($question->options as $option)
                                            <li class="flex">
                                                @if($answerType == 'checkbox')
                                                <input type="checkbox" class="mt-1 mr-2" name="submitQuiz[{{ $question->quiz_id }}][{{ $question->id }}][{{$option->id}}]" wire:model.defer="submitQuiz.{{$question->quiz_id}}.{{$question->id}}.{{$option->id}}">
                                                @else
                                                <input type="radio" class="mt-1 mr-2" name="submitQuiz[{{ $question->quiz_id }}][{{ $question->id }}][]" wire:model.defer="submitQuiz.{{$question->quiz_id}}.{{$question->id}}.0" value="{{$option->id}}">
                                                @endif
                                                <span>{{ $option->value }}</span>
                                            </li>
                                        @endforeach
                                        </ul>
                                    @endif

                                    @if($question->type_id == 2)
                                    <textarea class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" name="submitQuiz[{{ $question->quiz_id }}][{{ $question->id }}]" wire:model.defer="submitQuiz.{{$question->quiz_id}}.{{$question->id}}"></textarea>
                                    @endif

                                    @if($question->type_id == 3)
                                    <input type="file" name="submitQuiz['attachments'][{{ $question->quiz_id }}][{{ $question->id }}]" wire:model.defer="submitQuiz.attachments.{{$question->quiz_id}}.{{$question->id}}">
                                    @endif
                                </div>
                                @endforeach
                                <div class="flex justify-end mt-6">
                                    <button type="submit" wire:loading.attr="disabled" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none">Submit Quiz</button>
                                </div>
                            @endif
                        </form>
                        @endif
                    </div>

                    <div class="flex justify-between">
                        @if(!is_null($previous))
                        <a href="#"  wire:click.prevent="updateContent({{ $previous['id'] }}, '{{ $previous['type'] }}')" x-on:click.document="document.getByElementId('document-editor__editable-container').scrollTo(0, 0)" class="bg-mohs-green-500 hover:bg-mohs-green-700 text-white font-bold py-2 px-4 rounded">
                            Previous
                        </a>
                        @endif
                        @if(!is_null($next))
                        <a href="#"  wire:click.prevent="updateContent({{ $next['id'] }}, '{{ $next['type'] }}')" x-on:click.document="document.getByElementId('document-editor__editable-container').scrollTo(0, 0)"  class="bg-mohs-green-500 hover:bg-mohs-green-700 text-white font-bold py-2 px-4 rounded">
                            Next
                        </a>
                        @endif
                    </div>     
                </div>
            </div>
        @endif
    </div>
</div>

<link rel="stylesheet" type="text/css" href="{{ asset('ckeditor/style.css') }}">
<script charset="utf-8" src="//cdn.iframe.ly/embed.js?api_key=4697f747519ca5b0c22b50"></script>

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
        padding: 2cm;
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
</script>