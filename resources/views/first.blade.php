@include('header')

<div class="container">
    <h1 class="text-center">自己評価システム</h1>
    
    <div class="container d-flex flex-column">
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