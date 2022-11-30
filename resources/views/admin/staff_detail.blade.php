@extends('admin.index')

@section('content')
    <div class="container">
        <h3 class="mb-3">{{ $user['name'] . 'さんの回答' }}</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" scope="col" style="width: 5%">質問ID</th>
                        <th class="text-center" scope="col" style="width: 70%">項目</th>
                        <th class="text-center" scope="col" style="width: 25%">回答欄</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($array_user_questions_answers as $user_question_answer)
                        <tr>
                            <th class="text-center">{{ $user_question_answer['question_id'] }}</th>
                            <td>{{ $user_question_answer['content'] }}</td>
                            {{-- @if (is_null($user_question_answer->answer)) --}}
                            {{-- <td class="text-center">-</td> --}}
                            {{-- @else --}}
                            <td class="text-center">{{ $user_question_answer['answer'] }}</td>
                            {{-- @endif --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="mt-5">【集計】</p>
            <p class="mt-0 mb-0">※ 回答数が0の選択肢については表示されません</p>
            <div class="col-5 ml-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>小計</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (array_keys(App\Consts\AnswerOptionConsts::ANSWER_OPTION) as $answer)
                        {{-- @foreach ($array_user_questions_answers as $index => $user_info) --}}
                            <tr>
                                <th>{{ $answer }}</th>
                                {{-- @if (in_array($answer, $user_info)) --}}
                                {{-- <td>{{ array_column($array_user_questions_answers[0]) }}</td> --}}
                                {{-- @else --}}
                                {{-- @endif --}}
                                {{-- @endforeach --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
@endsection
