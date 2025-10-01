@extends('layouts.auth')

@section('title', '新規会員登録 | STEP1')
@section('heading', '新規会員登録')
@section('step', 'STEP1 アカウント情報の登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<form action="{{ route('register.step1.store') }}" method="post">
    @csrf

    <div class="form__group @error('name','registerStep1') is-invalid @enderror">
        <label class="form__label" for="name">お名前</label>
        <input class="form__input" type="text" id="name" name="name"
            placeholder="名前を入力" value="{{ old('name') }}">
        @error('name','registerStep1')
        <p class="form__error">{{ $message }}</p>
        @else
        <p class="form__error" aria-hidden="true"></p>
        @enderror
    </div>

    <div class="form__group @error('email','registerStep1') is-invalid @enderror">
        <label class="form__label" for="email">メールアドレス</label>
        <input class="form__input" type="email" id="email" name="email"
            placeholder="例：メールアドレスを入力" value="{{ old('email') }}">
        @error('email','registerStep1')
        <p class="form__error">{{ $message }}</p>
        @else
        <p class="form__error" aria-hidden="true"></p>
        @enderror
    </div>

    <div class="form__group @error('password','registerStep1') is-invalid @enderror">
        <label class="form__label" for="password">パスワード</label>
        <input class="form__input" type="password" id="password" name="password"
            placeholder="パスワードを入力">
        @error('password','registerStep1')
        <p class="form__error">{{ $message }}</p>
        @else
        <p class="form__error" aria-hidden="true"></p>
        @enderror
    </div>

    <button class="btn" type="submit">次に進む</button>
</form>
@endsection

@section('helper')
<a class="auth-link" href="{{ url('/login') }}">ログインはこちら</a>
@endsection