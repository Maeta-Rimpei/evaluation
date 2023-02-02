@extends('admin.index')

@section('content')
    <h2 class="text-center mb-3">職員回答管理</h2>

    {{-- 一括削除成功メッセージ --}}
    @if (session('deleteAllAnswerMessage'))
        <div class="alert alert-danger text-center">
            {{ session('deleteAllAnswerMessage') }}
        </div>
        {{-- 一括削除失敗メッセージ --}}
    @elseif (session('errorAnswerEmptyMessage'))
        <div class="alert alert-warning text-center">
            {{ session('errorAnswerEmptyMessage') }}
        </div>
    @endif

    <table class="table table-striped mt-5">
        <thead>
            <tr>
                <th scope="col">職員コード</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">職員名</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">所属</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user['staff_code'] }}</th>
                    <td></td>
                    <td></td>
                    <td>{{ $user['name'] }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $user['affiliation'] }}</td>
                    <td></td>
                    <td></td>
                    <td>
                        {{-- 編集ボタン --}}
                        <x-utility-button href="{{ route('showEditPartAnswer', $user['id']) }}" class="success"
                            icon="fa-regular fa-pen-to-square me-2">
                            編集
                        </x-utility-button>
                        </a>
                    </td>
                    <td>
                        {{-- 一括削除ボタン --}}
                        <x-modal-and-delete-button type="button" buttonClass="danger" data-bs-toggle="modal"
                            data-bs-target="#{{ 'modal' . $user['staff_code'] }}" icon="fa-solid fa-trash me-2"
                            id="{{ 'modal' . $user['staff_code'] }}" title="確認：削除しようとしています"
                            body="{{ $user['name'] }}さんの回答を本当に削除しますか？"
                            href="{{ route('exeDeleteAllAnswers', $user['id']) }}">
                        </x-modal-and-delete-button>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }} 
@endsection
