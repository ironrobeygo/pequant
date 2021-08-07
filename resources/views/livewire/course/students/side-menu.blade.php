<aside class="z-20 hidden w-64 overflow-y-auto bg-white md:block flex-shrink-0">
    <div class="py-4 text-gray-500 text-gray-400">
        <x-jet-authentication-card-logo />
        <ul class="mt-6">
            <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                  <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="ml-4">{{ __('Dashboard') }}</span>
            </x-jet-nav-link>
        </ul>

        <ul>
            @foreach($course->chapters as $chapter)
            <li class="relative px-6 py-6 leading-none border-b border-gray-100">
                {{ $chapter->name }}
            </li>
            @endforeach
        </ul>

    </div>
</aside>