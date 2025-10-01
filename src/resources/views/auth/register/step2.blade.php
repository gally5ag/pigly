@extends('layouts.auth')

@section('title', '新規会員登録 | STEP2')
@section('heading', '新規会員登録')
@section('step', 'STEP2 体重のデータ入力')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<form method="POST" action="{{ route('register.step2.store') }}">
    @csrf

    {{-- 現在の体重 --}}
    <div class="form__group @error('current_weight','registerStep2') is-invalid @enderror">
        <label class="form__label" for="current_weight">現在の体重</label>
        <div class="input-with-suffix">
            <input
                class="form__input"
                type="text"
                name="current_weight"
                id="current_weight"
                placeholder="現在の体重を入力"
                value="{{ old('current_weight') }}"
                inputmode="decimal"
               >
            <span class="input-suffix" aria-hidden="true">kg</span>
        </div>
        @error('current_weight','registerStep2')
        <p id="current_weight_error" class="form__error">{{ $message }}</p>
        @else
        <p id="current_weight_error" class="form__error" aria-hidden="true"></p>
        @enderror

    </div>

    {{-- 目標の体重 --}}
    <div class="form__group @error('target_weight','registerStep2') is-invalid @enderror">
        <label class="form__label" for="target_weight">目標の体重（kg）</label>
        <div class="input-with-suffix">
            <input
                class="form__input"
                type="text"
                name="target_weight"
                id="target_weight"
                placeholder="目標の体重を入力"
                value="{{ old('target_weight') }}"
                inputmode="decimal">
            <span class="input-suffix" aria-hidden="true">kg</span>
        </div>
        @error('target_weight','registerStep2')
        <p id="target_weight_error" class="form__error">{{ $message }}</p>
        @else
        <p id="target_weight_error" class="form__error" aria-hidden="true"></p>
        @enderror
    </div>

    <button class="btn" type="submit">アカウント作成</button>
</form>
@endsection