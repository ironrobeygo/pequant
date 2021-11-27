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
    </head>
    <body x-data="{ 'showModal': false, 'isSideMenuOpen': false, 'isPagesMenuOpen': false }" oncopy="return false">

        <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">

            {{ $slot }}

        </div>

        @stack('modals')

        @livewireScripts

        <script type="text/javascript">
            // Disable Right click
            document.addEventListener('contextmenu', event => event.preventDefault());

            // Disable key down
            document.onkeydown = disableSelectCopy;

            // Disable mouse down
            document.onmousedown = dMDown;

            // Disable click
            document.onclick = dOClick;

            function dMDown(e) { return false; }

            function dOClick() { return true; }

            function disableSelectCopy(e) {
                // current pressed key
                var pressedKey = String.fromCharCode(e.keyCode).toLowerCase();
                if ((e.ctrlKey && (pressedKey == "c" || pressedKey == "x" || pressedKey == "v" || pressedKey == "a" || pressedKey == "u")) ||  e.keyCode == 123) {
                    return false;
                }
            }        
        </script>
    </body>
</html>
