@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mx-auto" style="width: 70%;">
            <div class="card-header">
                <h3>【職員名】{{ $user['name'] }}</h3>
            </div>
            <table class="table">
                <thead>
                    
                    <tr>
                        <th>【職員コード】</th>
                        <td>{{ $user['staff_id'] }}</td>
                    </tr>
                    <tr>
                        <th>【所属】</th>
                        <td>{{ $user['affiliation'] }}</td>
                    </tr>
                    <tr>
                        <th>【職位】</th>
                        <td>{{ App\Consts\StaffPositionConsts::STAFF_LIST[$user['role_id']] }}</td>
                    </tr>
                </thead>
            </table>

            <div class="d-flex flex-row">
                <div class="btn-action" style="min-width: 30%;">
                    {{-- $user_answersの一つ目のanswerプロパティが空かつ、ルートがhomeの場合 --}}
                    @if (empty($user_answers[0]['answer']) and Route::is('home'))
                        <div class="ms-2 mt-2">
                            <a href="{{ route('evaluationForm') }}">
                                <button type="button" class="btn btn-outline-primary">回答はこちらから</button>
                            </a>
                        </div>
                        @elseif (!empty($user_answers[0]['answer']) or Route::is('confirmFeedback'))
                        {{-- $user_answersの一つ目のanswerプロパティが存在するまたは、フィードバック閲覧時の場合 --}}
                        <div class="ms-2 mt-4">
                            <button type="button" class="btn btn-outline-primary disabled"><img class="me-1"
                                    src="{{ asset('storage/image/round_done_outline_black_24dp.png') }}" alt="done"
                                    style="width: 20px;"> 回答済です</button>
                        </div>

                        <div class="ms-2 my-3">
                            <a href="{{ route('confirmAnswers') }}">
                                <button type="button" class="btn btn-info">自分の回答を確認する</button>
                            </a>
                        </div>
                    @endif

                    @if (!empty($user['evaluation']) and !empty($user['total_evaluation']) and Route::is('home'))
                        <div class="ms-2 my-2">
                            <a href="{{route('confirmFeedback')}}">
                                <button type="button" class="btn btn-primary">フィードバックを確認する</button>
                            </a>
                        </div>
                        @elseif (Route::is('confirmFeedback'))
                        <div class="ms-2 my-2">
                            <a href="{{route('home')}}">
                                <button type="button" class="btn btn-secondary"><img class="me-1"
                                    src="{{ asset('storage/image/outline_disabled_by_default_black_24dp.png') }}" alt="done"
                                    style="width: 20px;">閉じる</button>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="evaluation border-start ms-3">
                    @if (empty($user['evaluation']) and empty($user['total_evaluation']))
                        <p class="ms-2 mt-2">{{ $user['name'] }} さんへのフィードバックはまだありません。</p>
                    @else
                        @yield('evaluation')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
