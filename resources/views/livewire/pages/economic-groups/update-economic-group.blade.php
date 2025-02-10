<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex justify-between items-center">
        <form method="POST" action="{{ route('economic-groups.update', $economicGroup->id) }}" class="flex flex-col gap-2">
            @csrf
            @method('PUT')
            <x-input-label for="name" value="Nome do grupo" class="sr-only" />
            <x-text-input
                wire:model="name"
                id="name"
                name="name"
                type="text"
                class="block w-full"
                :value="$economicGroup->name"
                placeholder="Nome atualizado do grupo"
            />
            <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                *Nome deve ser único
            </p>
            @if (count($economicGroup->flags) > 0) 
                <div class="py-2 flex flex-col jsutify-start items center gap-2 mb-4">
                    <div class="flex justify-start items-center mb-2 gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flag text-gray-600 dark:text-gray-400">
                            <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/>
                            <line x1="4" x2="4" y1="22" y2="15"/>
                        </svg>
                        <p class="text-sm text-gray-600 dark:text-gray-400 font-bold">
                            Bandeiras deste grupo
                        </p>
                    </div>
                    <div class="px-4 flex flex-col justify-start items-start mb-2 gap-2">
                        @foreach ($economicGroup->flags as $flag)
                            <a href="{{ route('flag', $flag->id) }}" wire:navigate.hover class="flex gap-2 text-gray-600 dark:text-gray-400">
                                <i>• {{ $flag->name }}</i>
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
        x-on:click.prevent="$dispatch('open-modal', 'confirm-group-deletion')"
    >
        Apagar grupo econômico
    </x-danger-button>

    <x-modal name="confirm-group-deletion" focusable>
        <form method="POST" action="{{ route('economic-groups.destroy', $economicGroup->id) }}" class="p-6">
            @csrf
            @method('DELETE')
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Têm certeza que deseja deletar este grupo ?
            </h2>

            <div class="mt-6 flex justify-end">
                <x-danger-button class="ms-3">
                    Deletar grupo
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>