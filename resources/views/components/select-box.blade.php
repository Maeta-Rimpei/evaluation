<tr>
    <th>
        <label class="mt-5 me-3" for="role_id">{{ $label }}</label>
    </th>
    <td>
        <select class="form-select mt-5 ms-5" name="{{ $name }}">
            <option value="">指定なし</option>
            @if (array_values($options) == $options)
                @foreach ($options as $num => $value)
                    <option value="{{ $num }}">{{ $value }}</option>
                @endforeach
            @else
                @foreach ($options as $value)
                    <option>{{ $value }}</option>
                @endforeach
            @endif
        </select>
    </td>
</tr>
