@extends('admin.index')

@section('content')
    <div class="container">
        <h2 class="text-center">職員評価</h2>

        @if (session('evaluationMessage'))
            <div class="alert alert-success text-center">
                {{ session('evaluationMessage') }}
            </div>
        @endif

        <form action="{{ route('exeEvaluationStaff', $user['id']) }}" method="post">
            @method('patch')
            @csrf
            <p class="text-center mt-5"><strong>{{ $user['name'] . 'さんへの評価'}}</strong></p>
            <table class="mx-auto">
                <tbody>
                    <tr>
                        <th>
                            <label class="me-3" for="evaluation">評価コメント</label>
                        </th>
                        <td>
                            <textarea class="form-control" name="evaluation" id="evaluation" cols="40" rows="3" required></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <button class="btn btn-primary mt-5 mx-auto" type="submit">送信</button>
            </div>
        </form>
    </div>
@endsection
