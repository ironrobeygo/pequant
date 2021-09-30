<div class="overflow-x-auto" x-data="{'showModal':false}">
    <div class="w-full">
        <div class="bg-white shadow-md rounded my-6">
            <table class="min-w-max w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Name</th>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-left">Contact Number</th>
                        <th class="py-3 px-6 text-left">Role</th>
                        <th class="py-3 px-6 text-left">Institution</th>
                        <th class="py-3 px-6 text-left">Joined Date</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($users as $user)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $user->id }}
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $user->name }}
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $user->email }}
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $user->contact_number }}
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <ul>
                                @foreach($user->getRoleNames() as $role)
                                <li>{{ $role }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $user->institution_id > 0 ? !is_null($user->institution) ? $user->institution->alias : '-' : '-' }}
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <ul class="flex justify-center">
                                <li>
                                    <a href="/users/{{ $user->id }}/edit" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                        Edit
                                    </a>
                                </li> 
                                <li>
                                    <a @click.prevent="showModal = true" wire:click.prevent="delete({{ $user->id }})" href="#" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                        Delete
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {!! $users->links() !!}
    </div>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <div x-show="showModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Are you sure you want to delete the user?
                            </h3>

                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="confirmDelete" @click="showModal = false" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Yes, Delete
                    </button>
                    <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
