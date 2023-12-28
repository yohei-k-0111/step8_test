@extends('layouts.app')

@section('content')
<div class="container">
    <h1 id="showTitle">商品情報詳細</h1>
        <dl class="show-list">
            <dt class="show-list__label">商品情報ID</dt>
            <dd class="show-list__info">{{ $product->id }}</dd>

            <dt class="show-list__label">商品名</dt>
            <dd class="show-list__info">{{ $product->product_name }}</dd>

            <dt class="show-list__label">メーカー</dt>
            <dd class="show-list__info">{{ $product->company->company_name }}</dd>

            <dt class="show-list__label">価格</dt>
            <dd class="show-list__info">{{ $product->price }}</dd>

            <dt class="show-list__label">在庫数</dt>
            <dd class="show-list__info">{{ $product->stock }}</dd>

            <dt class="show-list__label">コメント</dt>
            <dd class="show-list__info">{{ $product->comment }}</dd>

            <dt class="show-list__label">商品画像</dt>
            <dd class="show-list__info"><img class="product-img" src="{{ asset($product->img_path) }}"></dd>
        </dl>
    <a href="{{ route('products.edit', $product) }}" class="btn btn__product-edit">商品情報を編集する</a>
    <div class="return">
        <a href="{{ route('products.index') }}" class="btn">戻る</a>
    </div>
</div>
@endsection
