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
            @if (count($unit->employees) > 0)
            <div class="py-2 flex flex-col jsutify-start items center gap-2 mb-4">
                <div class="flex justify-start items-center mb-2 gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-user text-gray-600 dark:text-gray-400">
                        <path d="M15 13a3 3 0 1 0-6 0"/>
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"/>
                        <circle cx="12" cy="8" r="2"/>
                    </svg>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-bold">
                        Colaboradores desta unidade
                    </p>
                </div>
                <div class="px-4 flex flex-col justify-start items-start mb-2 gap-2">
                    @foreach ($unit->employees as $employee)
                        <a href="{{ route('employee', $employee->id) }}" wire:navigate.hover class="flex gap-2 text-gray-600 dark:text-gray-400">
                            <i>• {{ $employee->name }}</i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right">
                                <path d="M7 7h10v10"/>
                                <path d="M7 17 17 7"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
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