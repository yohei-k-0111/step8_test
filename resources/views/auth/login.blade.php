@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <h2 class="card__header">ログイン情報を入力してください</h2>

        <div class="card__body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="login-item">
                    <label id="lblEmail" for="email" class="login-item__label">メールアドレス</label>
                    <div class="login-item__form">
                        <input id="txtEmail" type="email" class="form login-item__form--input @error('email')
                         is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"
                         autofocus pattern="^[a-zA-Z0-9_+-]+(.[a-zA-Z0-9_+-]+)*@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)
                         +[a-zA-Z]{2,}$" >
                        @error('email')
                            <span role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="login-item">
                    <label id="lblPassword" for="password" class="login-item__label">パスワード</label>
                    <div class="login-item__form">
                        <input id="txtPassword" type="password" class="form login-item__form--input @error('password')
                         is-invalid @enderror" name="password" required autocomplete="current-password"
                         pattern="^[0-9A-Za-z]+$">
                        @error('password')
                            <span role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="login-item">
                    <button id="btnLoginEnter" type="submit" class="btn">ログイン</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
