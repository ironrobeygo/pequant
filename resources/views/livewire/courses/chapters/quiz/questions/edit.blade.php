<form wire:submit.prevent="editQuestion" method="PATCH">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="block text-sm mb-4">
            <x-jet-label for="type_id" value="{{ __('Question Type') }}" />
            <select id="type_id" name="type_id" wire:model="type_id" wire:change="multipleChoice($event.target.value)" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                <option>Select question type</option>
                <option value="1">Multiple Choice</option>
                <option value="2">Open Ended Question</option>
            </select>
            @error('type_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="block text-sm mb-4">
            <x-jet-label for="questionValue" value="{{ __('Question') }}" />
            <textarea id="questionValue" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" wire:model="questionValue" name="questionValue" :value="old('questionValue')" autocomplete="off"></textarea>
            @error('questionValue') <span class="error">{{ $message }}</span> @enderror
        </div>

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
                            <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" type="text" name="options[{{ $index }}]['value']" wire:model="options.{{$index}}.value">
                        </td>
                        <td class="text-center">
                            <input type="checkbox" class="text-mohs-green-600 form-checkbox focus:border-mohs-green-400 focus:outline-none focus:shadow-outline-mohs-green dark:focus:shadow-outline-gray" name="options[{{$index}}]['answer']" wire:model="options.{{$index}}.answer">
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2">
                            <button wire:click.prevent="addOption" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-mohs-green-600 border border-transparent rounded-lg active:mohs-green-600 hover:mohs-green-700 focus:outline-none">
                                Add option
                                <span class="ml-2" aria-hidden="true">+</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>                    
        </div>

        <div class="flex justify-end mt-6">
            <x-jet-button>
                {{ __('Update question') }}
                <span class="ml-2" aria-hidden="true">+</span>
            </x-jet-button>
        </div>
    </div>
</form>