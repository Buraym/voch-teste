<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex justify-between items-center">
        <form method="GET" action="{{ route("flags.search") }}" >
            <div class="max-w-2xl flex justify-start gap-2">
                <x-input-label for="q" value="Nome da bandeira" class="sr-only" />
                <x-text-input
                    wire:model="q"
                    id="q"
                    name="q"
                    type="text"
                    value="{{ request('q', $query) }}"
                    class="block w-4/6"
                    placeholder="Nome da bandeira"
                />
                <x-primary-button class="w-2/6 hidden justify-center text-center sm:flex">
                    Pesquisar
                </x-primary-button>
                <x-primary-button class="w-14 flex justify-center text-center sm:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.3-4.3"/>
                    </svg>
                </x-primary-button>
            </div>
        </form>
        <a href="{{ route('add-flag') }}" wire:navigate class="flex justify-center items-center h-10 w-10 rounded-lg dark:bg-gray-900 dark:text-white hover:bg-gray-400 hover:text-gray-900 transition-all hover">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                <path d="M5 12h14"/><path d="M12 5v14"/>
            </svg>
        </a>
    </div>
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        @livewire('data-table', [
            'columns' => ['ID', 'Nome', 'Grupo Econômico'],
            'rows' => $flagsFound,
            'link' => "flag",
            'deleteLink' => "flags.destroy"
        ])
    </div>
</div>