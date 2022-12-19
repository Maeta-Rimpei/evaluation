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
                    {{-- 回答データ配列の一つ目のanswerプロパティが空の場合の処理 --}}
                    @if (empty($user_answers[0]['answer']))
                        <div class="ms-2 mt-4">
                            <a href={{ route('evaluationForm') }}>
                                <button type="button" class="btn btn-outline-primary">回答はこちらから</button>
                            </a>
                        </div>
                    @elseif (empty($user_answers[0]['answer']) Route::has('confirm_feedback'))
                       {{-- 回答データ配列の一つ目のanswerプロパティが存在する場合の処理 --}}
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

                    @if (!empty($user['evaluation']) and !empty($user['total_evaluation']))
                        <div class="ms-2 mb-3">
                            <a href="{{ route('confirmFeedback') }}">
                                <button type="button" class="btn btn-primary my-2">フィードバックを確認する</button>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="evaluation border-start ms-3">
                    @if (empty($user['evaluation']) and empty($user['total_evaluation']))
                        <p class="ms-2 mt-2">まだ {{ $user['name'] }} さんへのフィードバックはありません。</p>
                    @else
                    @yield('evaluation')
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection
