<div class="overflow-x-auto" x-data="{ 'isBatchMenuOpen': false, 'showEnrolmentModal': false, 'showUnenrolmentModal': false }">
    <div class="w-full">

        <div class="mb-4 mt-1 mx-1 flex justify-between items-center">
            <div class="flex w-1/2 space-x-4">
                <input wire:model="search" class="w-1/2 pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white focus:border-mohs-green-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="Search for students" aria-label="Search">

                <select class="inline-block text-sm focus:outline-none form-input" wire:model="institutionFilter">
                    <option>Institution Filter</option>
                    <option value="1">La Salle</option>
                    <option value="2">Ateneo</option>
                    <option value="3">Adamson</option>
                </select>

                <div class="relative">
                    <button class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none" @click="isBatchMenuOpen = true">
                        Batch Actions
                    </button>
                    <div x-show="isBatchMenuOpen">
                        <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="isBatchMenuOpen = false" @keydown.escape="isBatchMenuOpen = false" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md" aria-label="submenu">
                            <li class="flex">
                                <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800" href="/students/batch">
                                    Student Upload
                                </a>
                            </li>
<!--                             <li class="flex">
                                <a @click.prevent="isModalOpen = true" wire:click.prevent="showModalEnrolment" class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800" href="#">
                                    Enrol
                                </a>
                            </li>
                            <li class="flex">
                                <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800" href="/students/unenrol">
                                    Unenrol
                                </a>
                            </li> -->
                        </ul>
                    </div>
                </div>
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
                        <th class="py-3 px-6 text-left">Contact Number</th>
                        <th class="py-3 px-6 text-left">Institution</th>
                        <th class="py-3 px-6 text-left">Course(s)</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($students as $student)
                    <tr class="border-b border-gray-200 hover:bg-gray-100 align-top">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $student->id }}
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap align-top">
                            <p class="font-bold">{{ $student->name }}</p>
                            <span class="text-xs block">{{ $student->email }}</span>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap align-top">
                            {{ $student->contact_number }}
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap align-top">
                            {{ $student->institution->alias }}
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap align-top">
                            @if($student->studentCourses->count() > 0)
                                <ul>
                                @foreach($student->studentCourses as $course)
                                    <li>{{ $course->name }}</li>
                                @endforeach
                                </ul>
                            @else
                            <span class="text-center">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-center">
                            <ul class="flex justify-center">
                                <li>
                                    <a href="/students/{{ $student->id }}" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                        View
                                    </a>
                                </li> 
                                <li>
                                    <a href="/students/{{ $student->id }}/edit" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                        Edit
                                    </a>
                                </li> 
                                <li>
                                    <a href="#" @click.prevent="showEnrolmentModal = true" wire:click.prevent="showModalEnrolment({{ $student->id }})" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                        Enrol
                                    </a>
                                </li> 
                                <li>
                                    <a href="#" @click.prevent="showUnenrolmentModal = true" wire:click.prevent="showModalUnEnrolment({{ $student->id }})" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                        Unenrol
                                    </a>
                                </li>
                                <li>
                                    <a href="#" wire:click.prevent="userDelete({{ $student->id }})" class="w-4 mr-2 transform hover:text-mohs-orange-500 hover:scale-110">
                                        Edit
                                    </a>
                                </li> 
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $students->links() }}
    </div>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <div x-show="showEnrolmentModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Student Enrolment
                            </h3>
                            <div class="mt-2">
                                <select class="w-full inline-block text-sm focus:outline-none form-input" wire:model="selectedCourse">
                                    <option>Institution Filter</option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="processEnrolment" @click="showEnrolmentModal = false" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-mohs-green-600 text-base font-medium text-white hover:bg-mohs-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Process Enrolment
                    </button>
                    <button type="button" @click="showEnrolmentModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <div x-show="showUnenrolmentModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Unenrol Student
                            </h3>
                            <div class="mt-2">
                                <select class="w-full inline-block text-sm focus:outline-none form-input" wire:model="selectedCourse">
                                    <option>Institution Filter</option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="processUnEnrolment" @click="showUnenrolmentModal = false" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-mohs-green-600 text-base font-medium text-white hover:bg-mohs-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Remove Student
                    </button>
                    <button type="button" @click="showUnenrolmentModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
