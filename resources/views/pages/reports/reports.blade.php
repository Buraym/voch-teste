@php
    use \App\Models\Report;
    $query = app('request')->input('query');
    $reportsFound = app('request')->input('reportsFound') ? app('request')->input('reportsFound')
        : Report::all()->map(fn($report) => [$report->id, $report->name, date('d/m/Y - H:i:s', strtotime($report->created_at))])
        ->toArray();
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Reportes @if ($query != "")
            com a palavra "{{$query}}"
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        @livewire('list-reports', [
            'reportsFound' => $reportsFound,
            'query' => $query
        ])
    </div>
</x-app-layout>