@extends('admin.index')

@section('content')
    <h2 class="text-center mb-3">質問区分一覧</h2>
    <a href="{{ route('showCreateQuestion') }}"><button type="button" class="btn btn-primary mb-3">質問を新規作成</button></a>
    <a href="{{ route('showSearchQuestion') }}"><button type="button" class="btn btn-secondary ms-2 mb-3">質問を検索</button></a>

    {{-- 一覧 --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach (App\Consts\StaffPositionConsts::STAFF_LIST as $num => $position)
                <tr>
                    <th>{{ $position }}</th>
                    <td>
                        <a href={{ route('showDetailQuestionEdit', $num) }}>
                            <button type="button" class="btn btn-success">編集</button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
