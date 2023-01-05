<tr>
    <th>
        <label class="my-3 me-3" for="{{ $name }}">{{ $label }}</label>
    </th>
    <td>
        <select class="form-select my-3 ms-5" name="{{ $name }}">
            <option value="">指定なし</option>
            @if (array_values($options) == $options)
                @foreach ($options as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            @else
                @foreach ($options as $value)
                    <option>{{ $value }}</option>
                @endforeach
            @endif
        </select>
    </td>
</tr>
