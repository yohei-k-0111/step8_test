<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

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

            var search_word = $('input[name="search"]').val(); //商品検索窓の入力値"value"の値
            var select_word = $('select').val(); //メーカー検索窓の入力値"value"の値
            console.log("絞込み検索クリック"); //検索実行確認
            console.log(search_word); //検索ワード確認
            console.log(select_word); //検索ワード確認

            $.ajax({

                url: "{{ route('products.index') }}", //リクエスト先のurl
                method: "GET", //送信方式
                data: {
                    'search' : search_word,
                    'select' : select_word
                }, //サーバーに送りたいデータ：検索入力値（valueの中身をvar変数に置き換えた）
                dataType: "html", //またはjson

            }).done(function(products){

                console.log("成功"); //データ受け渡し成功確認
                console.log(products); //controllerから受け取ったindex.blade.php画面全体確認
                var replace = $(products).find("#tableReplace"); //絞り込まれたテーブル部分
                $("#tableReplace").replaceWith(replace); //元のテーブルからreplaceに置き換える

            }).fail(function(products){

                console.log("失敗"); //データ受け渡し失敗確認
                alert('通信が失敗しました'); //失敗時の警告表示

            });
        });

        $('#btnDltProduct').on('click', function() {

            var delete_confirm = confirm('本当に削除しますか？');

            //　メッセージをOKした時（true)の場合、次に進みます 
            if(delete_confirm == true) {
                
                var product_id = $('#dltProduct').attr('data-productId');
                console.log("削除クリック"); //検索実行確認
                console.log(product_id); //検索ワード確認

                //attr()」は、HTML要素の属性を取得したり設定することができるメソッドです
                //今回はinputタグの"data-user_id"という属性の値を取得します
                //"data-user_id"にはレコードの"id"が設定されているので
                // 削除するレコードを指定するためのidの値をここで取得します
                    
                $.ajax({

                    url: "{{ route('products.destroy','product_id') }}", //userID にはレコードのIDが代入されています
                    method: "POST",
                    dataType: "html",
                    data: {'product_id' : product_id}, //削除対象の商品idを送信する

                }).done(function(product_delete){

                    console.log("成功"); //データ受け渡し成功確認
                    console.log(product_delete); //controllerから受け取ったindex.blade.php画面全体確認
                    var replace = $(product_delete).find("#table_replace"); //対象が削除されたテーブル部分
                    $("#table_replace").replaceWith(replace); //元のテーブルからreplaceに置き換える

                }).fail(function(product_delete){

                    console.log("失敗"); //データ受け渡し失敗確認
                    alert('通信が失敗しました'); //失敗時の警告表示

                });
                            
            //”削除しても良いですか”のメッセージで”いいえ”を選択すると次に進み処理がキャンセルされます
            } else {
                (function(e) {
                e.preventDefault()
                });
            };
        });
    </script>
</body>
</html>
