<?php
// config
$link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
?>

@if ($paginator->lastPage() > 1)
    <div id="further" class="product-pagination">
        @if($paginator->currentPage() !== 1)
            <a wire:click="gotoPage(1)">Первая</a>
            <a wire:click="previousPage">Предыдущая</a>
        @endif
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <?php
                $half_total_links = floor($link_limit / 2);
                $from = $paginator->currentPage() - $half_total_links;
                $to = $paginator->currentPage() + $half_total_links;
                if ($paginator->currentPage() < $half_total_links) {
                    $to += $half_total_links - $paginator->currentPage();
                }
                if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                }
                ?>
            @if ($from < $i && $i < $to)
                <a wire:click="gotoPage({{ $i }})"
                   class="{{ $paginator->currentPage() === $i ? "active" : null }}">{{ $i }}</a>
            @endif
        @endfor
        @if($paginator->currentPage() !== $paginator->lastPage())
            <a wire:click="nextPage">Следующая</a>
            <a wire:click="gotoPage({{ $paginator->lastPage() }})">Последняя</a>
        @endif
    </div>
@endif
