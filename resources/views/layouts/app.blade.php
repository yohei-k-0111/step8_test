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
            var select_id = $('select').val(); //メーカー検索窓の入力値"value"の値
            var search_p_lower = $('input[name="price_lower"]').val(); //価格下限検索の入力値"value"の値
            var search_p_upper = $('input[name="price_upper"]').val(); 
            var search_s_lower = $('input[name="stock_lower"]').val(); 
            var search_s_upper = $('input[name="stock_upper"]').val(); //在庫上限検索の入力値"value"の値
            console.log(search_word); //検索ワード確認
            console.log(select_id); //検索ワード確認
            console.log(search_p_lower, search_p_upper); //価格検索確認
            console.log(search_s_lower, search_s_upper); //在庫検索確認

            $.ajax({

                url: "{{ route('products.index') }}", //リクエスト先のurl
                method: "GET", //送信方式
                data: {
                    'search' : search_word,
                    'select' : select_id,
                    'price_lower' : search_p_lower,
                    'price_upper' : search_p_upper,
                    'stock_lower' : search_s_lower,
                    'stock_upper' : search_s_upper
                }, //サーバーに送りたいデータ：検索入力値（valueの中身をvar変数に置き換えた）
                dataType: "html",

            }).done(function(products){

                console.log("検索成功"); //データ受け渡し成功確認
                console.log(products); //controllerから受け取ったindex.blade.php画面全体確認
                var replace = $(products).find('#tableReplace'); //検索条件を保持したヘッダーとテーブルを抽出
                $('#tableReplace').replaceWith(replace); //元のテーブルからreplaceに置き換える

            }).fail(function(products){

                console.log("検索失敗"); //データ受け渡し失敗確認
                alert('通信が失敗しました'); //失敗時の警告表示

            });
        });

        // var replace_dltbtn = $(replace).find('.btn__dlt');

        $('.btn__dlt').on('click', function(e) {
            //foreachでタブが複製されるためidではなくclass'btn__dlt'指定が必要
            e.preventDefault(); //通常の処理を制御する
            var delete_confirm = confirm('本当に削除しますか？');

            //　メッセージをOKした時（true)の場合、次に進みます 
            if(delete_confirm == true) {
                var click_ele = $(this);
                //$(this)で、foreachの配列の中から、クリックしたthisレコードを指定
                var product_id = click_ele.attr('data-productId');
                //attr()メソッドで、HTML要素の属性を取得したり設定する
                // 'data-productId'自作プロパティで送信したいデータを入れる
                console.log("削除クリック"); //検索実行確認
                console.log(product_id); //検索ワード確認

                $.ajax({

                    url: "{{ route('products.destroy', 'product_id') }}",
                    method: "POST",
                    dataType: "html",
                    data: {
                        'product_id' : product_id,  
                        '_method': 'DELETE'
                    }, //削除対象の商品idとDELETEメソッドを送信する（method:はPOSTかGETしか送れない）

                }).done(function(product_delete){

                    console.log("削除成功"); //データ受け渡し成功確認
                    click_ele.parents('tr').remove(); //DBから削除したレコードのテーブル部分を削除
                    $("#msg").html("<div class='alert alert__danger'><a>商品情報が削除されました</a></div>"); 
                    //削除メッセージを、HTML()で要素を追加する（destroyメソッドの代替）

                }).fail(function(product_delete){

                    console.log("削除失敗"); //データ受け渡し失敗確認
                    alert('通信が失敗しました'); //失敗時の警告表示

                });

            } else {
                (function(e) {
                //”本当に削除しますか？”のメッセージで”いいえ”を選択した場合、キャンセル処理される
                e.preventDefault()
                });
            };
        });
    </script>
</body>
</html>
