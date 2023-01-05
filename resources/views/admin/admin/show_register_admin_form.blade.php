@extends('admin.index')

@section('content')
    <div class="container mt-3 justify-content-center">
        <h2 class="text-center">管理者登録</h2>
        <p class="text-center" style="color: red;">※ こちらは管理者登録用フォームです。</p>

        <x-utility-button href="{{ route('showAdmin') }}" class="secondary mb-3" icon="fa-solid fa-arrow-left me-2">
            戻る
        </x-utility-button>

        {{-- 登録完了メッセージ --}}
        @if (session('createAdminMessage'))
            <div class="alert alert-success text-center">
                {{ session('createAdminMessage') }}
            </div>
        @endif

        <div class="form-contents">
            <form action={{ route('exeRegisterAdmin') }} method="post">
                @csrf
                <table class="mt-3 mx-auto">
                    <tbody>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="staff_id">職員コード</label>
                            </th>
                            <td>
                                <input type="text" class="form-control @error('staff_id') is-invalid @enderror mt-5 ms-5"
                                    name="staff_id" value="{{ old('staff_id') }}" id="staff_id"
                                    placeholder="登録する方の職員コードを入力">
                                @error('staff_id')
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
                                <input type="text" class="form-control  @error('name') is-invalid @enderror mt-5 ms-5"
                                    name="name" value="{{ old('name') }}" placeholder="登録する方の名前を入力" id="name">
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
                                <select class="form-select  @error('role_id') is-invalid @enderror mt-5 ms-5" name="role_id"
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
                                    name="affiliation" value="{{ old('affiliation') }}" id="affiliation"
                                    placeholder="登録する方の所属を入力">
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
                                    placeholder="登録する方の仮パスワードを入力" id="password">
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
