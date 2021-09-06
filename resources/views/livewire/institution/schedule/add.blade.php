<form wire:submit.prevent="addSchedule" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

        <div class="block text-sm mb-2">
            <x-jet-label for="course_id" value="{{ __('Course') }}" />
            <select id="course_id" name="course_id" wire:model="course_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                <option value="">Select course</option>
                @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
            @error('course_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="block text-sm mb-2">
            <x-jet-label for="duration" value="{{ __('Duration') }}" />
            <select id="duration" name="duration" wire:model="duration" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                <option value="0">Select course</option>
                @foreach($duration_options as $option)
                <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
            @error('duration') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="block text-sm mb-2">
            <x-jet-label for="recurrence_type" value="{{ __('Recurrence Type') }}" />
            <select id="recurrence_type" name="recurrence_type" wire:model="recurrence_type" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                <option value="0">Select course</option>
                @foreach($recurrence_types as $key_type => $type)
                <option value="{{ $key_type }}">{{ $type }}</option>
                @endforeach
            </select>
            @error('recurrence_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="block text-sm mb-2">
            <x-jet-label for="recurrence_day" value="{{ __('Day') }}" />
            <select id="recurrence_day" name="recurrence_day" wire:model="recurrence_day" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                <option value="0">Select course</option>
                @foreach($recurrence_days as $key_day => $day)
                <option value="{{ $key_day }}">{{ $day }}</option>
                @endforeach
            </select>
            @error('recurrence_day') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="block text-sm">
            <x-jet-label for="recurrence_interval" value="{{ __('Interval') }}" />
            <x-jet-input id="recurrence_interval" class="block mt-1 w-full" type="text" wire:model="recurrence_interval" name="recurrence_interval" :value="old('length')" required />
            @error('recurrence_interval') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="block text-sm">
            <x-jet-label for="length" value="{{ __('Course Length') }}" />
            <x-jet-input id="length" class="block mt-1 w-full" type="text" wire:model="length" name="length" :value="old('length')" required />
            @error('length') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end mt-6">
            <x-jet-button>
                {{ __('Add Schedule') }}
                <span class="ml-2" aria-hidden="true">+</span>
            </x-jet-button>
        </div>
    </div>
</form>