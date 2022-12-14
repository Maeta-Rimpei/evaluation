@extends('admin.index')

@section('content')
    <h2 class="text-center mb-3">職員一覧</h2>

    <a class="mb-2" style="text-decoration: none;" href="{{ route('register') }}">
        <button type="button" class="btn btn-primary mb-3 me-2">職員登録</button>
        </a>
    <a style="text-decoration: none;" href="{{ route('searchStaff') }}">
        <button type="button" class="btn btn-secondary mb-3 me-2">職員を検索</button>
    </a>
    <a style="text-decoration: none;" class="mb-2" href="{{ route('showStaffSoftDeleted') }}">
        <button type="button" class="btn btn-danger mb-3">職員削除</button>
    </a>
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
                <td><a href={{ route('showStaffDetail', $user['id']) }}>回答結果</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
