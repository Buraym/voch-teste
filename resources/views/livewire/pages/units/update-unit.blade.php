@php
    use \App\Models\Flag;
    $flags = Flag::all()->map(fn($flag) => [$flag->id, $flag->name])->toArray();
@endphp
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex justify-between items-center">
        <form method="POST" action="{{ route('units.update', $unit->id) }}" class="flex flex-col gap-2">
            @csrf
            @method('PUT')
            <x-input-label for="name" value="Nome fantasia atualizado" class="sr-only" />
            <x-text-input
                wire:model="name"
                id="name"
                name="name"
                type="text"
                class="block w-full"
                :value="$unit->name"
                placeholder="Nome fantasia atualizado"
            />
            <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                *Campo necessário
            </p>
            <x-input-label for="social" value="Razão social" class="sr-only" />
            <x-text-input
                wire:model="social"
                id="social"
                name="social"
                type="text"
                class="block w-full"
                :value="$unit->social"
                placeholder="Razão social"
            />
            <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                *Campo necessário
            </p>
            <x-input-label for="cnpj" value="CNPJ" class="sr-only" />
            <x-text-input
                wire:model="cnpj"
                id="cnpj"
                name="cnpj"
                type="text"
                class="block w-full"
                :value="$unit->cnpj"
                placeholder="CNPJ ( xx.xxx.xxx/xxxx-xx )"
            />
            <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                *Campo necessário, deve ser válido e único
            </p>
            <x-select
                text="Selecione a bandeira"
                :options="$flags"
                value="{{$unit->flag_id}}"
                name="flag_id"
                id="flag_id"
            />
            <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                *Campo necessário
            </p>
            <div class="flex gap-2">
                <x-primary-button class="max-w-36 flex justify-center text-center">
                    Atualizar
                </x-danger-button>
            </div>
        </form>
    </div>
    <x-danger-button
        x-data=""
        type="button"
        x-on:click.prevent="$dispatch('open-modal', 'confirm-unit-deletion')"
    >
        Apagar unidade
    </x-danger-button>

    <x-modal name="confirm-unit-deletion" focusable>
        <form method="POST" action="{{ route('units.destroy', $unit->id) }}" class="p-6">
            @csrf
            @method('DELETE')
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Têm certeza que deseja deletar esta unidade ?
            </h2>

            <div class="mt-6 flex justify-end">
                <x-danger-button class="ms-3">
                    Deletar unidade
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>