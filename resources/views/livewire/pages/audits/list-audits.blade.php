<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        @livewire('data-table', [
            'columns' => ['ID', 'Usuário', 'Ação', 'Feito em'],
            'link' => 'audit',
            'rows' => $auditsFound,
        ])
    </div>
</div>