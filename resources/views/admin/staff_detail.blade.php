@extends('admin.index')

@section('content')
    <div class="container">
        <h3 class="mb-3">{{ $user['name'] . 'さんの回答' }}</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" scope="col" style="width: 5%">質問ID</th>
                        <th class="text-center" scope="col" style="width: 70%">質問内容</th>
                        <th class="text-center" scope="col" style="width: 25%">回答欄</th>
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
                        @for ($i=0; $i<count(App\Consts\AnswerOptionConsts::ANSWER_OPTION); $i++)
                            <tr>
                                <th class="text-center">{{ App\Consts\AnswerOptionConsts::ANSWER_OPTION[$i] }}</th>
                                @if (array_key_exists(App\Consts\AnswerOptionConsts::ANSWER_OPTION[$i], $answers_count))
                                    <td class="text-center">{{ $answers_count[App\Consts\AnswerOptionConsts::ANSWER_OPTION[$i]] }}</td>
                                @else
                                    <td class="text-center">0</td>
                                @endif
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="eva-btn text-center mt-5">
                <a href="{{ route('evaForm', $user['id']) }}">
                    <button type="button" class="btn btn-outline-primary">{{ $user['name'] . 'さんへの評価を作成' }}</button>
                </a>
            </div>
    </div>
@endsection
