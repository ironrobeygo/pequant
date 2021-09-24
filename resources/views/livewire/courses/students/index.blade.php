<div class="overflow-x-auto">
    <div class="w-full">

        <div class="mb-4 mt-1 mx-1 flex justify-between items-center">
            <div class="flex w-1/2 space-x-4">
                <input wire:model="search" class="w-1/3 pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white focus:border-mohs-green-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="Search for students" aria-label="Search">

                @role('admin')
                <select class="inline-block text-sm focus:outline-none form-input" wire:model="institutionFilter">
                    <option>Institution Filter</option>
                    <option value="1">La Salle</option>
                    <option value="2">Ateneo</option>
                    <option value="3">Adamson</option>
                </select>
                @endrole
            </div>

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

        <div class="bg-white shadow-md rounded my-6">
            <table class="min-w-max w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Name</th>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-left">Section</th>
                        @role('admin')
                        <th class="py-3 px-6 text-left">Institution</th>
                        @endrole
                        <th class="py-3 px-6 text-left">Joined Date</th>
                        <th class="py-3 px-6 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @if($students->count() > 0)
                        @foreach($students as $student)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $student->id }}
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <a href="{{ route('courses.students.show', ['course' => $course->id, 'student' => $student]) }}">
                                   {{ $student->name }} 
                                </a>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $student->email }}
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $student->section }}
                            </td>
                            @role('admin')
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $student->institution_id > 0 ? $student->institution->name : '-' }}
                            </td>
                            @endrole
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $student->created_at }}
                            </td>
                            <td class="py-3 px-6 text-center">
<!--                                 <div class="relative pt-1">
                                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-mohs-orange-100">
                                        <div style="width:{{ rand(0, 100)  }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-mohs-orange-600"></div>
                                    </div>
                                </div> -->

                                <ul class="flex justify-center">
                                    <li>
                                        <a href="{{ route('courses.students.show', ['course' => $course, 'student' => $student]) }}" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                            Gradebook
                                        </a>
                                    </li> 
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap" colspan="8">
                                <p class="text-center">No student listed here</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        {{ $students->links() }}
    </div>
</div>
