@extends('home')

@section('evaluation')
    <table class="table">
        <tr>
            <th>総合評価</th>
            <td class="text-center align-middle">{{ $user_total_evaluation }}</td>
        </tr>
        <tr>
            <th>コメント</th>
            <td>{{ $user_evaluation }}</td>
        </tr>
    </table>
@endsection
