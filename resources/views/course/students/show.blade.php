<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
        <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.7/css/bootstrap.css" />
        <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.7/css/react-select.css" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        @stack('scripts')

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        <style type="text/css">
            #zmmtg-root{
                display: none;
            }
            .document-container{
                border:  1px solid gray;
                display:  flex;
                flex-flow:  column nowrap;
                max-height: 600px;
            }
            .document-inner-container{
                padding:  20px;
                background:  gray;
                overflow-y: scroll;
            }
            .document-itself{
                overflow:  auto;
                background:  white;
                padding: 75px 75px 37px;
                width:  80%;
                margin:  0 auto;
            }

            #zoom-dev{
                z-index:  20;
                width:  599px;
                height: 631px;

            }

            #zoom-dev .divHeader{
                z-index:  21;
            }
        </style>


    </head>
    <body x-data="{ 'showModal': false }">
        <div class="flex h-screen bg-gray-50 dark:bg-gray-900">

            <div class="flex flex-col flex-1 w-full">

                @livewire('header-bar')

                <main class="h-full overflow-y-auto">

                    <div class="container px-6 mx-auto grid">

                        <div class="container mx-auto">
                            <div class="flex overflow-x-auto space-x-4">
                                <div class="w-1/4">
                                    <div class="w-full bg-white shadow-md rounded-md rounded-md overflow-hidden p-4 mt-6 mb-4">
                                        <ul>
                                            @foreach($course->chapters as $chapter)
                                            <li class="relative px-6 py-6 leading-none border-b border-gray-100">
                                                {{ $chapter->name }}
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div id="zoom-dev" x-show="showModal" class="absolute border border-gray-500 text-center">
                                        <div class="divHeader bg-mohs-green-500 text-white cursor-move text-2xl p-2">
                                            Live Class
                                        </div>
                                        <!-- <iframe src="http://127.0.0.1:9999/meeting.html?name=Um9iIEdv&mn=81248351779&email=&pwd=331004&role=0&lang=en-US&signature=X3lJQjh6cUtTSGVBVkZWcmdSTHZMdy44MTI0ODM1MTc3OS4xNjI3ODE4ODE4NDE2LjAuVDlkYURHanNuVVEwZ1doN0V3Zi9uMnBYdVZLU0h1aWRnMEdnRWlTU2F4cz0&china=0&apiKey=_yIB8zqKSHeAVFVrgRLvLw" width="100%" height="583px" allow="camera;microphone" style="border: none;"></iframe> -->
                                    </div>

                                </div>
                                <div class="w-3/4 mb-2">
                                    <h2 class="flex justify-between mt-6 mb-3 text-2xl font-semibold text-gray-700 leading-normal">
                                        {{ $course->name }}
                                        <a @click="showModal = true" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                                            Join Live Class
                                        </a>
                                    </h2>

                                    <div class="document-container">
                                        <div class="document-inner-container">
                                            <div class="document-itself">
                                                <h2 class="text-mohs-green-800 text-2xl mb-2 font-bold">
                                                    {{ $course->chapters[0]->name }}
                                                </h2> 
                                                {!! $course->chapters[0]->content !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                </main>
            </div>

        </div>

        <script src="https://source.zoom.us/1.9.7/lib/vendor/react.min.js"></script>
        <script src="https://source.zoom.us/1.9.7/lib/vendor/react-dom.min.js"></script>
        <script src="https://source.zoom.us/1.9.7/lib/vendor/redux.min.js"></script>
        <script src="https://source.zoom.us/1.9.7/lib/vendor/redux-thunk.min.js"></script>
        <script src="https://source.zoom.us/1.9.7/lib/vendor/lodash.min.js"></script>
        <script src="https://source.zoom.us/zoom-meeting-1.9.7.min.js"></script>

        <script type="text/javascript">
 
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

        @stack('modals')

        @livewireScripts
    </body>
</html>
