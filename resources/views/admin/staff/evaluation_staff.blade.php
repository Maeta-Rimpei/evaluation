@extends('admin.index')

@section('content')
    <div class="container">
        <h2 class="text-center">職員フィードバック</h2>

        @if (session('evaluationMessage'))
            <div class="alert alert-success text-center">
                {{ session('evaluationMessage') }}
            </div>
        @elseif(session('evaluationErrorMessage'))
            <div class="alert alert-warning text-center">
                {{ session('evaluationErrorMessage') }}
            </div>
        @endif

        <form action="{{ route('exeEvaluationStaff', $user['id']) }}" method="post">
            @csrf
            <table class="mx-auto mt-5">
                <tbody>
                    <tr>
                        <th>
                            <label class="me-3" for="total_evaluation">総合評価</label>
                        </th>
                        <td>
                            <select class="form-select @error('total_evaluation') is-invalid @enderror"
                                name="total_evaluation">
                                <option class="mb-3" disabled>クリックして選んでください</option>
                                @foreach (App\Consts\AnswerOptionConsts::ANSWER_OPTION as $option)
                                    <option>{{ $option }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label class="me-3" for="evaluation">フィードバックコメント</label>
                        </th>
                        <td>
                            <textarea class="form-control" name="evaluation" id="evaluation" cols="40" rows="3" required>{{ $user['evaluation'] }}</textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex flex-row justify-content-center">
                <div class="text-center mt-5">
                    <x-utility-button type="submit">送信</x-utility-button>
                </div>
        </form>
    </div>
    </div>
@endsection
