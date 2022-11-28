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
            @foreach ($user_questions_answers as $user_question_answer)
            <tr>
                <th class="text-center" scope="row">{{ $user_question_answer->question_id }}</th>
                <td>{{ $user_question_answer->content }}</td>
                <td class="text-center">{{ $user_question_answer->answer }}</td>
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
                @foreach ($count_option_qs as $answer => $num)
                <tr>
                    <th>{{ $answer }}</th>
                    <td>{{ $num }}</td>
                </tr>
                @endforeach
                @foreach ($desc_qs_as as $desc_q => $desc_a)
                <tr>
                    <th>{{ $desc_q }}</th>
                    <td>{{ $desc_a }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    @endsection