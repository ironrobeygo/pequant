<form wire:submit.prevent="editQuiz" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

        <div class="block text-sm mb-4">
            <x-jet-label for="course" value="{{ __('Course') }}" />
            <x-jet-input id="course" class="block mt-1 w-full bg-gray-100" type="text" value="{{ $course->name }}" disabled/>
        </div>

        <div class="block text-sm mb-4">
            <x-jet-label for="chapter" value="{{ __('Chapter') }}" />
            <x-jet-input id="chapter" class="block mt-1 w-full bg-gray-100" type="text" value="{{ $chapter->name }}" disabled/>
        </div>
        
        <div class="block text-sm">
            <x-jet-label for="name" value="{{ __('Quiz Name') }}" />
            <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model="name" name="name" :value="old('name')" required autofocus autocomplete="name" />
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end mt-6">
            <x-jet-button>
                {{ __('Update quiz') }}
                <span class="ml-2" aria-hidden="true">+</span>
            </x-jet-button>
        </div>
    </div>
</form>