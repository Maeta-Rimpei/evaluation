@extends('layouts.app')

@section('content')
    <h1 class="text-center">自己評価シート</h1>
    <div class="personal-info d-flex flex-row">
        <div class="partition" style="width: 70%;"></div>
        <div class="d-flex flex-column">
            @foreach (App\Consts\StaffPositionConsts::STAFF_LIST as $auth_user->role => $position)
                <div class="p-2">〇職名：{{ $position }}</div>
            @break;
        @endforeach
        <div class="p-2">〇所属：{{ $auth_user['affiliation'] }}</div>
        <div class="p-2">〇氏名：{{ $auth_user['name'] }}</div>
    </div>
</div>
</div>

<div class="container text-center">
    <p class="fs-4 mt-5">各項目についてご回答ください。</p>
    <p>
        ※1.選択式の問については、選択肢
        @foreach (App\Consts\AnswerOptionConsts::ANSWER_OPTION as $option)
            {{ $option }}
        @endforeach
        からお選びください。
    </p>
    <p>※2.記述式の問については、文章形式で入力してお答えください。</p>
</div>

{{-- バリデーションエラーメッセージ --}}
@error('answer[]')
    <div class="alert alert-danger mx-auto" style="width: 60%;">
        <p class="text-center">{{ $message }}</p>
    </div>
@enderror

<form method="POST" action={{ route('evaluationStore') }}>
    @csrf
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center" scope="col" style="width: 5%">No.</th>
                <th class="text-center" scope="col" style="width: 70%">項目</th>
                <th class="text-center" scope="col" style="width: 25%">回答欄</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($auth_user_questions as $auth_user_question)
                <tr>
                    <th class="text-center" scope="row">{{ $loop->index + 1 }}</th>
                    <td style="font-size: 0.8rem;">
                        {{ $auth_user_question['content'] }}</td>
                    <td>
                        @if ($auth_user_question['category'] == 0)
                            <select class="form-select @error('answer[]') is-invalid @enderror" name="answer[]" aria-label="Default select example">
                                <option disabled>クリックして選んでください</option>
                                @foreach (App\Consts\AnswerOptionConsts::ANSWER_OPTION as $option)
                                    <option>{{ $option }}</option>
                                @endforeach
                            </select>
                        @else
                            <textarea class="form-control" style="width: 100%; height: 150px;" name="answer[]" placeholder="こちらは記述式です"></textarea>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>



    <button type="submit" class="btn btn-primary mt-4 position-absolute start-50">回答する</button>
</form>
</div>
@endsection
