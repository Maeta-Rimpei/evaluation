<tr>
    <th class="mt-3">
        <label class="me-3 mb-5" for="{{ $name }}">{{ $label }}</label>
    </th>
    <td class="d-flex flex-row ms-5">
        <div class="search-form mb-5"
            style="display: flex;
                border: 1px solid #ebebeb;
                box-shadow: 2px 2px 2px #eaeaea;
                margin: 0px;
                padding: 0px;
                height: 47px;">
            <i class="fas fa-search" style=" margin: auto; margin-left: 16px;"></i>
            <input type="search" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
                style="border:none; background-color: transparent; outline: none;">
        </div>
    </td>
</tr>
