@extends('admin.index')

@section('content')
    <h2 class="text-center">職員削除履歴</h2>

    @if (session('restoreStaffMessage'))
        <div class="alert alert-success text-center">
            {{ session('restoreStaffMessage') }}
        </div>
    @endif

    <div class="container">
        @if ($users->isEmpty())
            <h3 class="text-center mt-5">削除された職員はいません。</h3>
        @else
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th class="text-center" scope="col" style="width: 10%">職員コード</th>
                        <th class="text-center" scope="col" style="width: 15%">氏名</th>
                        <th class="text-center" scope="col" style="width: 15%">削除前所属</th>
                        <th class="text-center" scope="col" style="width: 15%">削除前職位</th>
                        <th class="text-center" scope="col" style="width: 15%">削除日</th>
                        <th class="text-center" scope="col" style="width: 30%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th class="text-center">{{ $user['staff_code'] }}</th>
                            <td class="text-center">{{ $user['name'] }}</td>
                            <td class="text-center">{{ $user['affiliation'] }}</td>
                            <td class="text-center">{{ App\Consts\StaffPositionConsts::STAFF_LIST[$user['role_id']] }}</td>
                            <td class="text-center">{{ $user->deleted_at->format('Y年n月j日') }}</td>
                            <td class="text-center">
                                <x-utility-button href="{{ route('exeRestoreHistoryOfSoftDeletedStaff', $user['id']) }}"
                                    icon="fa-solid fa-user-plus me-2">
                                    職員を復元する
                                </x-utility-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
