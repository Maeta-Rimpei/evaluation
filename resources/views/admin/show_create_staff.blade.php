@extends('admin.index')

@section('content')
    <div class="container mt-3 justify-content-center">
        <h2 class="text-center">職員登録</h2>

        @if (session('createMessage'))
            <div class="alert alert-success text-center">
                {{ session('createMessage') }}
            </div>
        @endif
        <div class="form-contents">
            <form action={{ route('create') }} method="post">
                @csrf
                <table class="mt-3">
                    <tbody>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="staff_id">職員コード</label>
                            </th>
                            <td>
                                <input type="text" class="mt-5" name="staff_id" id="staff_id" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="name">名前</label>
                            </th>
                            <td>
                                <input type="text" class="mt-5" name="name" id="name" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="role_id">職位</label>
                            </th>
                            <td>
                                <select class="form-select mt-5" name="role_id" id="role_id"
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
                                <input type="text" class="mt-5" name="affiliation" id="affiliation" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="password">パスワード</label>
                            </th>
                            <td>
                                <input type="password" class="mt-5" name="password" id="password" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="password_confirmation">パスワード(確認)</label>
                            </th>
                            <td>
                                <input type="password" class="mt-5" name="password_confirmation"
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
