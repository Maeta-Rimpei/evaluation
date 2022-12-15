@extends('admin.index')

@section('content')
    <h2 class="text-center">職員検索</h2>

    <div class="container mt-3">
        <form action="{{ route('searchAdmin') }}" method="GET">
            @csrf
            <table class="mt-5 mx-auto">
                <tbody>
                    <tr>
                        <th class="mt-3">
                            <label class="me-3" for="name">職員名</label>
                        </th>
                        <td>
                            <input class="form-control ms-5" type="search" name="name" id="name"
                                value="{{ $name }}">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label class="mt-5 me-3" for="staff_id">職員コード</label>
                        </th>
                        <td>
                            <input class="form-control mt-5 ms-5" name="staff_id" id="staff_id">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label class="mt-5 me-3" for="affiliation">所属</label>
                        </th>
                        <td>
                            <select class="form-select mt-5 ms-5" name="affiliation" id="affiliation">
                                <option value="">指定なし</option>
                                @foreach ($admin_affiliations as $admin_affiliation)
                                    <option value="{{ $admin_affiliation->affiliation }}">
                                        {{ $admin_affiliation->affiliation }}</option>
                                @endforeach

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label class="mt-5 me-3" for="role_id">職位</label>
                        </th>
                        <td>
                            <select class="form-select mt-5 ms-5" name="role_id" aria-label="Default select example">
                                <option value="">指定なし</option>
                                @foreach (App\Consts\StaffPositionConsts::STAFF_LIST as $num => $position)
                                    <option value="{{ $num }}">{{ $position }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
    <div class="text-center">
        <button class="btn btn-secondary mt-5 mx-auto" type="submit">検索</button>
        </form>
    </div>

    {{-- 以下、検索結果 --}}
    <div class="container mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 15%;">職員コード</th>
                    <th scope="col" style="width: 30%;" class="text-center">職員名</th>
                    <th scope="col" class="text-center">所属</th>
                    <th scope="col" class="text-center">職位</th>
                </tr>
            </thead>
            @forelse ($search_admins as $search_admin)
                <tr>
                    <th scope="row" class="text-center">{{ $search_admin->staff_id }}</th>
                    <td class="text-center">{{ $search_admin->name }}</td>
                    <td class="text-center">{{ $search_admin->affiliation }}
                    </td>
                    <td class="text-center">{{ App\Consts\StaffPositionConsts::STAFF_LIST[$search_admin->role_id] }}
                    </td>
                </tr>
            @empty
                <p class="mt-5 text-center">検索された職員は見つかりませんでした。</p>
            @endforelse
        </table>
        <div class="mt-3 mx-auto">
            {{ $search_admins->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
