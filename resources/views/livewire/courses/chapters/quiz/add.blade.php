
<form wire:submit.prevent="addQuiz" method="POST">
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
        
        <div class="block text-sm mb-4">
            <x-jet-label for="name" value="{{ __('Quiz Name') }}" />
            <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model="name" name="name" :value="old('name')" required autofocus autocomplete="name" />
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="block text-sm">
            <x-jet-label for="name" value="{{ __('Expiration Date') }}" />
            <x-jet-input id="expiration" class="block mt-1 w-full" type="text" wire:model="expiration" name="expiration" :value="old('expiration')" onchange="this.dispatchEvent(new InputEvent('input'))" required autofocus autocomplete="expiration" />
            @error('expiration') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end mt-6">
            <x-jet-button>
                {{ __('Add Quiz') }}
                <span class="ml-2" aria-hidden="true">+</span>
            </x-jet-button>
        </div>
    </div>
</form>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script type="text/javascript">
    $(function () {
        $('#expiration').datepicker();

        $('#expiration').on('change', function (e) {
               @this.set('expiration', e.target.value);
        });
    });
</script>