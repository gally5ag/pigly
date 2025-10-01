@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/weight_logs.css') }}">
@endsection

@section('link')
<a class="header__link" href="{{ route('weight_logs') }}">体重管理</a>
<form action="{{ route('logout') }}" method="post" style="display:inline">
    @csrf
    <input class="header__link" type="submit" value="ログアウト">
</form>
@endsection

@section('content')
<div class="form-page">
    <h2 class="content__heading">目標体重の変更</h2>

    <form action="{{ route('goal.update') }}" method="post" class="edit-form" novalidate>
        @csrf

        <div class="form-group">
            <label>目標体重 <span class="req">必須</span></label>
            <div class="with-unit">
                <input type="text" name="target_weight"
                    value="{{ old('target_weight', $target ? number_format($target->target_weight, 1) : '') }}"
                    placeholder="例：60.0">
                <span>kg</span>
            </div>
            @error('target_weight')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-actions" style="display:flex; gap:10px; justify-content:flex-end; flex-wrap:wrap;">
            <a href="{{ route('weight_logs') }}" class="btn btn--gray">戻る</a>
            <button type="submit" class="btn btn--primary">更新</button>
        </div>
    </form>
</div>
@endsection