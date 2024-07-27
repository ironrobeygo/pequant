<div class="overflow-x-auto">
    <div class="w-full">
        <div class="mb-4 mt-1 mx-1 flex justify-between items-center">
            <input wire:model="search" class="w-1/3 pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white focus:border-pequant-blue-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="Search for courses, id or author" aria-label="Search">

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
                        <th class="py-3 px-6 text-left">Institutions</th>
                        <th class="py-3 px-6 text-left">Students</th>
                        <th class="py-3 px-6 text-left">Zoom Account</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @if(!$institutions->isEmpty())
                        @foreach($institutions as $institution)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-4 py-3 text-sm">
                                {{ $institution->id }}
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $institution->name }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $institution->students->count() }}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                {{ $institution->zoom_email }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                <ul class="flex justify-center">
                                    <li>
                                        <a href="/institutions/{{ $institution->id }}" class="w-4 mr-2 transform hover:text-pequant-orange-500 hover:scale-110">
                                            View
                                        </a>
                                    </li> 
                                    <li>
                                        <a href="/institutions/{{ $institution->id }}/edit" class="w-4 mr-2 transform hover:text-pequant-orange-500 hover:scale-110">
                                            Edit
                                        </a>
                                    </li> 
                                    <li>
                                        <a wire:click.prevent="delete({{ $institution->id }})" class="w-4 mr-2 transform hover:text-pequant-orange-500 hover:scale-110 cursor-pointer">
                                            Delete
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td colspan="4" class="py-3 px-6 text-left whitespace-nowrap text-center">
                                You currently don't have any institutions
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        {!! $institutions->links() !!}
    </div>
</div>
