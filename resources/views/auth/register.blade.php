@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <h2 class="card__header">新規ユーザー登録</h2>

        <div class="card__body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="regist-item">
                    <label id="lblName" for="name" class="regist-item__label">名前</label>

                    <div class="regist-item__form">
                        <input id="txtName" type="text" class="form regist-item__form--input @error('name') is-invalid
                         @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="regist-item">
                    <label id="lblEmail" for="email" class="regist-item__label">メールアドレス</label>

                    <div class="regist-item__form">
                        <input id="txtEmail" type="email" class="form regist-item__form--input @error('email')
                         is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"
                           pattern="^[a-zA-Z0-9_+-]+(.[a-zA-Z0-9_+-]+)*@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)
                           +[a-zA-Z]{2,}$" >
                        @error('email')
                            <span role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="regist-item">
                    <label id="lblPassword" for="password" class="regist-item__label">パスワード</label>
                    <div class="regist-item__form">
                        <input id="txtPassword" type="password" class="form regist-item__form--input @error('password')
                         is-invalid @enderror" name="password" required autocomplete="new-password"
                         pattern="^[0-9A-Za-z]+$">
                        @error('password')
                            <span role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="regist-item">
                    <label id="lblPasswordConfirm" for="passwordConfirm" class="regist-item__label">パスワード確認</label>
                    <div class="regist-item__form">
                        <input id="txtPasswordConfirm" type="password" class="form regist-item__form--input"
                        name="password_confirmation" required autocomplete="new-password" pattern="^[0-9A-Za-z]+$">
                    </div>
                </div>
                <div id="btnRegistEnter" class="regist-item">
                    <button type="submit" class="btn">登録する</button>
                </div>
            </form>
        </div>
        <div class="return">
            <a href="{{ url('/') }}" class="btn">戻る</a>
        </div>
    </div>
</div>
@endsection
