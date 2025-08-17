@props(['items', 'columns', 'actions'])

<table {{ $attributes->merge(['class' => 'table table-bordered table-striped my-2']) }}>
    <thead>
        <tr>
            <th>SL</th>
            @foreach ($columns as $label)
                <th>{{ $label }}</th>
            @endforeach
            <th>Actions</th>
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
            <td>
                @foreach($actions as $label => $callback)
                    @php
                        $action = $callback($row);
                        $attrs  = $action['attrs'] ?? [];
                    @endphp
                
                    <a href="{{ $action['href'] ?? '#' }}"
                       class="btn {{ $action['class'] ?? '' }}"
                       @foreach($attrs as $k => $v)
                           {{ $k }}="{{ $v }}"
                       @endforeach>
                       {{ $label }}
                    </a>
                @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
       
    </tfoot>
</table>