@extends('layouts.app')

@section('content')
<div class="container align-middle">
    <div class="text-center">
        <p>自己評価を受け付けました。お疲れさまでした。</p>
        <a href={{ route('home') }}>戻る</a>    
    </div>
</div>
@endsection