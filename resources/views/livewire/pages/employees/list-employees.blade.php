<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex justify-between items-center">
        <form method="GET" action="{{ route("employees.search") }}" >
            <div class="max-w-2xl flex justify-start gap-2">
                <x-input-label for="q" value="Nome do colaborador" class="sr-only" />
                <x-text-input
                    wire:model="q"
                    id="q"
                    name="q"
                    type="text"
                    value="{{ request('q', $query) }}"
                    class="block w-4/6"
                    placeholder="Nome do colaborador"
                />
                <x-primary-button class="w-2/6 flex justify-center text-center">
                    Pesquisar
                </x-danger-button>
            </div>
        </form>
        <a href="{{ route('add-employee') }}" wire:navigate class="flex justify-center items-center h-10 w-10 rounded-lg hover:bg-gray-400 hover:text-gray-900 transition-all dark:bg-white hover">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                <path d="M5 12h14"/><path d="M12 5v14"/>
            </svg>
        </a>
    </div>
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        @livewire('data-table', [
            'columns' => ['ID', 'Nome', 'Email', 'CPF', 'Unidade'],
            'rows' => $employeesFound,
            'link' => "employee",
            'deleteLink' => "employees.destroy"
        ])
    </div>
</div>