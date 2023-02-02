@extends('admin.index')

@section('content')
    <div class="container mt-3">
        <h2 class="text-center">質問編集</h2>

        <x-utility-button href="{{ route('showEditQuestion') }}" class="secondary" icon="fa-solid fa-arrow-left me-2">
            戻る
        </x-utility-button>

        <form action="{{ route('exeUpdateQuestion', $question->question_id) }}" method="post">
            @csrf
            @method('patch')
            <div>
                <table class="mt-5 mx-auto">
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
                                    class="form-control @error('content') is-invalid @enderror mt-1" name="content" id="content">{{ $question->content }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback ms-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-3 me-3" for="role_id">カテゴリー</label>
                            </th>
                            <td>
                                <select class="form-select mt-1" name="category" id="category" aria-label="Default select">
                                    <option disabled>クリックして選んでください</option>
                                    @foreach (App\Consts\CategoryConsts::CATEGORY_LIST as $num => $category)
                                        <option value="{{ $num }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                                <p class="text-center">
                                    現在のカテゴリー：{{ App\Consts\CategoryConsts::CATEGORY_LIST[$question->category] }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <x-utility-button type="submit" class="success" icon="fa-solid fa-pen">
                    修正する
                </x-utility-button>
            </div>
        </form>
    </div>
@endsection
