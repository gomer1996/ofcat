<?php
// config
$link_limit = 4; // maximum number of links (a little bit inaccurate, but will be ok for now)
?>

@if ($paginator->lastPage() > 1)
    <ul class="pagination">
        <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{ $paginator->url(1) }}">First</a>
        </li>
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
                <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endif
        @endfor
        <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            <a href="{{ $paginator->url($paginator->lastPage()) }}">Last</a>
        </li>
    </ul>
@endif


{{--@if ($paginator->lastPage() > 1)--}}
{{--    <div id="further">--}}
{{--        @if($paginator->currentPage() !== 1)--}}
{{--            <a href="{{ $paginator->url(1) }}">Первая</a>--}}
{{--            <a href="{{ $paginator->url($paginator->currentPage()-1) }}">Предыдущая</a>--}}
{{--        @endif--}}
{{--        @for ($i = 1; $i <= $paginator->lastPage(); $i++)--}}
{{--            <a href="{{ $paginator->url($i) }}"--}}
{{--               class="{{ $paginator->currentPage() === $i ? "active" : null }}">{{ $i }}</a>--}}
{{--        @endfor--}}
{{--        @if($paginator->currentPage() !== $paginator->lastPage())--}}
{{--            <a href="{{ $paginator->url($paginator->currentPage()+1) }}" >Следующая</a>--}}
{{--            <a href="{{ $paginator->url($paginator->lastPage()) }}">Последняя</a>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--@endif--}}
