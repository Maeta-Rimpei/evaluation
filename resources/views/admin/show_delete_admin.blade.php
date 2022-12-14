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
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#{{ 'modal' . $admin['staff_id'] }}">
                            削除する
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="{{ 'modal' . $admin['staff_id'] }}" tabindex="-1"
                            aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">確認：削除しようとしています</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $admin['name'] }}さんを本当に削除しますか？
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">キャンセル</button>
                                        <a href={{ route('exeAdminSoftDeleted', $admin['id']) }}>
                                            <button type="button" class="btn btn-danger">削除する</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
