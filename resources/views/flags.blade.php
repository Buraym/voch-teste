@php
    use \App\Models\Flag;
    $query = app('request')->input('query');
    $flagsFound = app('request')->input('flagsFound') ? app('request')->input('flagsFound')
        : Flag::all()->map(fn($group) => [$flag->id, $flag->name, $flag->economic_group_id])->toArray();
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Bandeiras @if ($query != "")
            com a palavra "{{$query}}"
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        @livewire('list-flags', [
            'flagsFound' => $flagsFound,
            'query' => $query,
        ])
    </div>
</x-app-layout>
