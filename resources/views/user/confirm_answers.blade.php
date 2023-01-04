@extends('layouts.app')

@section('content')
    <h2 class="text-center mb-5">{{ $user['name'] }}さんの回答</h2>

    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center" scope="col" style="width: 5%"></th>
                    <th class="text-center" scope="col" style="width: 70%">質問内容</th>
                    <th class="text-center" scope="col" style="width: 25%">回答</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($user_questions); $i++)
                    <tr>
                        <td></td>
                        <td>{{ $user_questions[$i]['content'] }}</td>
                        <td class="text-center">{{ $user_answers[$i]['answer'] }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
<div class="text-center mt-3">
    <a href="{{ route('home') }}">
        <button class="btn btn-secondary">戻る</button>
    </a>
</div>

    </div>
@endsection
