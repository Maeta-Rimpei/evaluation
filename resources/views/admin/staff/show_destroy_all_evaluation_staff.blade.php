@extends('admin.index')

@section('content')
<div class="container">

<h2 class="text-center">全職員フィードバック一覧</h2>

<div class="my-3">
    <x-modal-and-delete-button type="button" buttonClass="danger" data-bs-toggle="modal"
        data-bs-target="#modal" icon="fa-solid fa-trash me-2" id="modal"
        title="確認：削除しようとしています" body="全職員のフィードバックを本当に削除しますか？"
        href="{{ route('exeDestroyAllEvaluationStaff') }}">
    </x-modal-and-delete-button>
</div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center" scope="col" style="width: 20%">職員名</th>
                <th class="text-center" scope="col" style="width: 10%">総合評価</th>
                <th class="text-center" scope="col" style="width: 70%">フィードバックコメント</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th class="text-center">{{ $user['name'] }}</th>
                    <td class="text-center">{{ $user['total_evaluation'] }}</td>
                    <td>{{ $user['evaluation'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
