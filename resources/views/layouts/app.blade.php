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

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body x-data="{ 'showModal': false }">
        <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">

            @livewire('navigation-menu')

            <div class="flex flex-col flex-1 w-full">

                @livewire('header-bar')

                <main class="h-full overflow-y-auto">

                    <div class="container px-6 mx-auto grid">
                        @if (isset($header))
                            <h2 class="flex justify-between mt-6 mb-3 text-2xl font-semibold text-gray-700 leading-normal">
                                {{ $header }}
                            </h2>
                        @endif

                        {{ $slot }}
                    </div>
                    
                </main>
            </div>

        </div>

        @stack('modals')

        @livewireScripts

        @include('sweet::alert')

        <script type="text/javascript">
 
            // Make the DIV element draggable:
            // dragElement(document.getElementById("zoom-dev"));

            // function dragElement(elmnt) {
            //     var pos1 = 0,
            //         pos2 = 0,
            //         pos3 = 0,
            //         pos4 = 0;
            //     if (document.getElementById(elmnt.id + "header")) {
            //         // if present, the header is where you move the DIV from:
            //         document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
            //     } else {
            //         // otherwise, move the DIV from anywhere inside the DIV:
            //         elmnt.onmousedown = dragMouseDown;
            //     }

            //     function dragMouseDown(e) {
            //         e = e || window.event;
            //         e.preventDefault();
            //         // get the mouse cursor position at startup:
            //         pos3 = e.clientX;
            //         pos4 = e.clientY;
            //         document.onmouseup = closeDragElement;
            //         // call a function whenever the cursor moves:
            //         document.onmousemove = elementDrag;
            //     }

            //     function elementDrag(e) {
            //         e = e || window.event;
            //         e.preventDefault();
            //         // calculate the new cursor position:
            //         pos1 = pos3 - e.clientX;
            //         pos2 = pos4 - e.clientY;
            //         pos3 = e.clientX;
            //         pos4 = e.clientY;
            //         // set the element's new position:
            //         elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
            //         elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
            //     }

            //     function closeDragElement() {
            //         // stop moving when mouse button is released:
            //         document.onmouseup = null;
            //         document.onmousemove = null;
            //     }
            // }
        </script>
    </body>
</html>
