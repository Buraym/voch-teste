@php
    use Illuminate\Support\Facades\Auth;
    use \App\Models\Flag;
    use \App\Models\Unit;
    $user = Auth::user();
    $flags = Flag::all();
    $units = Unit::all();
@endphp
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="min-w-full p-2 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex justify-between items-center">
        <form method="POST" action="{{ route("reports.flag") }}" class="min-w-full flex flex-col gap-2">
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
                    @foreach ($flags as $index => $flag)
                        @if (count($flag->units) > 0)
                            <div class="flex justify-start items-center gap-2 mb-2">
                                <input
                                    type="checkbox"
                                    name="flags[]"
                                    id="select-all-units-{{ $flag->id }}"
                                    value="{{$flag->id}}"
                                    checked
                                    class="dark:bg-gray-900 dark:border-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md"
                                >
                                <label for="select-all-units-{{ $flag->id }}" class="text-base text-gray-600 dark:text-gray-200">
                                    Bandeira <i>{{ $flag->name }}</i>
                                </label>
                            </div>
                            <div class="py-2 px-4 flex flex-col justify-start items center gap-2 ">
                                @foreach ($flag->units as $unit)
                                    @if (count($unit->employees) > 0)
                                        <div class="flex justify-start items-center gap-2 mb-2">
                                            <input
                                                type="checkbox"
                                                name="units[]"
                                                id="select-all-employees-{{ $unit->id }}"
                                                value="{{$unit->id}}"
                                                checked
                                                onchange="checkFlag('{{ $flag->id }}')"
                                                class="flag-{{ $flag->id }}-unit dark:bg-gray-900 dark:border-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md"
                                            >
                                            <label for="select-all-employees-{{ $unit->id }}" class="text-base text-gray-600 dark:text-gray-200">
                                                Unidade <i>{{ $unit->name }}</i>
                                            </label>
                                        </div>
                                        <div class="py-2 px-4 flex flex-col justify-start items center gap-2 max-h-[90px] overflow-y-auto">
                                            @foreach ($unit->employees as $employee)
                                                <div class="flex justify-start gap-2 pl-2 items-center">
                                                    <input
                                                        type="checkbox"
                                                        name="employees[]"
                                                        id="employees[{{$employee->id}}]"
                                                        value="{{$employee->id}}"
                                                        checked
                                                        onchange="checkUnit('{{ $unit->id }}','{{ $flag->id }}')"
                                                        class="employees-checkbox-{{ $unit->id }} flag-{{ $flag->id }}-employee dark:bg-gray-900 dark:border-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md"
                                                    >
                                                    <label for="employees[{{$employee->id}}]" class="text-gray-300 font-semibold text-sm">
                                                        <div class="flex justify-start items-center gap-4">
                                                            <div class="w-44 max-w-44 text-ellipsis text-nowrap overflow-x-hidden pr-2 border-r-2 text-gray-600 dark:text-gray-300 dark:border-gray-900 border-indigo-600">
                                                                {{ $employee->name }}
                                                            </div>
                                                            <div class="w-44 text-gray-600 dark:text-gray-300">
                                                                {{ $employee->cpf }}
                                                            </div>
                                                        </div>
                                                        
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endforeach
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
@foreach ($flags as $index => $flag)
<script>
        document.getElementById("select-all-units-{{$flag->id}}").addEventListener("change", function() {
            document.querySelectorAll('input.flag-{{$flag->id}}-unit').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            document.querySelectorAll('input.flag-{{$flag->id}}-employee').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
</script>
@endforeach
@foreach ($units as $index => $unit)
<script>
        document.getElementById("select-all-employees-{{$unit->id}}").addEventListener("change", function() {
            document.querySelectorAll('input.employees-checkbox-{{$unit->id}}').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
</script>
@endforeach
<script>

    function checkFlag(flag) {
        const groupCheckboxes = document.querySelectorAll(".flag-" + flag + "-unit");
        const masterCheckbox = document.getElementById("select-all-units-" + flag);
        console.log()
        masterCheckbox.checked = Array.from(groupCheckboxes).some(checkbox => checkbox.checked);
    }

    function checkUnit(unit, flag) {
        const groupCheckboxes = document.querySelectorAll(".employees-checkbox-" + unit);
        const masterCheckbox = document.getElementById("select-all-employees-" + unit);
        masterCheckbox.checked = Array.from(groupCheckboxes).some(checkbox => checkbox.checked);
        checkFlag(flag)
    }

    
</script>