@extends('admin.index')

@section('content')
<h2 class="text-center">職員情報編集</h2>

<x-utility-button href="{{ route('showStaff') }}" class="secondary" icon="fa-solid fa-arrow-left me-2">
    戻る
</x-utility-button>

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
        @foreach ($users as $user)
            <tr>
                <th scope="row">{{ $user['staff_code'] }}</th>
                <td></td>
                <td></td>
                <td>{{ $user['name'] }}</td>
                <td></td>
                <td></td>
                <td>{{ $user['affiliation'] }}</td>
                <td></td>
                <td></td>
                <td>
                    <a href={{ route('showEditStaffForm', $user['id']) }}>
                        <x-utility-button class="success" icon="fa-regular fa-pen-to-square me-2">
                            編集
                        </x-utility-button>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $users->links() }} 
@endsection