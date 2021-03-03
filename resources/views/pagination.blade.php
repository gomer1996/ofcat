@if ($paginator->lastPage() > 1)
    <div id="further">
        @if($paginator->currentPage() !== 1)
            <a href="{{ $paginator->url(1) }}">Первая</a>
            <a href="{{ $paginator->url($paginator->currentPage()-1) }}">Предыдущая</a>
        @endif
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <a href="{{ $paginator->url($i) }}"
               class="{{ $paginator->currentPage() === $i ? "active" : null }}">{{ $i }}</a>
        @endfor
        @if($paginator->currentPage() !== $paginator->lastPage())
            <a href="{{ $paginator->url($paginator->currentPage()+1) }}" >Следующая</a>
            <a href="{{ $paginator->url($paginator->lastPage()) }}">Последняя</a>
        @endif
    </div>
@endif
