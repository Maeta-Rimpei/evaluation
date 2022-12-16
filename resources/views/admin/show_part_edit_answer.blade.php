@extends('admin.index')

@section('content')
    <div class="container">
        <h2 class="mb-3">{{ $user['name'] . 'さんの回答' }}</h2>

        @if (session('updateAnswerMessage'))
            <div class="alert alert-success text-center">
                {{ session('updateAnswerMessage') }}
            </div>
        @elseif (session('partDeleteAnswerMessage'))
            <div class="alert alert-danger text-center">
                {{ session('partDeleteAnswerMessage') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center" scope="col" style="width: 5%">質問ID</th>
                    <th class="text-center" scope="col" style="width: 50%">質問内容</th>
                    <th class="text-center" scope="col" style="width: 25%">回答</th>
                    <th class="text-center" scope="col" style="width: 10%"></th>
                    <th class="text-center" scope="col" style="width: 10%"></th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($user_questions); $i++)
                    <tr> 
                        {{-- ↓------------------------------回答が空の時の処理------------------------------↓ --}}
                        @if (!empty($user_questions[$i]) && empty($user_answers[$i]))
                        <th class="text-center">{{ $user_questions[$i]['id'] }}</th>
                            <td>{{ $user_questions[$i]['content'] }}</td>
                            <td class="text-center">削除済</td>
                            <td></td>
                            <td></td>

                        
                        @elseif (!empty($user_answers[$i]) && !empty($user_questions[$i]))
                        <th class="text-center">{{ $user_questions[$i]['id'] }}</th>
                        <td>{{ $user_questions[$i]['content'] }}</td>
                            {{-- ↓------------------------------正常処理------------------------------↓ --}}
                            <td class="text-center">{{ $user_answers[$i]['answer'] }}</td>
                            {{-- 修正ボタン --}}
                            <td>
                                <a href="{{ route('showUpdatedAnswer', $user_answers[$i]['id']) }}">
                                    <button type="button" class="btn btn-success">修正</button>
                                </a>
                            </td>

                            {{-- 削除ボタン --}}
                            <td>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#{{ 'modal' . $user_answers[$i]['id'] }}">削除</button>

                                {{-- 部分削除Modal --}}
                                <div class="modal fade" id="{{ 'modal' . $user_answers[$i]['id'] }}" tabindex="-1"
                                    aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel">確認：削除しようとしています</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <strong>{{ mb_substr($user_questions[$i]['content'], 0, 10, 'UTF-8') }}</strong>......に対する回答を削除してもよろしいですか？
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">キャンセル</button>
                                                <a href={{ route('exePartDeletedAnswer', $user_answers[$i]['id']) }}>
                                                    <button type="button" class="btn btn-danger">削除する</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                        @endif
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
@endsection
