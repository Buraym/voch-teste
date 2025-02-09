@php
    use \App\Models\Employee;
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    $employees = Employee::all();
@endphp
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="min-w-full p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex justify-between items-center">
        <form method="POST" action="{{ route("reports.simple") }}" class="min-w-full flex flex-col gap-2">
            @csrf
                <x-input-label for="name" value="Nome do reporte" class="sr-only" />
                <x-text-input
                    wire:model="name"
                    id="name"
                    name="name"
                    type="text"
                    class="block w-full"
                    placeholder="Nome do reporte"
                />
                <input id="user_name" name="user_name" value="{{$user->name}}" type="hidden" />
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    *Campo necessário
                </p>
                <div class="py-2 flex flex-col justify-start items center gap-2 mb-4">
                    <div class="flex justify-start items-center gap-2 mb-2">
                        <input type="checkbox" id="select-all-employees" class="dark:bg-gray-900 dark:border-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md">
                        <p class="text-base text-gray-600 dark:text-gray-200">
                            Todos os colaboradores
                        </p>
                    </div>
                    <div class="py-2 flex flex-col justify-start items center gap-2  max-h-[420px] overflow-y-auto">
                        @foreach ($employees as $employee)
                        <div class="flex justify-start gap-2 pl-2 items-center">
                            <input
                                type="checkbox"
                                name="employees[]"
                                id="employees[]"
                                value="{{$employee->id}}"
                                checked
                                class="employees-checkbox dark:bg-gray-900 dark:border-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md"
                            >
                            <label for="employees[{{$employee->id}}]" class="text-gray-300 font-semibold text-sm">
                                <div class="flex justify-start items-center gap-4">
                                    <div class="w-44 max-w-44 text-ellipsis text-nowrap overflow-x-hidden pr-2 border-r-2 dark:border-gray-900 border-indigo-600">
                                        {{ $employee->name }}
                                    </div>
                                    <div class="w-44">
                                        {{ $employee->cpf }}
                                    </div>
                                </div>
                                
                            </label>
                        </div>
                        @endforeach
                    </div>
                    
                </div>
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    *Campo necessário
                </p>
                <x-primary-button class="max-w-36 flex justify-center text-center">
                    Registrar
                </x-danger-button>
        </form>
    </div>
</div>
<script>
    document.getElementById("select-all-employees").addEventListener("change", function() {
        document.querySelectorAll('input.employees-checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    document.getElementById("select-all-employees").addEventListener("change", function() {
        document.querySelectorAll('input.employees-checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>