@extends('layouts.app')

@section('content')
    <div class="container">

        @if (session('loginErrorMessage'))
        <div class="alert alert-danger text-center">
            {{ session('loginErrorMessage') }}
        </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success" style="--bs-bg-opacity: .5;">ログイン(管理者用)</div>

                    <div class="card-body">
                        <form method="POST" action={{ route('adminLogin') }}>
                            @csrf
                            <div class="row mb-3">
                                <label for="staff_code" class="col-md-4 col-form-label text-md-end">職員コード</label>
                                <div class="col-md-6">
                                    <input id="staff_code" type="staff_code"
                                        class="form-control @error('staff_code') is-invalid @enderror" name="staff_code"
                                        autocomplete="staff_code">

                                    @error('staff_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">パスワード</label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <x-utility-button type="submit">
                                        ログイン
                                    </x-utility-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
