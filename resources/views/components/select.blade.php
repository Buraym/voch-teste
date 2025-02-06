@props(
    [
        'text' => 'Selecionar opção',
        'options' => [],
        'value' => '',
        'name' => '',
        'id' => '',
        'disabled' => false
    ]
)

<select
    @disabled($disabled)
    name="{{$name}}"
    id="{{$id}}"
    {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) }}
>
    @if ($value == "")
        <option value="" selected disabled>
            {{ $text }}
        </option>
    @endif
    @foreach ($options as $option)
        <option value="{{ $option[0] }}" @php
            if ($option[0] == $value) {
                echo " selected ";
            }
        @endphp>
            {{ $option[1] }}
        </option>
    @endforeach
</select>