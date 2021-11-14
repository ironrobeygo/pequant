<div class="overflow-x-auto" x-data="{ 'isBatchMenuOpen': false, 'showEnrolmentModal': false, 'showUnenrolmentModal': false, 'showModal': false }">
    <div class="w-full">

        <div class="mb-4 mt-1 mx-1 flex justify-between items-center">
            <div class="flex w-2/3 space-x-4">
                <input wire:model="search" class="w-1/2 pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white focus:border-mohs-green-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="Search for students" aria-label="Search">

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
                        <th class="py-3 px-6 text-left">Name</th>
                        <th class="py-3 px-6 text-left">Due</th>
                        <th class="py-3 px-6 text-left">Score</th>
                        <th class="py-3 px-6 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($scores as $score)
                    <tr>
                        <td class="py-3 px-6 text-left whitespace-nowrap align-top">
                            <p class="font-bold">
                                <a href="/records/students/{{$user->id}}/quiz/{{$score->quiz->id}}" target="_blank">{{ $score->quiz->name }}</a>
                            </p>
                            <span class="text-xs block">{{ $score->quiz->chapter->course->name }}</span>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($score->quiz->expires_at)->format('M d, Y') }}
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $score->score }} / {{ $score->quiz->getQuizTotal() }} 
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {!! $score->completed == 0 ? '<span class="text-green-700 font-bold">Graded</span>' : '<span class="text-red-700 font-bold">Ungraded</span>' !!} {!! $score->retake == 1 ? ' <span class="text-xs italic">(Retake)</span> ' : '' !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
