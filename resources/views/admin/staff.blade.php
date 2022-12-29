@extends('admin.index')

@section('content')
    <h2 class="text-center mb-3">職員一覧</h2>

    @if (session('destroyedAllEvaluationMessage'))
            <div class="alert alert-danger text-center">
                {{ session('destroyedAllEvaluationMessage') }}
            </div>
        @endif

    <div class="btn mt-5">
        <x-utility-button href="{{ route('register') }}" class="primary mb-3 me-2" icon="fa-solid fa-user-plus me-2">
            職員登録
        </x-utility-button>

        <x-utility-button href="{{ route('searchStaff') }}" class="secondary mb-3 me-2"
            icon="fa-sharp fa-solid fa-magnifying-glass me-2">
            職員を検索
        </x-utility-button>

        <x-utility-button href="{{ route('showStaffSoftDeleted') }}" class="danger mb-3" icon="fa-solid fa-user-minus me-2">
            職員削除
        </x-utility-button>
    </div>

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
                <th scope="col">
                    <x-utility-button href="{{ route('showDestroyedEvaluationStaff') }}" class="outline-primary" icon="fa-solid fa-list me-2">
                        全職員フィードバック一覧
                    </x-utility-button>
                </th>
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
                    <td>
                        <a href={{ route('showStaffDetail', $user['id']) }}>
                            <x-utility-button class="outline-primary" icon="fa-solid fa-list me-2">
                                回答結果
                            </x-utility-button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
