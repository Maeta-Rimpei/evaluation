@extends('admin.index')

@section('content')
    <div class="container mt-3 justify-content-center">
        <h2 class="text-center">質問登録</h2>

        @if (session('createMessage'))
            <div class="alert alert-success text-center">
                {{ session('createMessage') }}
            </div>
        @endif

        <div class="form-contents">
            <form action="#" method="post">
                @csrf
                <table class="mt-3">
                    <tbody>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="content">質問内容</label>
                            </th>
                            <td>
                                <textarea class="form-control" name="content" id="content" cols="50" rows="5" required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="category">カテゴリー</label>
                            </th>
                            <td>
                                <input type="text" class="mt-5" name="category" id="category" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="role_id">対象職員(職位)</label>
                            </th>
                            <td>
                                <select class="form-select mt-5" name="role_id" id="role_id"
                                    aria-label="Default select example">
                                    <option disabled>クリックして選んでください</option>
                                    @foreach (App\Consts\StaffPositionConsts::STAFF_LIST as $num => $position)
                                        <option value={{ $num }}>{{ $position }}</option>
                                    @endforeach
                                </select>
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
