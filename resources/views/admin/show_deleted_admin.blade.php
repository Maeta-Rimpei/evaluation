@extends('admin.index')

@section('content')
    <h3 class="mb-3">管理者削除</h3>

    @if (session('deleteMessage'))
        <div class="alert alert-danger text-center">
            {{ session('deleteMessage') }}
        </div>
    @endif

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
                    <td> </td>
                    <td>
                        <x-modal-and-delete-button type="button" buttonClass="danger" data-bs-toggle="modal" data-bs-target="#{{ 'modal' . $admin['staff_id'] }}" icon="fa-solid fa-user-minus me-2" id="{{ 'modal' . $admin['staff_id'] }}" title="確認：削除しようとしています" body="{{ $admin['name'] }}さんを本当に削除しますか？" href="{{ route('exeAdminSoftDeleted', $admin['id']) }}"></x-modal-and-delete-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
