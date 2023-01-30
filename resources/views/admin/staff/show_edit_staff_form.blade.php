@extends('admin.index')


@section('content')
    <div class="container mt-3 justify-content-center">
        <h2 class="text-center">職員情報編集</h2>

        <x-utility-button href="{{ route('showEditStaff') }}" class="secondary" icon="fa-solid fa-arrow-left me-2">
            戻る
        </x-utility-button>

        <div class="form-contents">
            <form action={{ route('exeUpdateStaff', $user['id']) }} method="post">
                @csrf
                @method('patch')
                <table class="mt-3 mx-auto">
                    <tbody>
                        <tr>
                            <th>
                                <label class="mt-5" for="staff_code">職員コード</label>
                            </th>
                            <td>
                                <input type="text" class="form-control @error('staff_code') is-invalid @enderror mt-5 ms-5" name="staff_code" value="{{ $user['staff_code'] }}" id="staff_code">
                                @error('staff_code')
                                    <span class="invalid-feedback ms-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="name">名前</label>
                            </th>
                            <td>
                                <input type="text" class="form-control @error('name') is-invalid @enderror mt-5 ms-5" name="name" value="{{ $user['name'] }}" id="name">
                                @error('name')
                                    <span class="invalid-feedback ms-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="role_id">職位</label>
                            </th>
                            <td>
                                <select class="form-select @error('role_id') is-invalid @enderror mt-5 ms-5" name="role_id"
                                    id="role_id" aria-label="Default select example">
                                    <option disabled>選択してください</option>
                                    @foreach (App\Consts\StaffPositionConsts::STAFF_LIST as $num => $position)
                                        <option value={{ $num }}>{{ $position }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <span class="invalid-feedback ms-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="affiliation">所属</label>
                            </th>
                            <td>
                                <input type="text"
                                    class="form-control @error('affiliation') is-invalid @enderror mt-5 ms-5"
                                    name="affiliation" value="{{ $user['affiliation'] }}" id="affiliation">
                                @error('affiliation')
                                    <span class="invalid-feedback ms-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center mt-5">
                    <x-utility-button type="submit" class="success" icon="fa-regular fa-pen-to-square me-2">
                        更新
                    </x-utility-button>
                </div>
            </form>
        </div>
    </div>
@endsection
