@php
    use \App\Models\EconomicGroup;
    $query = app('request')->input('query');
    $groupsFound = app('request')->input('groupsFound') ? app('request')->input('groupsFound')
        : EconomicGroup::all()->map(fn($group) => [$group->id, $group->name])->toArray();
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Grupos econômicos @if ($query != "")
            com a palavra "{{$query}}"
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        @livewire('list-economic-groups', [
            'groupsFound' => $groupsFound,
            'query' => $query,
        ])
    </div>
</x-app-layout>
