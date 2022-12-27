@if ($label)
    <label>{{ $label }}</label>:
@endif

@if ($href)
    <a href="{{ $href }}">
        <button type="{{ $type }}" class="btn btn-{{ $class }}">
            @if ($icon)
                <i class="{{ $icon }}"></i>
            @endif
            {{ $slot }}
        </button>
    </a>
@else
    <button type="{{ $type }}" class="btn btn-{{ $class }}">
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $slot }}
    </button>
@endif
