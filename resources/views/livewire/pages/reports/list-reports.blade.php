<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex justify-between items-center">
        <form method="GET" action="{{ route("reports.search") }}" >
            <div class="max-w-2xl flex justify-start gap-2">
                <x-input-label for="q" value="Nome do reporte" class="sr-only" />
                <x-text-input
                    wire:model="q"
                    id="q"
                    name="q"
                    type="text"
                    value="{{ request('q', $query) }}"
                    class="block w-4/6"
                    placeholder="Nome do reporte"
                />
                <x-primary-button class="w-2/6 flex justify-center text-center">
                    Pesquisar
                </x-danger-button>
            </div>
        </form>
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex justify-center items-center h-10 w-10 rounded-lg dark:bg-gray-900 dark:text-white hover:bg-gray-400 hover:text-gray-900 transition-all hover p-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                        <path d="M5 12h14"/><path d="M12 5v14"/>
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('add-simple-report')" wire:navigate>
                    Reporte simples
                </x-dropdown-link>
                <x-dropdown-link :href="route('add-unit-report')" wire:navigate>
                    Reporte por unidades
                </x-dropdown-link>
                <x-dropdown-link :href="route('add-flag-report')" wire:navigate>
                    Reporte por bandeiras
                </x-dropdown-link>
                <x-dropdown-link :href="route('add-economic-group-report')" wire:navigate>
                    Reporte por grupos econômicos
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
    </div>
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        @livewire('data-table', [
            'columns' => ['ID', 'Nome', 'Criado em'],
            'rows' => $reportsFound,
            'link' => "",
            'downloadRoute' => "reports.download",
            'deleteLink' => "reports.destroy"
        ])
    </div>
</div>