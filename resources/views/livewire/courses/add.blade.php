<form wire:submit.prevent="addCourse" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="block text-sm">
            <x-jet-label for="name" value="{{ __('Course Name') }}" />
            <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model="name" name="name" :value="old('name')" required autofocus autocomplete="name" />
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <x-jet-label for="category_id" value="{{ __('Categories') }}" />
            <select id="category_id" name="category_id" wire:model="category_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                <option>Select a category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        @livewire('form.select-institution')
        @livewire('form.select-instructor')

        <div class="block mt-4 text-sm">
            <x-jet-label for="instructors" value="{{ __('Course Description') }}" />
            <textarea class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" wire:model="description" rows="3" placeholder="Enter some long form content." ></textarea>
            @error('description') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end mt-6">
            <x-jet-button>
                {{ __('Add Course') }}
                <span class="ml-2" aria-hidden="true">+</span>
            </x-jet-button>
        </div>
    </div>
</form>