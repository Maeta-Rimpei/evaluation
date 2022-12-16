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
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#{{ 'modal' . $user['staff_id'] }}">
                            削除する
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="{{ 'modal' . $user['staff_id'] }}" tabindex="-1"
                            aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">確認：削除しようとしています</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $user['name'] }}さんを本当に削除しますか？
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">キャンセル</button>
                                        <a href={{ route('exeStaffSoftDeleted', $user['id']) }}>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
@endsection