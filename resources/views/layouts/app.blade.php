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
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body x-data="{ 'showModal': false, 'isSideMenuOpen': false, 'isPagesMenuOpen': false }">
        <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">

            {{-- <button @click="isSideMenuOpen = !isSideMenuOpen">Toggle Content</button> --}}

            @livewire('navigation-menu')

            <div class="flex flex-col flex-1 w-full">

                <main class="h-full overflow-y-auto">

                    <div class="lg:hidden container px-6 mx-auto mt-6 mb-3 grid">
                        <button class="w-4 h-auto" @click="isSideMenuOpen = !isSideMenuOpen">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/>
                            </svg>
                        </button>
                    </div>

                    <div class="container px-6 mx-auto mt-3 grid">
                        @if (isset($header))
                            <h2 class="lg:flex justify-between mb-3 text-2xl font-semibold text-gray-700 leading-normal">
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
        @stack('footerScripts')
        @include('sweet::alert')
        <!-- Scripts -->

        {{-- <script type="text/javascript">
            document.addEventListener("contextmenu", function(e){
                e.preventDefault();
            }, false);
        </script> --}}
        <script src="{{ mix('js/app.js') }}" defer></script>
    </body>
</html>
