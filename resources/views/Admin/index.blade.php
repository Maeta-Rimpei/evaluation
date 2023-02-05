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
                <a class="dropdown-item" href={{ route('adminLogout') }}
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    ログアウト
                </a>

                <form id="logout-form" action={{ route('adminLogout') }} method="GET" class="d-none">
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
                <li><a href="{{ route('showEditAnswer') }}">回答管理</a></li>
                <li><a href="{{ route('showEditQuestion') }}">自己評価シート編集</a></li>
                <li><a href="{{ route('showHistoryOfSoftDeletedStaff') }}">職員削除履歴</a></li>
                <li><a href="{{ route('showHistoryOfSoftDeletedAdmin')}}">管理者削除履歴</a></li>
                <li><a href="{{ route('showChangeAdminPassword') }}">パスワード変更</a></li>
            </ul>
        </div>

        <div class="dummy"></div>
        <div class="main-content">
            @yield('content')
        </div>
    </div>
</div>

</html>
