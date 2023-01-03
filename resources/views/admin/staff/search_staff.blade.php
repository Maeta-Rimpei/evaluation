@extends('admin.index')

@section('content')
    <h2 class="text-center">職員検索</h2>

    <div class="container mt-5">
        <div class="form-contents">
            <form action="{{ route('searchStaff') }}" method="GET">
                @csrf
                <table class="mt-3 mx-auto">
                    <tbody>
                        @php
                            $label = '職員名';
                        @endphp
                        <x-searchBox :label=$label name="name" value="{{ $name }}"></x-searchBox>

                        @php
                            $label = '職員コード';
                        @endphp
                        <x-searchBox :label=$label name="staff_id" value="{{ $staff_id }}"></x-searchBox>
                        

                        @php
                            $label = '所属';
                            $options = array_values($user_affiliations);
                        @endphp

                        <x-selectBox :label=$label name="affiliation" :options=$options></x-searchBox>
                        {{-- <tr>
                            <th>
                                <label class="mt-5 me-3" for="affiliation">所属</label>
                            </th>
                            <td>
                                <select class="form-select mt-5 ms-5" name="affiliation" id="affiliation">
                                    <option value="">指定なし</option>
                                    @foreach ($user_affiliations as $user_affiliation)
                                        <option value="{{ $user_affiliation->affiliation }}">
                                            {{ $user_affiliation->affiliation }}</option>
                                    @endforeach

                                </select>
                            </td>
                        </tr> --}}
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
                    <th scope="row" class="text-center">{{ $search_staff->staff_id }}</th>
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
