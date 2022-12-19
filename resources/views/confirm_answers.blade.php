@extends('layouts.app')

@section('content')
<h2 class="text-center mb-5">{{ $user['name'] }}さんの回答</h2>
    @if (empty($user_answers[0]['answer']))
        <p class="text-center">未回答です。自己評価の実施をお願い致します。</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center" scope="col" style="width: 70%">質問内容</th>
                    <th class="text-center" scope="col" style="width: 25%">回答</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($user_questions); $i++)
                    <tr>
                        <td>{{ $user_questions[$i]['content'] }}</td>
                        <td class="text-center">{{ $user_answers[$i]['answer'] }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    @endif
@endsection
