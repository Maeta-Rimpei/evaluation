@extends('admin.index')

@section('content')
    <div class="container mt-3 justify-content-center">
        <h2 class="text-center">職員登録</h2>

        <x-utility-button href="{{ route('showStaff') }}" class="secondary mb-3" icon="fa-solid fa-arrow-left me-2">
            戻る
        </x-utility-button>

        {{-- 登録完了メッセージ --}}
        @if (session('createMessage'))
            <div class="alert alert-success text-center">
                {{ session('createMessage') }}
            </div>
        @endif

        <div class="form-contents">
            <form action={{ route('exeRegisterStaff') }} method="post">
                @csrf
                <table class="mt-3 mx-auto">
                    <tbody>
                        <tr>
                            <th>
                                <label class="mt-5" for="staff_code">職員コード</label>
                            </th>
                            <td>
                                <input type="text"
                                    class="form-control @error('staff_code') is-invalid @enderror mt-5 ms-5"
                                    name="staff_code" value="{{ old('staff_code') }}" id="staff_code" placeholder="登録する方の職員コードを入力">
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
                                <input type="text" class="form-control @error('name') is-invalid @enderror mt-5 ms-5"
                                    name="name" value="{{ old('name') }}" id="name" placeholder="登録する方の名前を入力">
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
                                    name="affiliation" value="{{ old('affiliation') }}" id="affiliation" placeholder="登録する方の所属を入力">
                                @error('affiliation')
                                    <span class="invalid-feedback ms-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="password">パスワード</label>
                            </th>
                            <td>
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror mt-5 ms-5" name="password"
                                    id="password" placeholder="登録する方の仮パスワードを入力">
                                @error('password')
                                    <span class="invalid-feedback ms-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="password_confirmation">パスワード(確認)</label>
                            </th>
                            <td>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror mt-5 ms-5"
                                    name="password_confirmation" id="password_confirmation" placeholder="確認のためもう一度入力してください">
                                @error('password_confirmation')
                                    <span class="invalid-feedback ms-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
        <div class="text-center">
            <button class="btn btn-primary mt-5 mx-auto" type="submit">登録</button>
        </div>
        </form>
    </div>
@endsection
