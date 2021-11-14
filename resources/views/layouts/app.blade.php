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

            @livewire('navigation-menu')

            <div class="flex flex-col flex-1 w-full">

                <main class="h-full overflow-y-auto">

                    <div class="container px-6 mx-auto grid">
                        @if (isset($header))
                            <h2 class="lg:flex justify-between mt-6 mb-3 text-2xl font-semibold text-gray-700 leading-normal">
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
        <script src="{{ mix('js/app.js') }}" defer></script>
    </body>
</html>
