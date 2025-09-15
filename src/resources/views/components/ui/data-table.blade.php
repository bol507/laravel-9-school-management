@props(['items', 'columns', 'actions','images' => [] ])


<table {{ $attributes->merge(['class' => 'table']) }}>

    <thead class="thead-ligth">
        <tr >
            <th >SL</th>
            @foreach ($columns as $label)
            <th >{{ $label }}</th>
            @endforeach
            @if($actions)
                <th >Actions</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @foreach ($items as $key => $row)
        <tr>
            <td>{{ $key + 1 }}</td>

            {{-- Dinamic columns --}}
            @foreach ($columns as $colKey => $label)
                <td>
                    @if (in_array($colKey, $images, true) && data_get($row, $colKey))
                       <img src="{{ data_get($row, $colKey) }}"
                            alt="{{ $label }}"
                            loading="lazy"
                            style="max-height: 60px; max-width:60px;">
                    @else
                        {{ e(data_get($row, $colKey)) }}
                    @endif
                </td>
            @endforeach

            {{-- Actions --}}
            @if($actions)
            <td >
                @foreach($actions as $label => $callback)
                @php
                $action = $callback($row);
                $attrs = $action['attrs'] ?? [];
                @endphp

                <a href="{{ $action['href'] ?? '#' }}"
                    class="btn btn-sm mx-1.5 {{ $action['class'] ?? '' }}"
                    @foreach($attrs as $k=> $v)
                    {{ $k }}="{{ $v }}"
                    @endforeach>
                    {{ $label }}
                </a>
                @endforeach
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>

    <tfoot>

    </tfoot>
</table>