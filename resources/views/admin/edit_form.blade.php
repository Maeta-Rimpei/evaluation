@extends('admin.index')

@section('content')
    <div class="container mt-3">
        <h2 class="text-center">質問編集</h2>

        <form action="{{ route('editExe', $question->question_id) }}" method="post">
            @csrf
            @method('patch')
            <div>
                <table class="mt-3">
                    <tbody>
                        <tr>
                            <th>
                                <label class="mt-2 me-3">質問区分</label>
                            </th>
                            <td>
                                {{ App\Consts\StaffPositionConsts::STAFF_LIST[$question->role_id] }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-2 me-3">質問ID</label>
                            </th>
                            <td>{{ $question->question_id }}</td>
                        </tr>
                        <tr>
                            <th>
                                <label for="content" class="mt-2 me-3" for="content">質問内容</label>
                            </th>
                            <td>
                                <textarea style="height: calc( 1.3em * 10 );
                                line-height: 1.3;"
                                    class="form-control mt-1" name="content" id="content" required>{{ $question->content }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-3 me-3" for="role_id">カテゴリー</label>
                            </th>
                            <td>
                                <select class="form-select mt-1" name="category" id="category"
                                aria-label="Default select">
                                <option disabled>クリックして選んでください</option>
                                @foreach (App\Consts\CategoryConsts::CATEGORY_LIST as $num => $category)
                                <option value="{{ $num }}">{{ $category }}</option>
                                @endforeach
                            </select>
                            <p class="text-center">現在のカテゴリー：{{ App\Consts\CategoryConsts::CATEGORY_LIST[$question->category] }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <button class="btn btn-success mt-5 mx-auto" type="submit">編集</button>
            </div>
        </form>
    </div>
@endsection
