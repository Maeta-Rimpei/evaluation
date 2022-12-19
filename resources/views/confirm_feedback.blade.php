@extends(layouts.app)

@section('evaluation')
<table class="table">
    <tr>
        <th>総合評価</th>
        <td>{{ $user_total_evaluation }}</td>
    </tr>
    <tr>
        <th>コメント</th>
        <td>{{ $user_evalution }}</td>
    </tr>
</table>
@endsection