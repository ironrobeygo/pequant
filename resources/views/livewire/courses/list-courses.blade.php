<div class="overflow-x-auto" x-data="{'showModal':false}">
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
                        <th class="py-3 px-6 text-left md:hidden sm:hidden">ID</th>
                        <th class="py-3 px-6 text-left">Course</th>
                        @role('admin')
                        <th class="py-3 px-6 text-left">Instructor</th>
                        @endrole
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Published</th>
                        <th class="py-3 px-6 text-left">Date Uploaded</th>
                        @role('admin')
                        <th class="py-3 px-6 text-left md:hidden sm:hidden">Author</th>
                        @endrole
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @if(!$courses->isEmpty())
                        @foreach($courses as $course)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-4 py-3 text-sm md:hidden sm:hidden">
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
                                {{ ($course->instructor ? $course->instructor->name : '-') }}
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
                            <td class="px-4 py-3 text-xs md:hidden sm:hidden">
                                {{ $course->user->firstName() }}
                            </td>
                            @endrole
                            <td class="py-3 px-6 text-center">
                                <ul class="flex justify-between">
                                    <li class="flex items-center">
                                        <a href="/courses/{{ $course->id }}" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-4 h-auto leading-4">
                                                <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM432 256c0 79.5-64.5 144-144 144s-144-64.5-144-144s64.5-144 144-144s144 64.5 144 144zM288 192c0 35.3-28.7 64-64 64c-11.5 0-22.3-3-31.6-8.4c-.2 2.8-.4 5.5-.4 8.4c0 53 43 96 96 96s96-43 96-96s-43-96-96-96c-2.8 0-5.6 .1-8.4 .4c5.3 9.3 8.4 20.1 8.4 31.6z"/>
                                            </svg>
                                        </a>
                                    </li> 
                                    @role('admin')
                                    <li class="flex items-center">
                                        <a wire:click.prevent="delete({{ $course->id }})" href="#" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-auto">
                                                <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                            </svg>
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <a wire:click.prevent="clone({{ $course->id }})" href="#" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-auto">
                                                <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path d="M0 448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H224c-53 0-96-43-96-96V160H64c-35.3 0-64 28.7-64 64V448zm224-96H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64z"/>
                                            </svg>
                                        </a>
                                    </li>
                                    @endrole
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td colspan="{{ auth()->user()->hasRole('admin') ? 4 : 6 }}" class="py-3 px-6 text-left whitespace-nowrap text-center">
                                You currently don't have any courses
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        {!! $courses->links() !!}
    </div>

    @if($showModal)
    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal()"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Are you sure you want to delete the course?
                            </h3>

                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" wire:click="confirmDelete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Yes, Delete
                    </button>
                    <button type="submit" wire:click="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>