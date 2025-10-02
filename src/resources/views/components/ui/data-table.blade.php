@props(['items', 'columns', 'actions','images' => [] ])


<table {{ $attributes->merge(['class' => 'table']) }}>

    <thead class="thead-ligth">
        <tr >
            <th >SL</th>
            @foreach ($columns as $label)
                <th>{{ is_string($label) ? $label : '' }}</th>
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
                    @php

                        if (is_callable($label)) {
                            $value = $label($row);
                        } else {

                            $value = data_get($row, $colKey);
                        }
                    @endphp

                    @if (in_array($colKey, $images, true) && $value)
                        <img src="{{ $value }}"
                            alt="{{ is_string($label) ? $label : '' }}"
                            loading="lazy"
                            style="max-height: 60px; max-width: 60px;">
                    @else
                        {{ $value ?? '' }}
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
