@extends('admin.index')

@section('content')
    <h2 class="text-center mb-3">職員回答管理</h2>

    @if (session('allDeleteAnswerMessage'))
        <div class="alert alert-danger text-center">
            {{ session('allDeleteAnswerMessage') }}
        </div>
    @elseif (session('errorAnswerEmptyMessage'))
        <div class="alert alert-warning text-center">
            {{ session('errorAnswerEmptyMessage') }}
        </div>
    @endif

    <table class="table table-striped">
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
                <th scope="row">{{ $user['staff_id'] }}</th>
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
                        <x-utility-button href="{{ route('showPartEditAnswer', $user['id']) }}" class="success" icon="fa-regular fa-pen-to-square">
                        編集
                        </x-utility-button>
                    </a>
                </td>
                <td>
                    {{-- 一括削除ボタン --}}
                    <x-modal-and-delete-button type="button" buttonClass="danger" data-bs-toggle="modal" data-bs-target="#{{ 'modal' . $user['staff_id'] }}" icon="fa-solid fa-trash" id="{{ 'modal' . $user['staff_id'] }}" title="確認：削除しようとしています" body="{{ $user['name'] }}さんの回答を本当に削除しますか？" href="{{ route('exeAllDeletedAnswer', $user['id']) }}"></x-modal-and-delete-button>
            @endforeach
        </tbody>
    </table>
@endsection
