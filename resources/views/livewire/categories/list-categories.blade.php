<div class="overflow-x-auto">
    <div class="w-full">
        <div class="bg-white shadow-md rounded my-6">
            <table class="min-w-max w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Category</th>
                        <th class="py-3 px-6 text-left">Description</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($categories as $category)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $category->name }}
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{ $category->description }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <ul class="flex justify-center">
                                <li>
                                    <a href="/categories/{{ $category->id }}/edit" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                        Edit
                                    </a>
                                </li> 
                                <li>
                                    <a href="/categories/{{ $category->id }}" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
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
        {!! $categories->links() !!}
    </div>
</div>
