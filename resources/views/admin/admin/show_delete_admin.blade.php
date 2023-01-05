@extends('admin.index')

@section('content')
    <h3 class="text-center mb-3">管理者削除</h3>

    <x-utility-button href="{{ route('showAdmin') }}" class="secondary mb-3" icon="fa-solid fa-arrow-left me-2">
        戻る
    </x-utility-button>

    @if (session('deleteMessage'))
        <div class="alert alert-danger text-center">
            {{ session('deleteMessage') }}
        </div>
    @elseif (session('deleteErrorMessage'))
        <div class="alert alert-warning text-center">
            {{ session('deleteErrorMessage') }}
        </div>
    @endif

    <table class="table table-striped mt-5">
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
                        <x-modal-and-delete-button type="button" buttonClass="danger" data-bs-toggle="modal"
                            data-bs-target="#{{ 'modal' . $admin['staff_id'] }}" icon="fa-solid fa-user-minus me-2"
                            id="{{ 'modal' . $admin['staff_id'] }}" title="確認：削除しようとしています"
                            body="{{ $admin['name'] }}さんを本当に削除しますか？" href="{{ route('exeSoftDeleteAdmin', $admin['id']) }}">
                        </x-modal-and-delete-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
