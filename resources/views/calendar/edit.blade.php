<x-app-layout>
    <x-slot name="header">Event - Edit</x-slot>

    @livewire('calendar.edit', ['event' => $event])
</x-app-layout>
