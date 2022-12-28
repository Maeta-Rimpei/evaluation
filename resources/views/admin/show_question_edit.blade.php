@extends('admin.index')

@section('content')
    <h2 class="text-center mb-3">質問区分一覧</h2>
    <x-utility-button href="{{ route('showCreateQuestion') }}" class="primary mb-3" icon="fa-solid fa-circle-plus">
    質問を新規作成
    </x-utility-button>
    <x-utility-button href="{{ route('searchQuestion') }}" class="secondary ms-2 mb-3" icon="fa-sharp fa-solid fa-magnifying-glass me-2">
    質問を検索
    </x-utility-button>

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

                        <x-utility-button href="{{ route('showDetailQuestionEdit', $num) }}" class="success" icon="fa-regular fa-pen-to-square">
                            編集
                        </x-utility-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
