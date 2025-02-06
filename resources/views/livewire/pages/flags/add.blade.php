@php
    use \App\Models\EconomicGroup;
    $economicGroups = EconomicGroup::all()->map(fn($group) => [$group->id, $group->name])->toArray();
@endphp
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex justify-between items-center">
        <form method="POST" action="{{ route("flags.store") }}" class="flex flex-col gap-2">
            @csrf
                <x-input-label for="name" value="Nome da bandeira" class="sr-only" />
                <x-text-input
                    wire:model="name"
                    id="name"
                    name="name"
                    type="text"
                    class="block w-full"
                    placeholder="Nome da bandeira"
                />
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    *Nome deve ser único
                </p>
                <x-select
                    text="Selecione o grupo econômico"
                    :options="$economicGroups"
                    name="economic_group_id"
                    id="economic_group_id"
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