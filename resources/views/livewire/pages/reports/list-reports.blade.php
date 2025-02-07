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
    </div>
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        @livewire('data-table', [
            'columns' => ['ID', 'Nome', 'Criado em'],
            'rows' => $reportsFound,
            'link' => "",
            'deleteLink' => "reports.destroy"
        ])
    </div>
</div>