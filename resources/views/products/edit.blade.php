@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header"><h2>商品情報を変更する</h2></div>

@if (session('edt_message'))
    <div class="alert alert__info">
        {{ session('edt_message') }}
    </div>
@endif

            <div class="card-body">
                <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    <div class="edit-item">
                        <p>商品情報ID</p>
                        <p>{{ $product->id }}</p>
                    </div>

                    <div class="edit-item">
                        <label id="lblProductName" for="productName" class="edit-item__label">商品名</label>
                        <input id="txtProductName" type="text" class="edit-item__form" name="product_name"
                        value="{{ $product->product_name }}" required>
                    </div>

                    <div class="edit-item">
                        <label id="lblCompanyId" for="companyId" class="edit-item__label">メーカー</label>
                        <select id="drpCompanyId" class="edit-item__form" name="company_id">
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ $product->company_id == $company->id ?
                                    'selected' : '' }}>{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="edit-item">
                        <label id="lblPrice" for="price" class="edit-item__label">金額</label>
                        <input id="numPrice" type="number" class="edit-item__form" name="price"
                        value="{{ $product->price }}" required>
                    </div>

                    <div class="edit-item">
                        <label id="lblStock" for="stock" class="edit-item__label">在庫数</label>
                        <input id="numStock" type="number" class="edit-item__form" name="stock"
                        value="{{ $product->stock }}" required>
                    </div>

                    <div class="edit-item">
                        <label id="lblComment" id="commentLabel" class="edit-item__label">コメント</label>
                        <textarea id="areaComment" name="comment" class="edit-item__form" rows="3">{{
                             $product->comment }}</textarea>
                    </div>

                    <div class="edit-item">
                        <label id="lblImgPath" or="imgPath" class="edit-item__label">商品画像:</label>
                        <input id="fileImgPath" type="file" name="img_path" class="edit-item__form">
                        <img src="{{ asset($product->img_path) }}" alt="商品画像" class="product-img">
                    </div>

                    <button id="btnEdtProduct" type="submit" class="btn">変更内容で更新する</button>
                </form>
            </div>
        </div>
        <div class="return">
            <a href="{{ route('products.show', $product) }}" class="btn">戻る</a>
        </div>
    </div>
@endsection
