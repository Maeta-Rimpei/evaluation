@extends('admin.index')

@section('content')
    <div class="container">
        <h2 class="text-center">回答編集</h2>

        <form action="{{ route('exeUpdatedAnswer', $user_answer['id']) }}" method="post">
            @method('patch')
            @csrf
            <p class="text-center mt-3"><strong>{{ '現在の回答' . $user_answer['answer'] }}</strong></p>
            <table class="mx-auto mt-5">
                <tbody>
                    <tr>
                        <th>
                            <label class="me-3" for="answer">修正後の回答</label>
                        </th>
                        @if (in_array($user_answer['answer'], App\Consts\AnswerOptionConsts::ANSWER_OPTION))
                        <td>
                            <div class="row">
                                <div class="col-4 mx-auto">
                                    <select class="form-select text-center" name="answer">
                                        <option disabled>クリックして選んでください</option>
                                        @foreach (App\Consts\AnswerOptionConsts::ANSWER_OPTION as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </td>    
                        @else
                            <td>
                                <textarea class="form-control" name="answer" cols="40" rows="3" required></textarea>
                            </td>
                        @endif
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <button class="btn btn-success mt-5 mx-auto" type="submit">修正</button>
            </div>
        </form>
    </div>
@endsection
