@extends('admin.index')

@section('content')
    <div class="container">
        <h3 class="mb-3">
            </h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" scope="col" style="width: 5%">質問ID</th>
                        <th class="text-center" scope="col" style="width: 70%">項目</th>
                        <th scope="col" style="width: 12.5%"></th>
                        <th scope="col" style="width: 12.5%"></th>
                    </tr>                </thead>
                <tbody>
                    @foreach ($questions as $question)
                        <tr>
                            <th class="text-center">{{ $question->question_id }}</th>
                            <td>{{ $question->content }}</td>
                            <td class="text-center">
                                <a href={{ route('editForm', $question->question_id) }}>
                                    <button type="button" class="btn btn-success">編集</button>
                                </a>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger">削除</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
@endsection
