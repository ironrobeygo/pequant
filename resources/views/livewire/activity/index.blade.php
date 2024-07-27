<div class="overflow-x-auto">
    <div class="w-full">

        <div class="mb-4 mt-1 mx-1 flex justify-between items-center">
            <input wire:model="search" class="w-1/3 pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white focus:border-pequant-blue-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="Search for user name" aria-label="Search">

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
                        <th class="py-3 px-6 text-left">Activity</th>
                        <th class="py-3 px-6 text-left">Date Created</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @if(!$activities->isEmpty())
                        @foreach($activities as $activity)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-4 py-3 text-sm">
                                {{ $activity->user->name }} {{ $activity->event }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $activity->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap text-center">
                                You currently don't have any activities
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        {!! $activities->links() !!}
    </div>
</div>
