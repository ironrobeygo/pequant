<div class="mt-4">
    <x-jet-label for="instructors_id" value="{{ __('Instructors') }}" />
    <select wire:model="instructor_id" wire:change="selectinstructor" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
        <option>Select instructor</option>
        @foreach($instructors as $instructor)
        <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
        @endforeach
    </select>
    @error('instructor_id') <span class="error">{{ $message }}</span> @enderror
</div>