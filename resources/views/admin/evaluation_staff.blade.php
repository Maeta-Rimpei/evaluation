@extends('admin.index')

@section('content')
    <div class="container">
        <h2 class="text-center">職員フィードバック</h2>

        @if (session('evaluationMessage'))
            <div class="alert alert-success text-center">
                {{ session('evaluationMessage') }}
            </div>
        @elseif (session('evaluationUpdateMessage'))
            <div class="alert alert-success text-center">
                {{ session('evaluationUpdateMessage') }}
            </div>
        @endif

        <p class="text-center mt-5"><strong>{{ $user['name'] . 'さんへの評価' }}</strong></p>
        <table class="text-center mx-auto mt-5">
            <tr>
                <th>現在のコメント</th>
                <td>{{ $user['evaluation'] }}</td>
            </tr>
        </table>

        <form action="{{ route('exeEvaluationStaff', $user['id']) }}" method="post">
            @method('patch')
            @csrf
            <table class="mx-auto">
                <tbody>
                    <tr>
                        <th>
                            <label class="me-3" for="evaluation">フィードバックコメント</label>
                        </th>
                        <td>
                            <textarea class="form-control" name="evaluation" id="evaluation" cols="40" rows="3" required></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex flex-row justify-content-center">
                <div class="text-center">
                    <button class="btn btn-primary mt-5 me-5" type="submit">送信</button>
                </div>
        </form>
        <div class="text-center">
            <a href="{{ route('exeEditEvaluationStaff', $user['id']) }}">
                <button class="btn btn-success mt-5 mx-auto">編集</button>
            </a>
        </div>
    </div>
    </div>
@endsection
