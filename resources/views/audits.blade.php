@php
    use \App\Models\AuditLog;
    $query = app('request')->input('query');
    $auditsFound = app('request')->input('auditsFound') ? app('request')->input('auditsFound')
        : AuditLog::all()
            ->map(fn($audit) => [
                $audit->id,
                isset($audit->user) ? $audit->user->name : "",
                $audit->description,
                date('d/m/Y - H:i:s', strtotime($audit->created_at))
            ])
            ->toArray();
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Auditorias
        </h2>
    </x-slot>
    <div class="py-12">
        @livewire('list-audits', [
            'auditsFound' => $auditsFound,
            'query' => $query,
        ])
    </div>
</x-app-layout>