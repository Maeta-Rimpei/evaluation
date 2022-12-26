<button type="{{ $type }}" class="btn btn-{{ $buttonClass }}" data-bs-toggle="{{ $dataBsToggle }}" data-bs-target="{{ $dataBsTarget }}">
    @if ($icon)
    <i class="{{ $icon }}"></i>
    @endif
    削除する
</button>

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $body }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                <a href="{{ $href }}">
                    <button type="{{ $type }}" class="btn btn-{{ $buttonClass }}">削除する</button>
                </a>
            </div>
        </div>
    </div>
</div>
