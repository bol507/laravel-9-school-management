@props(['items', 'columns', 'actions'])
@php
$totalColumns = count($columns) + 2;
$actionWidth = 100 / $totalColumns;
@endphp

<table {{ $attributes->merge(['class' => 'table']) }}>

    <thead>
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
            @foreach ($columns as $key => $label)
            <td>{{ e(data_get($row, $key)) }}</td>
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