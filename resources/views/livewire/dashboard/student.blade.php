<div class="container mx-auto mb-20">
    <div class="mx-auto relative w-32 h-32 mt-20 mb-3">
        <img class="rounded-full border border-gray-100 shadow-sm" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
    </div>
    <div class="text-center mb-20">
        <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
        <h3 class="text-lg">{{ $user->institution->name }}</h3>
    </div>

    <div class="flex w-full space-x-4 mb-4">

        <div class="rounded overflow-hidden shadow-lg w-1/2">
            <div class="font-bold mb-2 bg-gray-200 text-gray-600 uppercase text-sm leading-normal py-3 px-6">Announcements</div>
            <div class="py-3 px-6">
                <ul>
                    @if(!empty($announcements))
                    @foreach($announcements as $announcement)
                    <li class="mb-2 border-b border-dashed pb-2">
                        <span class="font-bold block">{{ $announcement->name }} <span class="font-normal">by</span> {{ $announcement->user->id == auth()->user()->id ? 'You' : $announcement->user->name }} <span class="italic text-xs">({{ $announcement->created_at->diffForHumans() }})</span></span> 
                        <p class="text-gray-700 text-base text-justify">
                            {{ $announcement->announcement }}
                        </p>
                    </li>
                    @endforeach
                    @else
                    <li class="mb-2 border-b border-dashed pb-2">
                        <p class="text-gray-700 text-base text-justify">
                            There are no current announcements, please check back later.
                        </p>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="rounded overflow-hidden shadow-lg w-1/2">
            <div class="font-bold mb-2 bg-gray-200 text-gray-600 uppercase text-sm leading-normal py-3 px-6">Course(s) Progress</div>
            <div class="py-3 px-6">
                <ul>
                    @foreach($user->studentCourses as $course)
                    @php $progress = $user->studentProgress($course->id); @endphp
                    <li class="text-gray-700 text-base">
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                    <a href="{{ route('courses.show', ['course' => $course]) }}" class="font-semibold inline-block py-1 px-2 uppercase rounded-full">
                                        {{ $course->name }}
                                    </a>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-semibold inline-block text-mohs-orange-100">
                                        {{$progress}}%
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-mohs-orange-200">
                                <div style="width:{{$progress}}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-mohs-orange-500"></div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

<!--     <div class="flex w-full space-x-4">

        <div class="rounded overflow-hidden shadow-lg w-1/2">
            <div class="font-bold mb-2 bg-gray-200 text-gray-600 uppercase text-sm leading-normal py-3 px-6">Completed Units</div>
            <div class="py-3 px-6">

                <ul>
                    @foreach($user->studentRecentProgress() as $recent)
                        @if($recent->unit)
                        <li class="text-gray-700 text-base flex justify-between border-b border-dashed mb-4">
                            <span>
                                {{ $recent->unit->name }}
                            </span>
                            <span class="text-xs italic">
                                {{ $recent->updated_at->diffForHumans() }}
                            </span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

    </div> -->

</div>
