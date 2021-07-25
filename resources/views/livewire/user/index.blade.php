<div class="overflow-x-auto">
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
                            {{ $user->institution_id > 0 ? $user->institution->name : '-' }}
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $user->created_at }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <ul class="flex justify-center">
                                <li>
                                    <a href="/users/{{ $user->id }}/edit" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                        Edit
                                    </a>
                                </li> 
                                <li>
                                    <a href="/users/{{ $user->id }}" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
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
</div>
