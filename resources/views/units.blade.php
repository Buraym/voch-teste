@php
    use \App\Models\Unit;
    $query = app('request')->input('query');
    $unitsFound = app('request')->input('unitsFound') ? app('request')->input('unitsFound')
        : Unit::all()->map(fn($unit) => [$unit->id, $unit->name, $unit->social, $unit->cnpj, $unit->flag->name])->toArray();
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Unidades @if ($query != "")
            com a palavra "{{$query}}"
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        @livewire('list-units', [
            'unitsFound' => $unitsFound,
            'query' => $query,
        ])
    </div>
</x-app-layout>
