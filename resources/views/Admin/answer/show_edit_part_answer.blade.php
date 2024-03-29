@extends('admin.index')

@section('content')
    <div class="container">
        <h2 class="text-center mb-3">{{ $user['name'] . 'さんの回答' }}</h2>

        <x-utility-button href="{{ route('showEditAnswer') }}" class="secondary mb-3" icon="fa-solid fa-arrow-left me-2">
            戻る
        </x-utility-button>

        @if (session('updateAnswerMessage'))
            <div class="alert alert-success text-center">
                {{ session('updateAnswerMessage') }}
            </div>
        @endif

        @if ($user_questions_answers->isEmpty())
            <h3 class="text-center mt-5">この方はまだ回答されていません</h3>
        @else
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th class="text-center" scope="col" style="width: 5%">質問ID</th>
                        <th class="text-center" scope="col" style="width: 45%">質問内容</th>
                        <th class="text-center" scope="col" style="width: 25%">回答</th>
                        <th class="text-center" scope="col" style="width: 15%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_questions_answers as $user_question_answer)
                        <tr>
                            <th class="text-center">{{ $user_question_answer->question_id }}</th>
                            <td>{{ $user_question_answer->content }}</td>
                            <td class="text-center">{{ $user_question_answer->answer }}</td>
                            {{-- 修正ボタン --}}
                            <td>
                                <x-utility-button href="{{ route('showEditAnswerForm', $user_question_answer->answer_id) }}"
                                    class="success" icon="fa-regular fa-pen-to-square me-2">
                                    修正する
                                </x-utility-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
@endsection
