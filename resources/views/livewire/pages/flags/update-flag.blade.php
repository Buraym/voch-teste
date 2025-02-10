@php
    use \App\Models\EconomicGroup;
    $economicGroups = EconomicGroup::all()->map(fn($group) => [$group->id, $group->name])->toArray();
@endphp
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex justify-between items-center">
        <form method="POST" action="{{ route('flags.update', $flag->id) }}" class="flex flex-col gap-2">
            @csrf
            @method('PUT')
            <x-input-label for="name" value="Nome atualizado da bandeira" class="sr-only" />
            <x-text-input
                wire:model="name"
                id="name"
                name="name"
                type="text"
                class="block w-full"
                :value="$flag->name"
                placeholder="Nome atualizado da bandeira"
            />
            <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                *Nome deve ser único
            </p>
            <x-select
                text="Selecione o grupo econômico"
                :options="$economicGroups"
                value="{{$flag->economic_group_id}}"
                name="economic_group_id"
                id="economic_group_id"
            />
            <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                *Campo necessário
            </p>
            @if (count($flag->units) > 0) 
                <div class="py-2 flex flex-col jsutify-start items center gap-2 mb-4">
                    <div class="flex justify-start items-center mb-2 gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-fuel text-gray-600 dark:text-gray-400">
                            <line x1="3" x2="15" y1="22" y2="22"/>
                            <line x1="4" x2="14" y1="9" y2="9"/>
                            <path d="M14 22V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v18"/>
                            <path d="M14 13h2a2 2 0 0 1 2 2v2a2 2 0 0 0 2 2a2 2 0 0 0 2-2V9.83a2 2 0 0 0-.59-1.42L18 5"/>
                        </svg>
                        <p class="text-sm text-gray-600 dark:text-gray-400 font-bold">
                            Unidades desta bandeira
                        </p>
                    </div>
                    <div class="px-4 flex flex-col justify-start items-start mb-2 gap-2">
                        @foreach ($flag->units as $unit)
                            <a href="{{ route('unit', $unit->id) }}" wire:navigate.hover class="flex gap-2 text-gray-600 dark:text-gray-400">
                                <i>• {{ $unit->name }}</i>
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
        x-on:click.prevent="$dispatch('open-modal', 'confirm-flag-deletion')"
    >
        Apagar bandeira
    </x-danger-button>

    <x-modal name="confirm-flag-deletion" focusable>
        <form method="POST" action="{{ route('flags.destroy', $flag->id) }}" class="p-6">
            @csrf
            @method('DELETE')
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Têm certeza que deseja deletar esta bandeira ?
            </h2>

            <div class="mt-6 flex justify-end">
                <x-danger-button class="ms-3">
                    Deletar bandeira
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>