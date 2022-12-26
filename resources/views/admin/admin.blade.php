@extends('admin.index')

@section('content')
    <h2 class="text-center mb-3">管理者一覧</h2>

    <a class="mb-2" style="text-decoration: none;" href="{{ route('register') }}">
        <x-utility-button class="primary mb-3 me-2" icon="fa-solid fa-user-plus me-2">
            管理者登録
        </x-utility-button>
        </a>
    <a style="text-decoration: none;" href="{{ route('searchStaff') }}">
        <x-utility-button class="secondary mb-3 me-2" icon="fa-sharp fa-solid fa-magnifying-glass me-2">
            管理者を検索
        </x-utility-button>
    </a>
    <a style="text-decoration: none;" class="mb-2" href="{{ route('showStaffSoftDeleted') }}">
        <x-utility-button class="danger mb-3" icon="fa-solid fa-user-minus me-2">
            管理者削除
        </x-utility-button>
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
            @foreach ($admins as $admin)
                <tr>
                    <th scope="row">{{ $admin['staff_id'] }}</th>
                    <td></td>
                    <td></td>
                    <td>{{ $admin['name'] }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $admin['affiliation'] }}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
