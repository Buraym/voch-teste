<?php
    use \App\Models\Employee;
    $employee = Employee::find(request()->route('id'));
    if ($employee == null) {
        redirect("/employees");
    }
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="flex gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ url()->previous() }}" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            </a>
            Colaborador <i>{{ $employee->name }}</i>
        </h2>
    </x-slot>
    <div class="py-12">
        @livewire('update-employee', [
            'employee' => $employee
        ])
    </div>
</x-app-layout>
