@extends('admin.index')

@section('content')
    <div class="container">

        @if (session('editMessage'))
            <div class="alert alert-success text-center">
                {{ session('editMessage') }}
            </div>
        @endif

        @if (session('deleteMessage'))
            <div class="alert alert-danger text-center">
                {{ session('deleteMessage') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center" scope="col" style="width: 5%">質問ID</th>
                    <th class="text-center" scope="col" style="width: 70%">項目</th>
                    <th scope="col" style="width: 12.5%"></th>
                    <th scope="col" style="width: 12.5%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <th class="text-center">{{ $question->question_id }}</th>
                        <td>{{ $question->content }}</td>
                        <td class="text-center">

                            <x-utility-button href="{{ route('showEditQuestionForm', $question->question_id) }}"
                                class="success" icon="fa-regular fa-pen-to-square">
                                編集
                            </x-utility-button>
                        </td>
                        <td class="text-center">
                            <x-modal-and-delete-button
                            type="button" buttonClass="danger" data-bs-toggle="modal"
                            data-bs-target="#{{ 'modal' . $question->question_id }}"
                            icon="fa-solid fa-trash" id="{{ 'modal' . $question->question_id }}" title="確認：削除しようとしています"
                            body="{{ mb_substr($question->content, 0, 10, 'UTF-8') }}......この質問を本当に削除しますか？"
                            href="{{ route('exeDestroyQuestion', $question->question_id) }}">
                        </x-modal-and-delete-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection
