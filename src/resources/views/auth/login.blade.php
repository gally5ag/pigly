@extends('layouts.auth')


@section('heading', 'ログイン')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
<style>
    .form__error {
        color: #d00;
        font-size: .9rem;
        margin-top: .25rem;
    }
</style>
@endsection



@section('content')
{{-- Fortify の /login に POST --}}
<form action="{{ url('/login') }}" method="post" novalidate>
    @csrf

    <div class="form__group">
        <label class="form__label" for="email">メールアドレス</label>
        <input class="form__input" type="email" name="email" id="email"
            placeholder="メールアドレスを入力" value="{{ old('email') }}">
        <p class="form__error">@error('email') {{ $message }} @enderror</p>
    </div>

    <div class="form__group">
        <label class="form__label" for="password">パスワード</label>
        <input class="form__input" type="password" name="password" id="password"
            placeholder="パスワードを入力">
        <p class="form__error">@error('password') {{ $message }} @enderror</p>
    </div>

    <button class="btn" type="submit">ログイン</button>
</form>
@endsection

@section('helper')
<a class="auth-link" href="{{ route('register.step1.create') }}">アカウント作成はこちら</a>
@endsection