<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '商品管理システム') }}</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">

</head>
<body>
    <div id="app">
        <nav class="navbar">
            <div class="navbar__container">
                <a class="navbar__container--brand" href="{{ url('/') }}">
                    {{ config('app.name', '商品管理システム') }}
                </a>
                <div class="navbar__container--menu" id="navbarSupportedContent">
                        <!-- Right Side Of Navbar -->
                        <ul>
                    @guest
                        @if (Route::has('login'))
                            <li class="nav__item">
                                <a class="btn nav__item--link" href="{{ route('login') }}">ログイン画面</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav__item--bottom">
                                <a class="btn nav__item--link" href="{{ route('register') }}">新規登録画面</a>
                            </li>
                        @endif
                    @else
                        </ul>
                        <ul class="nav__item">
                            <li class="nav__item--login-name">
                                {{ Auth::user()->name.'さん' }}
                            </li>
                            <li class="nav__item--bottom">
                                <a class="btn nav__item--logout-btn" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('btnLogoutForm').submit();">{{
                                     'ログアウト' }}</a>
                                <form id="btnLogoutForm" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    @endguest
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
