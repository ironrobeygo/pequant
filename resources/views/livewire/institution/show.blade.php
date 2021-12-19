<div class="container mx-auto">
    <div class="bg-white shadow-md rounded mt-3 mb-6">
        <table class="min-w-max w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Course</th>
                    <th class="py-3 px-6 text-left">Instructor</th>
                    <th class="py-3 px-6 text-left">Recurring</th>
                    <th class="py-3 px-6 text-left">Schedule</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($schedules as $schedule)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $schedule->course->name }}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $schedule->course->instructor->name }}</td>
                    <td class="px-4 py-3 text-sm">{{ $schedule->showRecurrenceType() }}</td>
                    <td class="px-4 py-3 text-xs">Date here</td>
                    <td class="py-3 px-6 text-center">
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
