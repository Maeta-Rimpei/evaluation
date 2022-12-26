@if ($label)
    <label>{{ $label }}</label>:
@endif

<button type="{{ $type }}" class="btn btn-{{ $class }}">
    @if ($icon)
        <i class="{{ $icon }}"></i>
    @endif
    {{ $slot }}
</button>
