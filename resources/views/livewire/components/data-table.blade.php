<div class="min-w-full h-full border-none rounded-lg">
    <table class="table-auto border-none min-w-full rounded-lg">
        <thead>
            <tr class="bg-gray-200 rounded-t-lg border-none">
                @foreach ($columns as $column)
                    <th class="border-none first:rounded-tl-lg text-left px-4 py-2 uppercase font-bold text-sm">
                        {{ $column }}
                    </th>
                @endforeach
                <th class="border-none text-right rounded-tr-lg px-4">
                    
                </th>
            </tr>
        </thead>
        <tbody class="dark:bg-white rounded-b-lg">
            @if (count($rows) > 0)
                @foreach ($rows as $indexRow => $row)
                    <tr class="max-h-12 last:rounded-b-lg border-none bg-none">
                        @foreach ($row as $index => $cell)
                            <td class="@php
                                if ($index == 0 && $indexRow == count($rows) - 1) {
                                    echo " rounded-bl-lg ";
                                }
                            @endphp max-h-12 border-none px-4 text-gray-800 font-semibold text-xs">
                                @if (($index == 0 || $index == 1) && $link != "")
                                    <a href="{{ route($link, ['id' => $row[0]]) }}" wire:navigate>
                                        {{ $cell }}
                                    </a>
                                @else
                                    {{ $cell }}
                                @endif
                            </td>
                        @endforeach
                        <td class="max-h-12 @php
                        if ($indexRow == count($rows) - 1) {
                            echo " rounded-br-lg";
                        }
                    @endphp border-none text-right">
                            <form method="POST" action="{{ route($deleteLink, $row[0]) }}" class="bg-none p-3">
                                @csrf
                                @method('DELETE')
                                    <x-danger-button class="text-white w-12 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 22 22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash">
                                            <path d="M3 6h18"/>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        </svg>
                                    </x-danger-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="border-none rounded-b-lg">
                    <td class="border-none rounded-b-lg border-gray-400 dark:text-gray-800 text-white px-4 py-4 text-center uppercase font-semibold text-xs" colspan="{{ count($columns) + 1 }}">Nenhum registro encontrado</td>
                </tr>
            @endif
            
        </tbody>
    </table>
</div>
