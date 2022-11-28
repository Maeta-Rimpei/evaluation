@extends('admin.index')

@section('content')
    <h2 class="text-center mb-3">職員一覧</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">職員コード</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">職員名</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">所属</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                
            <tr>
                <th scope="row">{{ $user['staff_id'] }}</th>
                <td></td>
                <td></td>
                <td>{{ $user['name'] }}</td>
                <td></td>
                <td></td>
                <td>{{ $user['affiliation'] }}</td>
                <td></td>
                <td></td>
                <td><a href={{ route('showStaffDetail', $user['id']) }}>評価</a></td>
            </tr>
            @endforeach

        </tbody>
    </table>
@endsection
