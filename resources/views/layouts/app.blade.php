<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <!-- <script src="{{ asset('js/search.js') }}"></script> -->

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

    <script>
        $.ajaxSetup({

            headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },

        })

        $('#btnSearchItem').on('click', function() {

            e.preventDefault(); //追加 これまでの通常処理をキャンセル
            var searchWord = $(#txtSearchProduct).val(); //$('#txtSearchProduct')id指定でもできそう

            $.ajax({

                url: "{{ route('products.index') }}",
                method: "GET",
                data: { 'searchWord' : searchWord }, //サーバーに送りたいデータ：検索入力値（valueの中身をvar変数に置き換えた）
                dataType: "json",

            }).done(function(res){

                dump($res.products);
                console.log($res.products);

            }).faile(function(){

                alert('通信が失敗しました');

            });

        });

        // 今回は、bladeファイル内に記述してるのでroute()関数が使用できますが、jsファイルに区別して記述する場合もあります。
        // その場合は、route()関数は使用できないので、別の方法でURLを渡す必要があるので注意してください。
    </script>
</body>
</html>
