@if ($paginator->lastPage() > 1)
    <div id="further" class="product-pagination">
        @if($paginator->currentPage() !== 1)
            <a wire:click="gotoPage(1)">Первая</a>
            <a wire:click="previousPage">Предыдущая</a>
        @endif
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <a wire:click="gotoPage({{ $i }})"
               class="{{ $paginator->currentPage() === $i ? "active" : null }}">{{ $i }}</a>
        @endfor
        @if($paginator->currentPage() !== $paginator->lastPage())
            <a wire:click="nextPage">Следующая</a>
            <a wire:click="gotoPage({{ $paginator->lastPage() }})">Последняя</a>
        @endif
    </div>
@endif
