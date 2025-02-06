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
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    Unidades desta bandeira
                </p>
                @foreach ($flag->units as $unit)
                    <a href="{{ route('unit', $unit->id) }}" wire:navigate class="flex justify-center items-center h-10 rounded-lg hover:bg-gray-400 hover:text-gray-900 transition-all dark:bg-white hover">
                        <i>{{ $unit->name }}</i>
                    </a>
                @endforeach
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