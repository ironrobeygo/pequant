<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
    <!-- Card -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Total institutions
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{ $institutions }}
            </p>
        </div>
    </div>
    <!-- Card -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Total Students
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{ $students }}
            </p>
        </div>
    </div>
    <!-- Card -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Total Courses
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{ $courses }}
            </p>
        </div>
    </div>
</div>

<div class="flex w-full space-x-4 mb-4">

    <div class="rounded overflow-hidden shadow-lg w-1/2">
        <div class="font-bold mb-2 bg-gray-200 text-gray-600 uppercase text-sm leading-normal py-3 px-6">Announcements</div>
        <div class="py-3 px-6">
            <ul>
                @foreach($announcements as $announcement)
                <li class="mb-2 border-b border-dashed pb-2">
                    <span class="font-bold block">{{ $announcement->name }} <span class="font-normal">by</span> {{ $announcement->user->id == auth()->user()->id ? 'You' : $announcement->user->name }} <span class="italic text-xs">({{ $announcement->created_at->diffForHumans() }})</span></span> 
                    <p class="text-gray-700 text-base text-justify">
                         {{ $announcement->announcement }}
                    </p>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="rounded overflow-hidden shadow-lg w-1/2">
        <div class="font-bold mb-2 bg-gray-200 text-gray-600 uppercase text-sm leading-normal py-3 px-6">Events Log</div>
        <div class="py-3 px-6">

            <ul>
                @foreach($activities as $activity)
                <li class="mb-2 border-b border-dashed pb-2 flex justify-between">
                    <span class="{{ $activity->event }}">
                        {{ $activity->user->id == auth()->user()->id ? 'You' : $activity->user->name }} {{ Str::limit($activity->event, 30) }}
                    </span>
                    <span class="italic text-xs">
                        {{ $activity->created_at->diffForHumans() }}
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>