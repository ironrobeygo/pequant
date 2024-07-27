<div class="overflow-x-auto">
    <div class="w-full">

        <div class="mb-4 mt-1 mx-1 flex justify-between items-center">
            <input wire:model="search" class="w-1/3 pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white focus:border-pequant-blue-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="Search for announcements name" aria-label="Search">

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
                        <th class="py-3 px-6 text-left">Title</th>
                        <th class="py-3 px-6 text-left">Announcement</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        @role('admin')
                        <th class="py-3 px-6 text-left">Author</th>
                        @endrole
                        <th class="py-3 px-6 text-left">Date Created</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @if(!$announcements->isEmpty())
                        @foreach($announcements as $announcement)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-4 py-3 text-sm">
                                {{ $announcement->id }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $announcement->name }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ Str::limit($announcement->announcement, 50) }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span wire:click="updateStatus({{ $announcement->id }})" class="px-2 py-1 font-semibold leading-tight cursor-pointer {{ $announcement->active() ? ' text-green-700 bg-green-100' : 'text-orange-700 bg-orange-100' }} rounded-full">
                                    {{ $announcement->active() ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            @role('admin')
                            <td class="px-4 py-3 text-sm">
                                {{ $announcement->user->name }}
                            </td>
                            @endrole
                            <td class="px-4 py-3 text-sm">
                                {{ $announcement->created_at->diffForHumans() }}
                            </td>
                            <td class="px-4 py-3 text-sm">

                                <ul class="flex justify-center">
                                    <li>
                                        <a href="/announcements/{{ $announcement->id }}" class="w-4 mr-2 transform hover:text-pequant-orange-500 hover:scale-110">
                                            View
                                        </a>
                                    </li> 
                                    <li>
                                        <a href="/announcements/{{ $announcement->id }}/edit" class="w-4 mr-2 transform hover:text-pequant-orange-500 hover:scale-110">
                                            Edit
                                        </a>
                                    </li> 
                                    <li>
                                        <a wire:click.prevent="delete({{ $announcement->id }})" href="#" class="w-4 mr-2 transform hover:text-pequant-orange-500 hover:scale-110">
                                            Delete
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td colspan="{{ auth()->user()->hasRole('admin') ? 7 : 6 }}" class="py-3 px-6 text-left whitespace-nowrap text-center">
                                You currently don't have any announcements
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        {!! $announcements->links() !!}
    </div>
</div>
