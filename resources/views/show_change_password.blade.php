@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center mt-3">パスワード変更画面</h2>

        @if (session('alertDifferentPassword'))
            <div class="alert alert-danger text-center">
                {{ session('alertDifferentPassword') }}
            </div>
        @elseif (session('successChangePassword'))
            <div class="alert alert-success text-center">
                {{ session('successChangePassword') }}
            </div>
        @endif


        <form action="{{ route('exeChangePassword') }}" method="post">
            @method('patch')
            @csrf
            <table class="mx-auto mt-5">
                <tr>
                    <th>
                        <label for="current-pass">
                            現在のパスワード
                        </label>
                    </th>
                    <td>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror ms-5"
                            name="current_password" id="current-password">
                        @error('current_password')
                            <span class="invalid-feedback ms-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="password" class="mt-5">
                            新しいパスワード
                        </label>
                    </th>
                    <td>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror ms-5 mt-5" id="password">
                        @error('password')
                            <span class="invalid-feedback ms-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </td>
                </tr>
                <th>
                    <label for="password_confirmation" class="mt-5">
                        新しいパスワード(確認)
                    </label>
                </th>
                <td>
                    <input type="password"
                        class="form-control @error('password_confirmation') is-invalid @enderror ms-5 mt-5"
                        name="password_confirmation" id="password_confirmation">
                    @error('password_confirmation')
                        <span class="invalid-feedback ms-5" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </td>
                </tr>
            </table>
            <div class="button text-center mt-5">
                <button class="btn btn-primary">変更</button>
            </div>
        </form>
        <a href="{{ route('home') }}">
        <div class="button text-center mt-5">
            <button class="btn btn-secondary">ホームへ戻る</button>
        </a>
        </div>
    @endsection
