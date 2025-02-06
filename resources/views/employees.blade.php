@php
    use \App\Models\Employee;
    $query = app('request')->input('query');
    $employeesFound = app('request')->input('employeesFound') ? app('request')->input('employeesFound')
        : Employee::all()
            ->map(fn($employee) => [$employee->id, $employee->name, $employee->email, $employee->cpf, $employee->unit->name])
            ->toArray();
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Colaboradores @if ($query != "")
            com a palavra "{{$query}}"
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        @livewire('list-employees', [
            'employeesFound' => $employeesFound,
            'query' => $query,
        ])
    </div>
</x-app-layout>