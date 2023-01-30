@extends('admin.index')

@section('content')
<h2 class="text-center">職員情報編集</h2>

<x-utility-button href="{{ route('showAdmin') }}" class="secondary" icon="fa-solid fa-arrow-left me-2">
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
        @foreach ($admins as $admin)
            <tr>
                <th scope="row">{{ $admin['staff_code'] }}</th>
                <td></td>
                <td></td>
                <td>{{ $admin['name'] }}</td>
                <td></td>
                <td></td>
                <td>{{ $admin['affiliation'] }}</td>
                <td></td>
                <td></td>
                <td>
                    <a href={{ route('showEditAdminForm', $admin['id']) }}>
                        <x-utility-button class="success" icon="fa-regular fa-pen-to-square me-2">
                            編集
                        </x-utility-button>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $admins->links() }} 
@endsection