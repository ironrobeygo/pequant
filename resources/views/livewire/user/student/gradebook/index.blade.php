<div class="overflow-x-auto" x-data="{ 'isBatchMenuOpen': false, 'showEnrolmentModal': false, 'showUnenrolmentModal': false, 'showModal': false }">
    <div class="w-full">

        <div class="mb-4 mt-1 mx-1 flex justify-between items-center">
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
                    @if($scores->count > 0 )
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
                    @else
                    <tr>
                        <td class="py-3 px-6 text-center whitespace-nowrap align-top" colspan="4">
                            No data 
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
