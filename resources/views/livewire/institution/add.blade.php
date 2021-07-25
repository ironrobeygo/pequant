<form wire:submit.prevent="addInstitution" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="block text-sm">
            <x-jet-label for="name" value="{{ __('Institution') }}" />
            <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model="name" name="name" :value="old('name')" required autofocus autocomplete="name" />
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <x-jet-label for="zoom_email" value="{{ __('Zoom Email') }}" />
            <x-jet-input id="zoom_email" class="block mt-1 w-full" type="text" wire:model="zoom_email" name="zoom_email" :value="old('zoom_email')" autofocus autocomplete="zoom_email" />
            @error('zoom_email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <x-jet-label for="zoom_api" value="{{ __('Zoom Email') }}" />
            <x-jet-input id="zoom_api" class="block mt-1 w-full" type="text" wire:model="zoom_api" name="zoom_api" :value="old('zoom_api')" autofocus autocomplete="zoom_api" />
            @error('zoom_api') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <x-jet-label for="zoom_secret" value="{{ __('Zoom Email') }}" />
            <x-jet-input id="zoom_secret" class="block mt-1 w-full" type="text" wire:model="zoom_secret" name="zoom_secret" :value="old('zoom_secret')" autofocus autocomplete="zoom_secret" />
            @error('zoom_secret') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end mt-6">
            <x-jet-button>
                {{ __('Add Institution') }}
                <span class="ml-2" aria-hidden="true">+</span>
            </x-jet-button>
        </div>
    </div>
</form>