<div class="mt-4">
    <input type="hidden" wire:model="instructor_ids">
    <x-jet-label for="instructors_id" value="{{ __('Instructors') }}" />
    <div class="flex flex-auto flex-wrap">
        @foreach($selectedInstructors as $index => $selInstructor)
        <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-teal-700 bg-teal-100 border border-teal-300 ">
            <div class="text-xs font-normal leading-none max-w-full flex-initial">{{ $selInstructor['name'] }}</div>
            <div class="flex flex-auto flex-row-reverse">
                <div wire:click="removeSelected({{ $index }})">
                    <svg class="fill-current h-6 w-6 " role="button" viewBox="0 0 20 20">
                        <path d="M14.348,14.849c-0.469,0.469-1.229,0.469-1.697,0L10,11.819l-2.651,3.029c-0.469,0.469-1.229,0.469-1.697,0 c-0.469-0.469-0.469-1.229,0-1.697l2.758-3.15L5.651,6.849c-0.469-0.469-0.469-1.228,0-1.697s1.228-0.469,1.697,0L10,8.183 l2.651-3.031c0.469-0.469,1.228-0.469,1.697,0s0.469,1.229,0,1.697l-2.758,3.152l2.758,3.15 C14.817,13.62,14.817,14.38,14.348,14.849z"></path>
                    </svg>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <select wire:change="selectinstructor($event.target.value)" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
        <option>Select instructor</option>
        @foreach($instructors as $index => $instructor)
        <option value="{{ $index }}">{{ $instructor['name'] }}</option>
        @endforeach
    </select>
    @error('instructor_id') <span class="error">{{ $message }}</span> @enderror
</div>