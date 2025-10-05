{{-- resources/views/vendor/pagination/custom.blade.php --}}
@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination" class="pg">
    <ul class="pg__list" role="list">
        {{-- Prev --}}
        @if ($paginator->onFirstPage())
        <li class="pg__item pg__arrow is-disabled" aria-hidden="true"><span>&lt;</span></li>
        @else
        <li class="pg__item pg__arrow">
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="前のページ">&lt;</a>
        </li>
        @endif

        {{-- Numbers / Dots --}}
        @foreach ($elements as $element)
        @if (is_string($element))
        <li class="pg__item pg__dots"><span>{{ $element }}</span></li>
        @endif

        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="pg__item">
            <span class="pg__num is-active" aria-current="page">{{ $page }}</span>
        </li>
        @else
        <li class="pg__item">
            <a class="pg__num" href="{{ $url }}" aria-label="ページ {{ $page }}">{{ $page }}</a>
        </li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
        <li class="pg__item pg__arrow">
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="次のページ">&gt;</a>
        </li>
        @else
        <li class="pg__item pg__arrow is-disabled" aria-hidden="true"><span>&gt;</span></li>
        @endif
    </ul>
</nav>
@endif