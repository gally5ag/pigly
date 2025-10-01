@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/weight_logs.css') }}">
@endsection

@section('link')
<a class="header__link" href="{{ route('goal.edit') }}">目標体重</a>
<form action="{{ route('logout') }}" method="post" style="display:inline">
    @csrf
    <input class="header__link" type="submit" value="ログアウト">
</form>
@endsection

@section('content')
<div class="form-page">
    <h2 class="content__heading">Weight Log</h2>

    {{-- 更新フォーム（詳細画面をそのまま編集可能に） --}}
    <form action="{{ route('weight_logs.update', $log->id) }}" method="post" class="edit-form" novalidate>
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>日付 <span class="req">必須</span></label>
            <input type="date" name="date"
                value="{{ old('date', \Carbon\Carbon::parse($log->date)->toDateString()) }}">
            <p class="error">@error('date'){{ $message }}@enderror</p>
        </div>

        <div class="form-group">
            <label>体重 <span class="req">必須</span></label>
            <div class="with-unit">
                <input type="text" name="weight" value="{{ old('weight', $log->weight) }}" placeholder="例：53.5">
                <span>kg</span>
            </div>
            @if($errors->has('weight'))
            @foreach($errors->get('weight') as $msg)
            <p class="error">{{ $msg }}</p>
            @endforeach
            @endif
        </div>

        <div class="form-group">
            <label>摂取カロリー <span class="req">必須</span></label>
            <div class="with-unit">
                <input type="number" name="calories" value="{{ old('calories', $log->calories) }}" inputmode="numeric" placeholder="例：1200">
                <span>cal</span>
            </div>
            <p class="error">@error('calories'){{ $message }}@enderror</p>
        </div>

        <div class="form-group">
            <label>運動時間 <span class="req">必須</span></label>
            <input type="time" name="exercise_time"
                value="{{ old('exercise_time', $log->exercise_time ? substr($log->exercise_time,0,5) : '') }}"
                placeholder="00:00">
            <p class="error">@error('exercise_time'){{ $message }}@enderror</p>
        </div>

        <div class="form-group">
            <label>運動内容</label>
            <input type="text" name="exercise_content" value="{{ old('exercise_content', $log->exercise_content) }}" placeholder="例：ウォーキング30分">
            <p class="error">@error('exercise_content'){{ $message }}@enderror</p>
        </div>

        {{-- ボタン行（左：戻る/更新、右：削除） --}}
        <div class="actions-row">
            <div class="actions-row__left">
                <a href="{{ route('weight_logs') }}" class="btn btn--gray">戻る</a>

                <form action="{{ route('weight_logs.update', $log->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn--primary">更新</button>
                </form>
            </div>

            <form class="actions-row__right"
                action="{{ route('weight_logs.delete', $log->id) }}"
                method="post"
                onsubmit="return confirm('この記録を削除します。よろしいですか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn icon-btn" aria-label="この記録を削除">
                    {{-- シンプルなゴミ箱アイコン（SVG） --}}
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M9 3h6a1 1 0 0 1 1 1v1h4v2h-1v12a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3V7H4V5h4V4a1 1 0 0 1 1-1Zm1 2v0h4V5h-4Zm-3 2v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V7H7Zm3 3h2v7H10v-7Zm4 0h2v7h-2v-7Z" />
                    </svg>
                    <span class="sr-only">削除</span>
                </button>
            </form>
        </div>
    </form>
</div>
@endsection