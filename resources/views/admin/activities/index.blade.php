<x-app-layout>
    <x-slot name="header">
        {{ __('Activities') }}
    </x-slot>

    @livewire('activity.index')
</x-app-layout>
