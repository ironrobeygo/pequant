<form wire:submit.prevent="batchUser" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

        <div class="block text-sm mb-2">
            <x-jet-label for="batch_upload" value="{{ __('Upload csv file') }}" />
            <x-jet-input id="batch_upload" class="block mt-1 w-1/2" type="file" wire:model="batch_upload" name="batch_upload" :value="old('batch_upload')" required autofocus autocomplete="name" />
            @error('batch_upload') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-button class="ml-4">
                {{ __('Upload') }}
                <span class="ml-2" aria-hidden="true">+</span>
            </x-jet-button>
        </div>

    </div>

</form>