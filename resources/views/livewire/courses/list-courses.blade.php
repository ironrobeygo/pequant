<div class="overflow-x-auto">
    <div class="w-full">

        <div class="mb-4 mt-1 mx-1 flex justify-between items-center">
            <input wire:model="search" class="w-1/3 pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white focus:border-mohs-green-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="Search for courses name" aria-label="Search">

            <div class="flex justify-between">
                <span class="inline-block leading-normal text-sm font-semibold pt-2 pr-2">
                    Per Page:    
                </span>
                <select class="inline-block text-sm focus:outline-none form-input" wire:model="perPage">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                </select>
            </div>
        </div>

        <div class="bg-white shadow-md rounded mt-3 mb-6">
            <table class="min-w-max w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Course</th>
                        @role('admin')
                        <th class="py-3 px-6 text-left">Institutions</th>
                        <th class="py-3 px-6 text-left">Instructors</th>
                        @endrole
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Published</th>
                        <th class="py-3 px-6 text-left">Date Uploaded</th>
                        @role('admin')
                        <th class="py-3 px-6 text-left">Author</th>
                        @endrole
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @if(!$courses->isEmpty())
                        @foreach($courses as $course)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-4 py-3 text-sm">
                                {{ $course->id }}
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <p class="font-semibold">
                                    <a href="/courses/{{ $course->id }}">{{ ucfirst($course->name) }}</a>
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ $course->category->name }}
                                </p>
                            </td>
                            @role('admin')
                            <td class="px-4 py-3 text-sm">
                                <ul>
                                    @foreach($course->institutions as $institution)
                                    <li>{{ $institution->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <ul>
                                    @foreach($course->instructors as $instructor)
                                    <li>{{ $instructor->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            @endrole
                            <td class="px-4 py-3 text-xs">
                                @role('admin')
                                <span wire:click="updateStatus({{ $course->id }})" class="px-2 py-1 font-semibold leading-tight cursor-pointer {{ $course->active() ? ' text-green-700 bg-green-100' : 'text-orange-700 bg-orange-100' }} rounded-full">
                                    {{ $course->active() ? 'Active' : 'Inactive' }}
                                </span>
                                @else
                                <span class="px-2 py-1 font-semibold leading-tight {{ $course->active() ? ' text-green-700 bg-green-100' : 'text-orange-700 bg-orange-100' }} rounded-full">
                                    {{ $course->active() ? 'Active' : 'Inactive' }}
                                </span>
                                @endrole
                            </td>
                            <td class="px-4 py-3 text-xs">
                                @role('admin')
                                <span wire:click="updateIsOnline({{ $course->id }})" class="px-2 py-1 font-semibold leading-tight cursor-pointer {{ $course->isOnline() ? ' text-green-700 bg-green-100' : 'text-orange-700 bg-orange-100' }} rounded-full">
                                    {{ $course->isOnline() ? 'Online' : 'Offline' }}
                                </span>
                                @else
                                <span class="px-2 py-1 font-semibold leading-tight {{ $course->isOnline() ? ' text-green-700 bg-green-100' : 'text-orange-700 bg-orange-100' }} rounded-full">
                                    {{ $course->isOnline() ? 'Online' : 'Offline' }}
                                </span>
                                @endrole
                            </td>
                            <td class="px-4 py-3 text-xs">
                                {{ $course->created_at->format('F d, Y') }}
                            </td>
                            @role('admin')
                            <td class="px-4 py-3 text-xs">
                                {{ $course->user->name }}
                            </td>
                            @endrole
                            <td class="py-3 px-6 text-center">
                                <ul class="flex justify-center">
                                    <li>
                                        <a href="/courses/{{ $course->id }}" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                            View
                                        </a>
                                    </li> 
                                    @role('admin')
                                    <li>
                                        <a href="/courses/{{ $course->id }}/edit" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                            Edit
                                        </a>
                                    </li> 
                                    <li>
                                        <a href="/courses/{{ $course->id }}" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                            Delete
                                        </a>
                                    </li>
                                    @endrole
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td colspan="4" class="py-3 px-6 text-left whitespace-nowrap text-center">
                                You currently don't have any courses
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        {!! $courses->links() !!}
    </div>
</div>
