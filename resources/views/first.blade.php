@include('header')

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-column mt-5">
        <div class="btn">
            <x-utility-button href="{{ route('adminShowLogin') }}" class="success me-5">
                管理者の方はこちら
            </x-utility-button>

            <x-utility-button href="{{ route('login') }}" class="secondary">
                自己評価をされる方はこちら
            </x-utility-button>
        </div>
    </div>
</div>
@endsection
