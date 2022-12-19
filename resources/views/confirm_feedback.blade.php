@extends('home')

@section('evaluation')
 @parent
<table class="table">
    <tr>
        <th>総合評価</th>
        <td class="text-center align-middle"><strong>{{ $user_total_evaluation }}</strong></td>
    </tr>
    <tr>
        <th>コメント</th>
        <td>{{ $user_evaluation }}</td>
    </tr>
</table>
@endsection
