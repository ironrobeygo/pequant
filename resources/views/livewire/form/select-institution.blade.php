<div class="mt-4">
    <x-jet-label for="institution_id" value="{{ __('Institutions') }}" />
    <select wire:model="institution_id" wire:change="selectInstitution" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
        <option>Select institution</option>
        @foreach($institutions as $institution)
        <option value="{{ $institution->id }}">{{ $institution->name }}</option>
        @endforeach
    </select>
    @error('institution_id') <span class="error">{{ $message }}</span> @enderror

</div>