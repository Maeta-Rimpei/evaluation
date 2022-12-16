@extends('admin.index')

@section('content')
    <div class="container mt-3 justify-content-center">
        <h2 class="text-center">管理者登録</h2>
        <p class="text-center" style="color: red;">※ こちらは管理者登録用フォームです。</p>

        @if (session('createAdminMessage'))
            <div class="alert alert-success text-center">
                {{ session('createAdminMessage') }}
            </div>
        @endif

        <div class="form-contents">
            <form action={{ route('exeAdminRegister') }} method="post">
                @csrf
                <table class="mt-3 mx-auto">
                    <tbody>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="staff_id">職員コード</label>
                            </th>
                            <td>
                                <input type="text" class="form-control mt-5 ms-5" name="staff_id" id="staff_id" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="name">名前</label>
                            </th>
                            <td>
                                <input type="text" class="form-control mt-5 ms-5" name="name" id="name" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="role_id">職位</label>
                            </th>
                            <td>
                                <select class="form-select mt-5 ms-5" name="role_id" id="role_id"
                                    aria-label="Default select example">
                                    <option disabled>選択してください</option>
                                    @foreach (App\Consts\StaffPositionConsts::STAFF_LIST as $num => $position)
                                        <option value={{ $num }}>{{ $position }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="affiliation">所属</label>
                            </th>
                            <td>
                                <input type="text" class="form-control mt-5 ms-5" name="affiliation" id="affiliation" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="password">パスワード</label>
                            </th>
                            <td>
                                <input type="password" class="form-control mt-5 ms-5" name="password" id="password" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="password_confirmation">パスワード(確認)</label>
                            </th>
                            <td>
                                <input type="password" class="form-control mt-5 ms-5" name="password_confirmation"
                                    id="password_confirmation" required
                                    @error('password_confirmation') is-invalid @enderror>
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