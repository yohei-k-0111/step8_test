@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品新規登録</h1>

@if (session('crt_message'))
    <div class="alert alert__success">
        {{ session('crt_message') }}
    </div>
@endif

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="crt-item">
            <label id="lblProductName" for="productName" class="crt-item__label">商品名:</label>
            <input id="txtProductName" type="text" name="product_name" class="crt-item__form" required>
        </div>

        <div class="crt-item">
            <label id="lblCompanyId" for="companyId" class="crt-item__label">メーカー:</label>
            <select id="drpCompanyId" class="crt-item__form" name="company_id">
            <option value="">メーカー選択</option>
           @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="crt-item">
            <label id="lblPrice" for="price" class="crt-item__label">価格:</label>
            <input id="numPrice" type="text"pattern="^[0-9A-Za-z]+$" name="price" class="crt-item__form" required>
        </div>

        <div class="crt-item">
            <label id="lblStock" for="stock" class="crt-item__label">在庫数:</label>
            <input id="numStock" type="text" pattern="^[0-9A-Za-z]+$" name="stock" class="crt-item__form" required>
        </div>

        <div class="crt-item">
            <label id="lblComment" for="comment" class="crt-item__label">コメント:</label>
            <textarea id="areaComment" name="comment" class="crt-item__form" rows="3"></textarea>
        </div>

        <div class="crt-item">
            <label id="lblImgPath" for="imgPath" class="crt-item__label">商品画像:</label>
            <input id="fileImgPath" type="file" name="img_path" class="crt-item__form">
        </div>
        <button id="btnCrtProduct" type="submit" class="btn">登録</button>
    </form>
    <div class="return">
        <a href="{{ route('products.index') }}" class="btn">戻る</a>
    </div>
</div>
@endsection
