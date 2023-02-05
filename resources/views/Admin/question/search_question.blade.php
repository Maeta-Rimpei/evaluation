@extends('admin.index')

@section('content')
    <h2 class="text-center">質問検索</h2>

    <x-utility-button href="{{ route('showEditQuestion') }}" class="secondary" icon="fa-solid fa-arrow-left me-2">
        戻る
    </x-utility-button>

    <div class="container mt-3">
        <div class="form-contents">
            <form action="{{ route('searchQuestion') }}" method="GET">
                @csrf
                <table class="mt-5 mx-auto">
                    <tbody>

                        <x-search-box label="キーワード" name="keyword" value="{{ $keyword }}"></x-search-box>

                        <x-selectBox label="カテゴリー" name="category" :options="App\Consts\CategoryConsts::CATEGORY_LIST"></x-selectBox>

                        <x-selectBox label="対象職員" name="role_id" :options="App\Consts\StaffPositionConsts::STAFF_LIST"></x-selectBox>

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
                    <th scope="col" class="text-center"></th>
                    <th scope="col" class="text-center"></th>
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
                        <x-utility-button href="{{ route('showEditQuestionForm', $search_question->id) }}" class="success"
                            icon="fa-regular fa-pen-to-square me-2">
                            編集
                        </x-utility-button>
                    </td>
                    <td class="text-center">
                        <x-modal-and-delete-button type="button" buttonClass="danger" data-bs-toggle="modal"
                            data-bs-target="#{{ 'modal' . $search_question->id }}" icon="fa-solid fa-trash me-2"
                            id="{{ 'modal' . $search_question->id }}" title="確認：削除しようとしています"
                            body="{{ mb_substr($search_question->content, 0, 10, 'UTF-8') }}......この質問を本当に削除しますか？"
                            href="{{ route('exeDestroyQuestion', $search_question->id) }}">
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
