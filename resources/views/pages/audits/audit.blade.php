<?php
    use \App\Models\AuditLog;
    use \App\Models\EconomicGroup;
    use \App\Models\Flag;
    use \App\Models\Unit;

    $audit = AuditLog::find(request()->route('id'));
    if ($audit == null) {
        redirect("/audits");
    }

    $oldEntities = [];

    $newEntities = [];

    $economicGroupAtributes = [
        "name" => "O nome do grupo"
    ];

    $flagAtributes = [
        "name" => "O nome da bandeira",
        "economic_group_id" => "O grupo econômico da bandeira"
    ];

    if ($audit->old_values != null && array_key_exists("economic_group_id", $audit->old_values)) {
        $oldEconomicGroup = EconomicGroup::withTrashed()->find($audit->old_values["economic_group_id"]);
        if ($oldEconomicGroup != null) {
            $oldEntities["economic_group_id"] = $oldEconomicGroup;
        }
        $newEconomicGroup = EconomicGroup::withTrashed()->find($audit->new_values["economic_group_id"]);
        if ($newEconomicGroup != null) {
            $newEntities["economic_group_id"] = $newEconomicGroup;
        }
    }

    $unitAtributes = [
        "name" => "O nome fantasia da unidade",
        "social" => "a razão social da unidade",
        "cnpj" => "O CNPJ da unidade",
        "flag_id" => "a bandeira da unidade",
    ];

    if ($audit->old_values != null && array_key_exists("flag_id", $audit->old_values)) {
        $oldFlag = Flag::withTrashed()->find($audit->old_values["flag_id"]);
        if ($oldFlag != null) {
            $oldEntities["flag_id"] = $oldFlag->name;
        }
        $newFlag = Flag::withTrashed()->find($audit->new_values["flag_id"]);
        if ($newFlag != null) {
            $newEntities["flag_id"] = $newFlag->name;
        }
    }

    $employeeAtributes = [
        "name" => "O nome do colaborador",
        "email" => "O email do colaborador",
        "cpf" => "O CPF do colaborador",
        "unit_id" => "A unidade do colaborador",
    ];

    if ($audit->old_values != null && array_key_exists("unit_id", $audit->old_values)) {
        $oldUnit = Unit::withTrashed()->find($audit->old_values["unit_id"]);
        if ($oldUnit != null) {
            $oldEntities["unit_id"] = $oldUnit->name;
        }
        $newunit = Unit::withTrashed()->find($audit->new_values["unit_id"]);
        if ($newunit != null) {
            $newEntities["unit_id"] = $newunit->name;
        }
    }
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="flex gap-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ url()->previous() }}" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            </a>
            Auditoria para
            @if ($audit->action == "created")
                criação
            @elseif ($audit->action == "updated")
                atualização
            @else remoção @endif
            de
            @if (class_basename($audit->model_type) == "EconomicGroup")
                Grupo econômico
            @elseif (class_basename($audit->model_type) == "Flag")
                Bandeira
            @elseif (class_basename($audit->model_type) == "Unit")
                Unidade
            @elseif (class_basename($audit->model_type) == "Employee")
                Colaborador
            @elseif (class_basename($audit->model_type) == "Report")
                Reporte
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex flex-col gap-2 justify-start items-start">
                <p class="text-base font-bold text-gray-400 dark:text-gray-400">
                    Autor de evento
                </p>
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    Foi o usuário "<i>{{ $audit->user }}</i>"
                </p>
                <p class="text-base font-bold text-gray-400 dark:text-gray-400">
                    Tipo de evento
                </p>
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    <i>
                        @if ($audit->action == "created")
                            Criação de recurso
                        @elseif ($audit->action == "updated")
                            Atualização de recurso
                        @else
                            Remoção de recurso
                        @endif
                    </i>
                </p>
                <p class="text-base font-bold text-gray-400 dark:text-gray-400">
                    Recurso
                </p>
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    <i>
                        @if (class_basename($audit->model_type) == "EconomicGroup")
                            Grupo econômico
                        @elseif (class_basename($audit->model_type) == "Flag")
                            Bandeira
                        @elseif (class_basename($audit->model_type) == "Unit")
                            Unidade
                        @elseif (class_basename($audit->model_type) == "Employee")
                            Colaborador
                        @elseif (class_basename($audit->model_type) == "Report")
                            Reporte
                        @endif
                    </i>
                </p>
                <p class="text-base font-bold text-gray-400 dark:text-gray-400">
                    Descrição
                </p>
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    No dia <i><strong>{{ date('d/m/Y', strtotime($audit->created_at)) }}</strong></i> ás <i><strong>{{ date('H:i:s', strtotime($audit->created_at)) }}</strong></i>,
                    o usuário "{{isset($audit->user) ? $audit->user->name : ""}}", {{lcfirst($audit->description)}}
                </p>
                @if ($audit->action == "updated")
                    <p class="text-base font-bold text-gray-400 dark:text-gray-400">
                        O que foi atualizado ?
                    </p>
                    <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                        @foreach ($audit->old_values as $key => $old_value)
                            @if ($key != "created_at" && $key != "updated_at" && $key != "deleted_at" && $key != "id")
                                @if (class_basename($audit->model_type) == "EconomicGroup")
                                    • <strong><i>{{ $economicGroupAtributes[$key] }}</i></strong>
                                @elseif (class_basename($audit->model_type) == "Flag")
                                    • <strong><i>{{ $flagAtributes[$key] }}</i></strong>
                                @elseif (class_basename($audit->model_type) == "Unit")
                                    • <strong><i>{{ $unitAtributes[$key] }}</i></strong>
                                @elseif (class_basename($audit->model_type) == "Employee")
                                    • <strong><i>{{ $employeeAtributes[$key] }}</i></strong>
                                @endif
                                foi trocado de 
                                @if (count($oldEntities) > 0 && count($newEntities) && array_key_exists($key, $oldEntities) && array_key_exists($key, $newEntities))
                                    <strong>"{{ $oldEntities[$key] }}"</strong> para <strong>"{{ $newEntities[$key] }}"</strong><br>
                                @else
                                    <strong>"{{ $old_value }}"</strong> para <strong>"{{ $audit->new_values[$key] }}"</strong><br>
                                @endif
                            @endif
                        @endforeach
                    </p>
                @endif
                @if (class_basename($audit->model_type) == "Report")
                    <p class=" text-sm text-gray-600 dark:text-gray-400">
                        <form method="POST" action="{{ route('reports.download', $audit->model_id) }}" class="bg-none">
                            @csrf
                                <x-secondary-button type="submit" class="text-white w-48 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 22 22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-down">
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"/>
                                        <path d="M12 18v-6"/>
                                        <path d="m9 15 3 3 3-3"/>
                                    </svg>
                                    Download do reporte
                                </x-secondary-button>
                        </form>
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
