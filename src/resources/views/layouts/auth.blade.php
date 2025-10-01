{{-- resources/views/layouts/auth.blade.php --}}
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'PiGLy')</title>

    {{-- 共通の認証用スタイル --}}
    <link rel="stylesheet" href="{{ asset('css/auth/base.css') }}">
    @yield('css')
</head>

<body class="auth-body">
    

    <main class="auth-main">
        <section class="auth-card">
            {{-- カード上部：ブランド／ページタイトル／ステップ --}}
            <div class="auth-card__head">
                <div class="auth-brand">PiGLy</div>
                @hasSection('heading')
                <h2 class="auth-title">@yield('heading')</h2>
                @endif
                @hasSection('step')
                <p class="auth-step">@yield('step')</p>
                @endif
            </div>

            {{-- ページ固有の内容（フォームなど） --}}
            <div class="auth-card__body">
                @yield('content')
            </div>

            @hasSection('helper')
            <div class="auth-card__helper">
                @yield('helper')
            </div>
            @endif
        </section>
    </main>
</body>

</html>