@include('header')

<h1 class="text-center">自己評価アプリ</h1>

<div class="container d-flex flex-column">
    <div class="btn">
        <a href={{ route('adminShowLogin') }}>
            <button type="button" class="btn btn-success me-5">管理者の方はこちら</button>
        </a>
        
        <a href={{ route('login') }}>
            <button type="button" class="btn btn-secondary">自己評価をされる方はこちら</button>
        </a>
    </div>
</div>