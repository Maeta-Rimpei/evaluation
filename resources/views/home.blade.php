@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex flex-column bd-highlight mb-3">
            <div class="p-2 bd-highlight">
            <a href={{ route('evaluationForm') }}>
                <button type="button" class="btn btn-outline-primary">回答はこちらから</button>
            </a>
    </div>
@endsection
