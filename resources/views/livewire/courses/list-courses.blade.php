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
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Course</th>
                        @role('admin')
                        <th class="py-3 px-6 text-left">Instructor</th>
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
                            <td class="px-4 py-3 text-xs">
                                {{ $course->user->firstName() }}
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
                                        <a wire:click.prevent="delete({{ $course->id }})" href="#" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                            Delete
                                        </a>
                                    </li>
                                    <li>
                                        <a wire:click.prevent="clone({{ $course->id }})" href="#" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                            Clone
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