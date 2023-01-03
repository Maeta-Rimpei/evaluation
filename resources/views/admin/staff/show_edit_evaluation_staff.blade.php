@extends('admin.index')

@section('content')
    <div class="container">
        <h2 class="text-center">職員フィードバック編集</h2>

        @if (session('evaluationUpdateMessage'))
            <div class="alert alert-success text-center">
                {{ session('evaluationUpdateMessage') }}
            </div>
             @elseif (session('evaluationUpdateErrorMessage'))
            <div class="alert alert-warning text-center">
                {{ session('evaluationUpdateErrorMessage') }}
            </div>
        @endif

        <form action="{{ route('exeUpdateEvaluationStaff', $user['id']) }}" method="post">
            @method('patch')
            @csrf
            <table class="mx-auto mt-5">
                <tbody>
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
                    <x-utility-button type="submit" class="outline-success" icon="fa-regular fa-pen-to-square me-2">
                        フィードバックを更新
                    </x-utility-button>
                </div>
        </form>
    </div>
    </div>
@endsection
