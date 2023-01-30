@extends('user.home')

@section('evaluation')
    <div class="container px-0">
        <dl class="border-bottom d-flex">
            <dt class="px-5 py-2 border-end">総合評価</dt>
            <dd class="mx-auto mt-2"><strong>{{ $user_total_evaluation }}</strong></dd>
        </dl>
        <dl class="d-flex flex-column align-items-stretch">
            <dt class="ps-1">【コメント】</dt>
            <dd class="ps-3"><strong>{{ $user_evaluation }}</strong></dd>
        </dl>
    @endsection
