<form wire:submit.prevent="editStudent" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

        <div class="block text-sm mb-2">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model="name" name="name" :value="old('name')" required autofocus autocomplete="name" />
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="block text-sm mb-2">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" class="block mt-1 w-full" wire:model="email" type="email" name="email" :value="old('email')" required />
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="block text-sm mb-2">
            <x-jet-label for="contact_number" value="{{ __('Contact Number') }}" />
            <x-jet-input id="contact_number" wire:model="contact_number" class="block mt-1 w-full" type="tel" name="contact_number" :value="old('contact_number')" />
            @error('contact_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="block text-sm mb-2">
            <x-jet-label for="institution_id" value="{{ __('Institution') }}" />
            <select id="institution_id" name="institution_id" wire:model="institution_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                <option value="">Select institution</option>
                @foreach($institutions as $institution)
                <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                @endforeach
            </select>
            @error('institution_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-button class="ml-4">
                {{ __('Edit Student') }}
                <span class="ml-2" aria-hidden="true">+</span>
            </x-jet-button>
        </div>

    </div>

</form>