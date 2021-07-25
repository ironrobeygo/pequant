<div class="container mx-auto">
    <div class="flex -mx-4 sm:-mx-8 px-4 sm:px-8 overflow-x-auto space-x-4">
        <div class="w-2/3 rounded-md overflow-hidden">
            {{ $course->description }}
        </div>
        <div class="w-1/3 bg-white shadow-md rounded-md overflow-hidden p-4">
            <ul>
                <li>
                    <span class="font-bold">Category:</span> {{ $course->category->name }}
                </li>
                <li>
                    <span class="font-bold block">Instructors:</span>
                    @foreach( $course->institutions as $institution )
                        <span class="block">{{ $institution->name }}</span>
                    @endforeach    
                </li>
                <li>
                    <span class="font-bold block">Instructors:</span>
                    @foreach( $course->instructors as $instructor )
                        <span class="block">{{ $instructor->name }}</span>
                    @endforeach             
                </li>
                <li>
                    <span class="font-bold">Date Created:</span> {{ $course->created_at->format('F d, Y') }}
                </li>
                <li>
                    <span class="font-bold">Date Updated:</span> {{ $course->updated_at->format('F d, Y') }}
                </li>
            </ul>
        </div>
    </div>

    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
        <div class="bg-white shadow-md rounded-md overflow-hidden">
            <div class="flex justify-between items-center px-5 py-3 text-gray-700 border-b">
                <h3 class="text-sm">Chapter</h3>
                <div>
                    <button class="mr-4 focus:outline-none" @click="accordion()">
                        <i :class="[showContent ? 'fas fa-chevron-up' : 'fas fa-chevron-down']"></i>
                    </button>
                    <button class="focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="px-5 py-6 bg-gray-200 text-gray-700">
            <div class="flex justify-between items-center py-3 text-gray-700 border-b">
                <h3 class="text-gray-700 text-2xl font-medium flex">asdfasdfasdf</h3>
                <div class="flex justify-end"></div>
            </div>
        </div>
    </div>

</div>
