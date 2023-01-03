@extends('admin.index')

@section('content')
    <h2 class="mb-3 text-center">職員削除</h3>

    @if (session('deleteMessage'))
        <div class="alert alert-danger text-center">
            {{ session('deleteMessage') }}
        </div>
    @elseif (session('editMessage'))

        <div class="alert alert-success text-center">
            {{ session('editMessage') }}
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
                    <td> </td>
                    <td>
                        <x-modal-and-delete-button type="button" buttonClass="danger" data-bs-toggle="modal" data-bs-target="#{{ 'modal' . $user['staff_id'] }}" icon="fa-solid fa-user-minus me-2" id="{{ 'modal' . $user['staff_id'] }}" title="確認：削除しようとしています" body="{{ $user['name'] }}さんを本当に削除しますか？" href="{{ route('exeSoftDeleteStaff', $user['id']) }}"></x-modal-and-delete-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
