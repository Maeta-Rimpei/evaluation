@extends('admin.index')

@section('content')
    <h2 class="text-center">職員検索</h2>

    <x-utility-button href="{{ route('showStaff') }}" class="secondary" icon="fa-solid fa-arrow-left me-2">
        戻る
    </x-utility-button>

    <div class="container mt-5">
        <div class="form-contents">
            <form action="{{ route('searchStaff') }}" method="GET">
                @csrf
                <table class="mt-3 mx-auto">
                    <tbody>

                        <x-search-box label="職員名" name="name" value="{{ $name }}"></x-search-box>

                        <x-search-box label="職員コード" name="staff_code" value="{{ $staff_code }}"></x-search-box>

                        <x-search-box label="所属" name="affiliation" value="{{ $affiliation }}"></x-search-box>

                        <x-selectBox name="role_id" label="職位" :options="App\Consts\StaffPositionConsts::STAFF_LIST"></x-selectBox>

                    </tbody>
                </table>
        </div>
        <div class="text-center">
            <button class="btn btn-secondary mt-5 mx-auto" type="submit">検索</button>
        </div>
        </form>
    </div>

    {{-- 以下、検索結果 --}}
    <div class="container mt-5">
        <h3>検索結果</h3>
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 15%;">職員コード</th>
                    <th scope="col" style="width: 30%;" class="text-center">職員名</th>
                    <th scope="col" class="text-center">所属</th>
                    <th scope="col" class="text-center">職位</th>
                    <th scope="col" class="text-center"></th>
                </tr>
            </thead>
            @forelse ($search_staffs as $search_staff)
                <tr>
                    <th scope="row" class="text-center">{{ $search_staff->staff_code }}</th>
                    <td class="text-center">{{ $search_staff->name }}</td>
                    <td class="text-center">{{ $search_staff->affiliation }}
                    </td>
                    <td class="text-center">{{ App\Consts\StaffPositionConsts::STAFF_LIST[$search_staff->role_id] }}
                    </td>
                    <td>
                        <a href={{ route('showStaffDetail', $search_staff->id) }}>
                            <button class="btn btn-outline-primary">回答結果</button>
                        </a>
                    </td>
                </tr>
            @empty
                <p class="mt-5 text-center">検索された職員は見つかりませんでした。</p>
            @endforelse
        </table>
        <div class="mt-3 mx-auto">
            {{ $search_staffs->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
