<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PiGLy</title>

    {{-- 共通CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- ページ専用CSSは各ビューで @section('css') に積む --}}
    @yield('css')
</head>

<body class="site-body">
    <main class="shell">
        <div class="shell__inner">
            {{-- 共通ヘッダー --}}
            <header class="site-header">
                <a href="{{ route('weight_logs') }}" class="brand" aria-label="PiGLy ホーム">PiGLy</a>

                <nav class="header-actions">
                    <a href="{{ route('goal.edit') }}" class="btn btn--ghost">
                        <span aria-hidden="true">⚙</span> 目標体重設定
                    </a>

                    @auth
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn--ghost" title="ログアウト">
                            {{-- 扉＋右向き矢印（logout）アイコン --}}
                            <svg class="icon icon--logout" viewBox="0 0 24 24" aria-hidden="true">
                                <!-- 扉 -->
                                <rect x="3" y="3" width="10" height="18" rx="2" ry="2"
                                    fill="none" stroke="currentColor" stroke-width="2" />
                                <!-- 退出矢印 -->
                                <path d="M15 8l4 4-4 4M19 12H9"
                                    fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            ログアウト
                        </button>
                    </form>
                    @endauth


                </nav>
            </header>

            {{-- ページ本体 --}}
            <section class="site-content">
                @yield('content')
            </section>
        </div>
    </main>

    @yield('scripts')
</body>

</html>