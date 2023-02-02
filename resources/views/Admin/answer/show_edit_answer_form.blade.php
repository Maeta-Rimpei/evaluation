@extends('admin.index')

@section('content')
    <div class="container">
        <h2 class="text-center">回答編集</h2>

        <x-utility-button href="{{ route('showEditPartAnswer', $user_id) }}" class="secondary mb-3" icon="fa-solid fa-arrow-left me-2">
            戻る
        </x-utility-button>

        <form action="{{ route('exeUpdateAnswer', $user_answer['id']) }}" method="post">
            @method('patch')
            @csrf
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
                                                <option value="{{ $option }}"
                                                    @if (old('answer', $option) == $user_answer['answer']) selected @endif>{{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </td>
                        @else
                            <td>
                                <textarea class="form-control @error('answer') is-invalid @enderror" name="answer" cols="40" rows="3">{{ $user_answer['answer'] }}</textarea>
                                @error('answer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        @endif
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <x-utility-button type="submit" class="success mt-5 mx-auto">
                    修正
                </x-utility-button>
            </div>
        </form>
    </div>
@endsection
