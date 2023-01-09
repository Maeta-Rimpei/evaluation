@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mx-auto" style="width: 70%;">
            <div class="card-header">
                <h3>【職員名】{{ $user['name'] }}</h3>
            </div>
            <table class="table mb-0">
                <thead>

                    <tr>
                        <th>【職員コード】</th>
                        <td>{{ $user['staff_code'] }}</td>
                    </tr>
                    <tr>
                        <th>【所属】</th>
                        <td>{{ $user['affiliation'] }}</td>
                    </tr>
                    <tr>
                        <th>【職位】</th>
                        <td>{{ App\Consts\StaffPositionConsts::STAFF_LIST[$user['role_id']] }}</td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <x-utility-button href="{{ route('showChangePassword') }}" class="secondary"
                                icon="fa-solid fa-pen-to-square">
                              パスワードを変更する
                            </x-utility-button>
                        </td>
                    </tr>
                </thead>
            </table>

            <div class="d-flex flex-row">
                <div class="btn-action" style="min-width: 35%;">
                    {{-- $user_answersの一つ目のanswerプロパティが空かつ、ルートがhomeの場合 --}}
                    @if (empty($user_answers[0]['answer']) and Route::is('home'))
                        <div class="ms-2 mt-2">
                            <x-utility-button href="{{ route('evaluationForm') }}" class="outline-primary mb-2"
                                icon="fa-solid fa-pen">
                                回答はこちらから
                            </x-utility-button>
                        </div>
                    @elseif (!empty($user_answers[0]['answer']) or Route::is('confirmFeedback'))
                        {{-- $user_answersの一つ目のanswerプロパティが存在するまたは、フィードバック閲覧時の場合 --}}
                        <div class="ms-2 mt-4">
                            <x-utility-button class="outline-primary disabled" icon="fa-solid fa-check">
                                回答済です
                            </x-utility-button>
                        </div>

                        <div class="ms-2 my-3">
                            <x-utility-button href="{{ route('confirmAnswers') }}" class="info" icon="fa-solid fa-eye">
                                自分の回答を確認
                            </x-utility-button>
                        </div>
                    @endif

                    @if (!empty($user['evaluation']) and !empty($user['total_evaluation']) and Route::is('home'))
                        <div class="ms-2 my-2">
                            <x-utility-button href="{{ route('confirmFeedback') }}" icon="fa-solid fa-eye">
                                フィードバックを確認
                            </x-utility-button>
                        </div>
                    @elseif (Route::is('confirmFeedback'))
                        <div class="ms-2 my-2">
                            <x-utility-button href="{{ route('home') }}" class="secondary" icon="fa-solid fa-circle-xmark">
                                閉じる
                            </x-utility-button>
                        </div>
                    @endif
                </div>
                <div class="evaluation border-start ms-3" style="width: 65%;">
                    @if (empty($user['evaluation']) or empty($user['total_evaluation']))
                        <p class="mt-3 text-center">{{ $user['name'] }} さんへのフィードバックはまだありません。</p>
                    @else
                        @yield('evaluation')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
