
// 一旦、"app.blade.php"内に記述する

$.ajaxSetup({

  headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },

  })

$('#btnSearchItem').on('click', function() {

    // $('.user-table tbody').empty(); //もともとある要素を空にする
    // $('.search-null').remove(); //検索結果が0のときのテキストを消す
    e.preventDefault(); //追加 
    let searchWord = $('input[name="search"]').val();
  
    $.ajax({

        url: "{{ route('iza') }}", //bladeファイル外でjsを書いているとroute()使えないので代替が必要//LaravelのルーティングにつなぐURL
        method: "POST",
        data: { searchWord : searchWord },
        dataType: "json",

      }).done(function(res){

        console.log(res);
        $('ul').append('<li>'+ res + '</li>'); //他を要追加

      }).faile(function(){

        alert('通信が失敗しました');

      });

    });

// 今回は、bladeファイル内に記述してるのでroute()関数が使用できますが、jsファイルに区別して記述する場合もあります。
// その場合は、route()関数は使用できないので、別の方法でURLを渡す必要があるので注意してください。