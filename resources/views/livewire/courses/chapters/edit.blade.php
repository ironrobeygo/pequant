<form wire:submit.prevent="editChapter" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="block text-sm">
            <x-jet-label for="name" value="{{ __('Chapter Name') }}" />
            <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model="name" name="name" :value="old('name')" required autofocus autocomplete="name" />
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div wire:ignore class="block mt-4 text-sm">
            <x-jet-label for="instructors" value="{{ __('Chapter Description') }}" />

            <textarea class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" wire:model="content" name="content">{{ $content }}</textarea>
            @error('content') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end mt-6">
            <x-jet-button>
                {{ __('Update Chapter') }}
                <span class="ml-2" aria-hidden="true">+</span>
            </x-jet-button>
        </div>
    </div>
</form>