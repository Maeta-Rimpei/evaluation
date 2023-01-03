@extends('admin.index')

@section('content')
    <h2 class="text-center">質問検索</h2>

    <div class="container mt-3">
        <div class="form-contents">
            <form action="{{ route('searchQuestion') }}" method="GET">
                @csrf
                <table class="mt-5 mx-auto">
                    <tbody>
                        <tr>
                            <th class="mt-3">
                                <label class="me-3" for="keyword">キーワード</label>
                            </th>
                            <td>
                                <input class="form-control" type="search" name="keyword" id="keyword"
                                    value="{{ $keyword }}" placeholder="キーワードを入力してください">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="category">カテゴリー</label>
                            </th>
                            <td>
                                <select class="form-select mt-5" name="category" id="category">
                                    <option value="">指定なし</option>
                                    @foreach (App\Consts\CategoryConsts::CATEGORY_LIST as $num => $category)
                                        <option value="{{ $num }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="role_id">対象職員</label>
                            </th>
                            <td>
                                <select class="form-select mt-5" name="role_id" aria-label="Default select example">
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
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">質問ID</th>
                    <th scope="col" style="width: 45%;" class="text-center">質問内容</th>
                    <th scope="col" class="text-center">カテゴリー</th>
                    <th scope="col" class="text-center">対象職員</th>
                </tr>
            </thead>
            @forelse ($search_questions as $search_question)
                <tr>
                    <th scope="row" class="text-center">{{ $search_question->id }}</th>
                    <td>{{ $search_question->content }}</td>
                    <td class="text-center">{{ App\Consts\CategoryConsts::CATEGORY_LIST[$search_question->category] }}
                    </td>
                    <td class="text-center">{{ App\Consts\StaffPositionConsts::STAFF_LIST[$search_question->role_id] }}
                    </td>
                    <td class="text-center">
                        <x-utility-button href="{{ route('showEditQuestionForm', $search_question->id) }}" class="success" icon="fa-regular fa-pen-to-square me-2">
                            編集
                        </x-utility-button>
                    </td>
                    <td class="text-center">
                        <x-modal-and-delete-button data-bs-toggle="modal"
                        data-bs-target="#{{ 'modal' . $search_question->id }}"
                        icon="fa-solid fa-trash me-2" id="{{ 'modal' . $search_question->id }}"
                        title="確認：削除しようとしています"
                        body="{{ mb_substr($search_question->content, 0, 10, 'UTF-8') }}......この質問を本当に削除しますか？" href="{{ route('exeDestroyedQuestion', $search_question->id) }}">
                        </x-modal-and-delete-button>
                    </td>
                </tr>
            @empty
                <p class="mt-5 text-center">検索された質問は見つかりませんでした。</p>
            @endforelse
        </table>
        <div class="mt-3 mx-auto">
            {{ $search_questions->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
