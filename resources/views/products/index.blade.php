@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品情報一覧画面</h1>

    <div id="msg"></div>
    
    <a href="{{ route('products.create') }}" class="btn btn__register">商品新規登録</a>

    <!-- 検索フォーム -->
    <div class="search">
        
        <h2 class="search__ttl">検索条件で絞り込む</h2>
        
        <form id="searchProduct" action="{{ route('products.index') }}" method="GET">
        @csrf
            <ul>
                <li>
                    <!-- 商品名検索 -->
                    <div class="search__item">
                        <input id="txtSearchProduct" class="form search__item--form" type="text" name="search"
                        placeholder="商品名" value="{{ request('search') }}">
                    </div>
                    <!-- メーカー検索 -->
                    <div class="search__item">
                        <select id="drpSearchCompany" class="form search__item--form" name="select">
                            <option value="">メーカー選択</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                        @endforeach
                        </select>
                    </div>
                </li>
                <li>
                    <!-- 価格検索（下限値・上限値） -->
                    <div class="search__item">
                        <input placeholder="価格の下限値" type="text" name="price_lower" id="lowerSearchPrice" class="form search__item--form">
                        <input placeholder="価格の上限値" type="text" name="price_upper" id="upperSearchPrice" class="form search__item--form">
                    </div>
                </li>
                <li>
                    <!-- 在庫数検索（下限値・上限値） -->
                    <div class="search__item">
                        <input placeholder="在庫の下限値" type="text" name="stock_lower" id="lowerSearchStock" class="form search__item--form">
                        <input placeholder="在庫の上限値" type="text" name="stock_upper" id="upperSearchStock" class="form search__item--form">
                    </div>
                </li>
                <li>
                    <!-- 絞り込みボタン -->
                    <div class="search__item">
                        <button id="btnSearchItem" class="btn search__item--btn" type="button">絞り込み</button>
                    </div>
                </li>
            </ul>
        </form>
    </div>

    <!-- 検索条件リセットボタン -->
    <a href="{{ route('products.index') }}" class="btn">検索条件を元に戻す</a>

    <!-- 商品情報一覧 -->
    <div class="products">
        <h2>商品情報</h2>
        <table id="tableReplace" class="table table-striped">
            <thead>
                <tr>
                    <th>@sortablelink('id', 'I商品ID▼')</th>
                    <th>@sortablelink('product_name', '商品名▼')</th>
                    <th>@sortablelink('company_name', 'メーカー▼')</th>
                    <th>@sortablelink('price', '価格▼')</th>
                    <th>@sortablelink('stock', '在庫数▼')</th>
                    <th>コメント</th>
                    <th>商品画像</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
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
                        <form class="dlt__product" method="POST" action="{{ route('products.destroy', $product->id) }}">
                            @csrf
                            @method('DELETE')
                            <input type="button" class="btn btn__dlt" data-productId="{{ $product->id }}" value="削除">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
