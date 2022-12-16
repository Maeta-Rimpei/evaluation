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
                    <a href={{ route('showPartEditAnswer', $user['id']) }}>
                        <button class="btn btn-success" type="button">編集</button>
                    </a>
                </td>
                <td>
                    {{-- 一括削除ボタン --}}
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#{{ 'modal' . $user['staff_id'] }}">回答を一括削除</button>

                {{-- 一括削除 Modal --}}
                <div class="modal fade" id="{{ 'modal' . $user['staff_id'] }}" tabindex="-1"
                    aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">確認：削除しようとしています</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{ $user['name'] }}さんの回答を全て削除してもよろしいですか？
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">キャンセル</button>
                                <a href={{ route('exeAllDeletedAnswer', $user['id']) }}>
                                    <button type="button" class="btn btn-danger">削除する</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
            @endforeach
        </tbody>
    </table>
@endsection
