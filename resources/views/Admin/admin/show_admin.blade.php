@extends('admin.index')

@section('content')
    <h2 class="text-center mb-3">管理者一覧</h2>

    @if (session('editAdminMessage'))
        <div class="alert alert-success text-center">
            {{ session('editAdminMessage') }}
        </div>
    @endif

    <div class="container mt-5">
        {{-- 管理者操作ボタン --}}
        <x-utility-button href="{{ route('showRegistrationAdminForm') }}" class="primary mb-3 me-2"
            icon="fa-solid fa-user-plus me-2">
            管理者登録
        </x-utility-button>

        <x-utility-button href="{{ route('showEditAdmin') }}" class="success mb-3 me-2"
            icon="fa-regular fa-pen-to-square me-2">
            管理者情報編集
        </x-utility-button>

        <x-utility-button href="{{ route('searchAdmin') }}" class="secondary mb-3 me-2"
            icon="fa-sharp fa-solid fa-magnifying-glass me-2">
            管理者を検索
        </x-utility-button>

        <x-utility-button href="{{ route('showSoftDeleteAdmin') }}" class="danger mb-3" icon="fa-solid fa-user-minus me-2">
            管理者削除
        </x-utility-button>

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
                        <th scope="row">{{ $admin['staff_code'] }}</th>
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
    </div>
@endsection
