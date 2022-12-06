@extends('admin.index')

@section('content')
    <div class="container">

        @if (session('editMessage'))
            <div class="alert alert-success text-center">
                {{ session('editMessage') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center" scope="col" style="width: 5%">質問ID</th>
                    <th class="text-center" scope="col" style="width: 70%">項目</th>
                    <th scope="col" style="width: 12.5%"></th>
                    <th scope="col" style="width: 12.5%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <th class="text-center">{{ $question->question_id }}</th>
                        <td>{{ $question->content }}</td>
                        <td class="text-center">
                            <a href={{ route('editForm', $question->question_id) }}>
                                <button type="button" class="btn btn-success">編集</button>
                            </a>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#{{ 'modal' . $question->question_id }}">
                                削除
                            </button>
                            <p></p>
                            <!-- モーダル -->
                            <div class="modal fade" id="{{ 'modal' . $question->question_id }}" tabindex="-1"
                                aria-labelledby="modalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel">確認：削除しようとしています</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <strong>{{ mb_substr($question->content, 0, 10, 'UTF-8') }}......</strong>この質問を本当に削除しますか？
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">キャンセル</button>
                                            <a href={{ route('exeQuestionSoftDeleted', $question->question_id) }}>
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
