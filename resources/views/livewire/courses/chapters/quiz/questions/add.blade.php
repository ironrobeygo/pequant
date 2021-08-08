<form wire:submit.prevent="addQuestion" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="block text-sm mb-4">
            <x-jet-label for="type_id" value="{{ __('Question type') }}" />
            <select id="type_id" name="type_id" wire:model="type_id" wire:change="multipleChoice($event.target.value)" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                <option>Select question type</option>
                <option value="1">Multiple Choice</option>
                <option value="2">Open Ended Question</option>
                <option value="3">Open Ended Question, File Upload</option>
            </select>
            @error('type_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="block text-sm mb-4">
            <x-jet-label for="question" value="{{ __('Question') }}" />
            <textarea id="question" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" wire:model="question" name="question" :value="old('question')" autocomplete="off"></textarea>
            @error('question') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="block text-sm mb-4">
            <x-jet-label for="weight" value="{{ __('Question weight') }}" />
            <x-jet-input id="weight" class="block mt-1 w-full" type="text" wire:model="weight" name="weight" :value="old('weight')"/>
            @error('weight') <span class="error">{{ $message }}</span> @enderror
        </div>

        @if($showOptionsForm)
        <div class="block text-sm">
            <table class="w-full" id="options">
                <thead>
                    <tr>
                        <th class="text-left">Options</th>
                        <th>Answer</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($options as $index => $option)
                    <tr>
                        <td>
                            <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" type="text" name="options[{{ $index }}]['value']" wire:model.defer="options.{{$index}}.value">
                        </td>
                        <td class="text-center">
                            <input type="checkbox" class="text-mohs-green-600 form-checkbox focus:border-mohs-green-400 focus:outline-none focus:shadow-outline-mohs-green dark:focus:shadow-outline-gray" name="options[{{$index}}]['answer']" wire:model.defer="options.{{$index}}.answer">
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="pt-4">
                            <button wire:click.prevent="addOption" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none">
                                Add option
                                <span class="ml-2" aria-hidden="true">+</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>                    
        </div>
        @endif

        <div class="flex justify-end mt-6">
            <x-jet-button>
                {{ __('Add Question') }}
                <span class="ml-2" aria-hidden="true">+</span>
            </x-jet-button>
        </div>
    </div>
</form>