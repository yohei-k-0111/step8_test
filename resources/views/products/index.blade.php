@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品情報一覧画面</h1>

@if (session('dlt_message'))
        <div class="alert alert__danger">
            {{ session('dlt_message') }}
        </div>
@endif

    <a href="{{ route('products.create') }}" class="btn btn__register">商品新規登録</a>

    <!-- 検索フォーム -->
    <div class="search">
        
        <h2 class="search__ttl">検索条件で絞り込む</h2>
        
        <form id="searchProduct" action="{{ route('products.index') }}" method="GET">
        @csrf
            <div class="search__item">
                <input id="txtSearchProduct" class="form search__item--form" type="text" name="search"
                placeholder="商品名" value="{{ request('search') }}">
            </div>
            <div class="search__item">
                <select id="drpSearchCompany" class="form search__item--form" name="select">
                    <option value="">メーカー選択</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
                </select>
            </div>
            <!-- 絞り込みボタン -->
            <div class="search__item">
                <button id="btnSearchItem" class="btn search__item--btn" type="button">絞り込み</button>
            </div>
        </form>
    </div>

    <!-- 検索条件リセットボタン -->
    <a href="{{ route('products.index') }}" class="btn">検索条件を元に戻す</a>

    <!-- 商品情報一覧 -->
    <div class="products">
        <h2>商品情報</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>商品ID</th>
                    <th>商品名</th>
                    <th>メーカー</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>コメント</th>
                    <th>商品画像</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="tableReplace">
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->company->company_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->comment }}</td>
                    <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn__info">詳細表示</a>
                        <form id="dltProduct" method="POST" data-productId="{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}">
                            @csrf
                            @method('DELETE')
                            <button id="btnDltProduct" type="button" class="btn btn__dlt" onclick="return confirm('削除しますか?');">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
