@php
    use \App\Models\Unit;
    $units = Unit::all()->map(fn($unit) => [$unit->id, $unit->name])->toArray();
@endphp
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex justify-between items-center">
        <form method="POST" action="{{ route("employees.store") }}" class="flex flex-col gap-2">
            @csrf
                <x-input-label for="name" value="Nome completo" class="sr-only" />
                <x-text-input
                    wire:model="name"
                    id="name"
                    name="name"
                    type="text"
                    class="block w-full"
                    placeholder="Nome completo"
                />
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    *Campo necessário
                </p>
                <x-input-label for="email" value="Email" class="sr-only" />
                <x-text-input
                    wire:model="email"
                    id="email"
                    name="email"
                    type="email"
                    class="block w-full"
                    placeholder="Email"
                />
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    *Campo necessário e único
                </p>
                <x-input-label for="cpf" value="CPF" class="sr-only" />
                <x-text-input
                    wire:model="cpf"
                    id="cpf"
                    name="cpf"
                    type="text"
                    class="block w-full"
                    placeholder="CPF ( xxx.xxx.xxx-xx )"
                />
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    *Campo necessário, deve ser válido e único
                </p>
                <x-select
                    text="Selecione a unidade"
                    :options="$units"
                    name="unit_id"
                    id="unit_id"
                />
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    *Campo necessário
                </p>
                <x-primary-button class="max-w-36 flex justify-center text-center">
                    Registrar
                </x-danger-button>
        </form>
    </div>
</div>