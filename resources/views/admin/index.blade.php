@include('header')

<div class="main-wrapper">
    <div class="header">
        <h1>管理者画面</h1>
        <div class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle user-name" href="#" role="button"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href={{ route('logout') }}
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    {{ 'ログアウト' }}
                </a>

                <form id="logout-form" action={{ route('logout') }} method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <div class="side-bar">
            <ul class="side-bar-item">
                <li><a href="{{ route('showStaff') }}">職員一覧</a></li>
                <li><a href="{{ route('showAdmin') }}">管理者一覧</a></li>
                <li><a href="{{ route('showQuestionEdit') }}">自己評価シート編集</a></li>
            </ul>
        </div>

        <div class="dummy"></div>
        <div class="main-content">
            @yield('content')
        </div>
    </div>
</div>

</html>
