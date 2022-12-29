@extends('admin.index')

@section('content')
    <div class="container">
        <h3 class="mb-3">{{ $user['name'] . 'さんの回答' }}</h2>

            @if (session('destroyedEvaluationMessage'))
                <div class="alert alert-danger text-center">
                    {{ session('destroyedEvaluationMessage') }}
                </div>
            @elseif (session('destroyedErrorMessage'))
                <div class="alert alert-warning text-center">
                    {{ session('destroyedErrorMessage') }}
                </div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" scope="col" style="width: 5%">質問ID</th>
                        <th class="text-center" scope="col" style="width: 70%">質問内容</th>
                        <th class="text-center" scope="col" style="width: 25%">回答</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($array_user_questions_answers as $user_question_answer)
                        <tr>
                            <th class="text-center">{{ $user_question_answer['question_id'] }}</th>
                            <td>{{ $user_question_answer['content'] }}</td>
                            <td class="text-center">{{ $user_question_answer['answer'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="mt-5">【集計】</p>
            <div class="col-5 ml-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">小計</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < count(App\Consts\AnswerOptionConsts::ANSWER_OPTION); $i++)
                            <tr>
                                <th class="text-center">{{ App\Consts\AnswerOptionConsts::ANSWER_OPTION[$i] }}</th>
                                @if (array_key_exists(App\Consts\AnswerOptionConsts::ANSWER_OPTION[$i], $answers_count))
                                    <td class="text-center">
                                        {{ $answers_count[App\Consts\AnswerOptionConsts::ANSWER_OPTION[$i]] }}</td>
                                @else
                                    <td class="text-center">0</td>
                                @endif
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            @if (!empty($array_user_questions_answers))
                <div class="eva-btn text-center mt-5">
                    {{-- 作成ボタン --}}
                    <x-utility-button href="{{ route('evaluationStaff', $user['id']) }}" class="outline-primary"
                        icon="fa-solid fa-comment-dots me-2">
                        フィードバックを作成
                    </x-utility-button>
                    {{-- 編集ボタン --}}
                    <x-utility-button href="{{ route('showEditEvaluationStaff', $user['id']) }}" class="outline-success"
                        icon="fa-regular fa-pen-to-square me-2">
                        フィードバックを編集
                    </x-utility-button>
                    {{-- 削除ボタン --}}
                    <x-modal-and-delete-button type="button" buttonClass="outline-danger" data-bs-toggle="modal"
                        data-bs-target="#{{ 'modal' . $user['staff_id'] }}" icon="fa-solid fa-trash"
                        id="{{ 'modal' . $user['staff_id'] }}" title="確認：削除しようとしています"
                        body="{{ $user['name'] }}さんへのフィードバックを本当に削除しますか？"
                        href="{{ route('exeDestroyedEvaluationStaff', $user['id']) }}">
                    </x-modal-and-delete-button>
                </div>
            @endif
    </div>
@endsection
