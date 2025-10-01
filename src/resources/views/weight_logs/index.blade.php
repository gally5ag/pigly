@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/weight_logs.css') }}">
@endsection



@section('content')
<div class="weight-log">

    {{-- 上部情報 --}}
    <div class="summary">
        <div class="summary__item">
            <p class="summary__label">目標体重</p>
            <p class="summary__value">
                {{ $weightTarget ? number_format($weightTarget->target_weight, 1) : '-' }}
                <span class="summary__unit">kg</span>
            </p>
        </div>
        <div class="summary__item">
            <p class="summary__label">目標まで</p>
            <p class="summary__value">
                {{ !is_null($diff) ? number_format($diff, 1) : '-' }}
                <span class="summary__unit">kg</span>
            </p>
        </div>
        <div class="summary__item">
            <p class="summary__label">最新体重</p>
            <p class="summary__value">
                {{ !is_null($currentWeight) ? number_format($currentWeight, 1) : '-' }}
                <span class="summary__unit">kg</span>
            </p>
        </div>


        {{-- ここからモーダル --}}
        <div class="modal" id="create">
            <a href="#!" class="modal__overlay" aria-label="閉じる"></a>
            <div class="modal__inner">
                <div class="modal__content">
                    <h3>体重登録</h3>

                    <form action="{{ route('weight_logs.store') }}" method="post" class="create-form" novalidate>
                        @csrf
                        <input type="hidden" name="open_modal" value="1"> {{-- バリデ失敗時にモーダル再表示用 --}}

                        <div class="form-group">
                            <label>日付 <span class="req">必須</span></label>
                            <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}">
                            <p class="error">@error('date'){{ $message }}@enderror</p>
                        </div>

                        <div class="form-group">
                            <label>体重 <span class="req">必須</span></label>
                            <div class="with-unit">
                                <input type="text" name="weight" value="{{ old('weight') }}" placeholder="例：50.0">
                                <span>kg</span>
                            </div>
                            {{-- 体重の複数メッセージ（numeric/4桁/小数1桁）を全部表示 --}}
                            @if($errors->has('weight'))
                            @foreach($errors->get('weight') as $msg)
                            <p class="error">{{ $msg }}</p>
                            @endforeach
                            @endif
                        </div>

                        <div class="form-group">
                            <label>摂取カロリー <span class="req">必須</span></label>
                            <div class="with-unit">
                                <input type="number" name="calories" value="{{ old('calories') }}" inputmode="numeric" placeholder="例：1200">
                                <span>cal</span>
                            </div>
                            <p class="error">@error('calories'){{ $message }}@enderror</p>
                        </div>

                        <div class="form-group">
                            <label>運動時間 <span class="req">必須</span></label>
                            <input type="time" name="exercise_time" value="{{ old('exercise_time') }}" help="00:00">
                            <p class="error">@error('exercise_time'){{ $message }}@enderror</p>
                        </div>

                        <div class="form-group">
                            <label>運動内容</label>
                            <textarea name="exercise_content"
                                rows="5"
                                maxlength="120"
                                placeholder="運動内容を追加">{{ old('exercise_content') }}</textarea>
                            <p class="error">@error('exercise_content'){{ $message }}@enderror</p>
                        </div>

                        <div class="form-actions">
                            <a href="#!" class="btn btn--gray">戻る</a>
                            <button type="submit" class="btn btn--primary">登録</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- バリデ失敗時にモーダルを自動で開く--}}
        @if($errors->any() || old('open_modal'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (location.hash !== '#create') location.hash = '#create';
            });
        </script>
        @endif

    </div>

    {{-- 検索フォーム --}}
    <form class="search-form" action="{{ route('weight_logs.search') }}" method="get">
        <input type="date" name="from_date" value="{{ $from_date ?? '' }}">
        <span class="tilde">〜</span>
        <input type="date" name="to_date" value="{{ $to_date ?? '' }}">
        <button type="submit" class="btn btn--primary">検索</button>
        @if(!empty($from_date) || !empty($to_date))
        <a href="{{ route('weight_logs') }}" class="btn btn--gray reset-btn">リセット</a>
        @endif
    </form>

    {{-- 検索結果ラベル --}}
    @if(!empty($resultLabel))
    <p class="result-label">{{ $resultLabel }}</p>
    @endif
    <div class="summary__actions">

        <a class="btn btn--primary" href="#create">データを追加</a>
    </div>

    {{-- 一覧ヘッダー（上部固定表示） --}}
    <div class="logs-head" aria-hidden="false">
        <div class="th">日付</div>
        <div class="th">体重</div>
        <div class="th">食事摂取カロリー</div>
        <div class="th">運動時間</div>
        <div class="th th--icon"></div>
    </div>

    {{-- データ一覧（8件/ページ） --}}
    <div class="logs">
        @forelse($logs as $log)
        <div class="log-card" title="詳細">
            <div class="log-card__main">
                <div class="log-card__row"><span>日付</span><b>{{ \Carbon\Carbon::parse($log->date)->format('Y/m/d') }}</b></div>
                <div class="log-card__row"><span>体重</span><b>{{ number_format($log->weight,1) }}kg</b></div>
                <div class="log-card__row"><span>摂取カロリー</span><b>{{ number_format($log->calories) }}cal</b></div>
                <div class="log-card__row"><span>運動時間</span><b>{{ substr($log->exercise_time,0,5) }}</b></div>
                
            </div>
            <a class="edit-btn" href="{{ route('weight_logs.show', $log->id) }}" aria-label="詳細">
                <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
                    <defs>
                        <linearGradient id="iconGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#b388ff" />
                            <stop offset="100%" stop-color="#ff8acb" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#iconGrad)"
                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41L18.37 3.29a.9959.9959 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                </svg>
            </a>

        </div>
        @empty
        <p class="empty">データがありません</p>
        @endforelse
        @if($logs->hasPages())
        <div class="pagination">
            {{ $logs->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.custom') }}
        </div>
        @endif
    </div>




</div>


@endsection