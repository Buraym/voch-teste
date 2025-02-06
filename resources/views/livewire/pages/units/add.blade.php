@php
    use \App\Models\Flag;
    $flags = Flag::all()->map(fn($group) => [$group->id, $group->name])->toArray();
@endphp
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex justify-between items-center">
        <form method="POST" action="{{ route("units.store") }}" class="flex flex-col gap-2">
            @csrf
                <x-input-label for="name" value="Nome fantasia" class="sr-only" />
                <x-text-input
                    wire:model="name"
                    id="name"
                    name="name"
                    type="text"
                    class="block w-full"
                    placeholder="Nome fantasia"
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
                    placeholder="CNPJ ( xx.xxx.xxx/xxxx-xx )"
                />
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    *Campo necessário, deve ser válido e único
                </p>
                <x-select
                    text="Selecione a bandeira"
                    :options="$flags"
                    name="flag_id"
                    id="flag_id"
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