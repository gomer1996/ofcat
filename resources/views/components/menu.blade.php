<nav>
    <ul id="maintop_menu">
        <li class="catalog_menu">
            <a class="catalog_menu_link" href="#">
                <span><span class="icon_menu"></span>ВЕСЬ КАТАЛОГ</span>
            </a>
            <div class="catalog_menu_dropdown">
                <div class="dropdown_wrapper">
                    <ul class="catalog_menu_list">
                        {{--            todo provide links            --}}
                        @foreach($categories as $category)
                            <li class="catalog_menu_item">
                                <a href="{{ route('categories.index', $category) }}" class="catalog_menu_item_link">{{ $category->name }}</a>
                                @if($category->children->count())
                                    <ul class="catalog_menu_list catalog_menu_list_sub">
                                        @foreach($category->children as $child)
                                            <li class="catalog_menu_item">
                                                <a href="{{ route('categories.index', $child) }}" class="catalog_menu_item_link">
                                                    {{ $child->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </li>
        <li>
            <a href="{{ route('discounts.index') }}">
                <span>АКЦИИ</span>
            </a>
        </li>
        <li>
            <a href="{{ route('products.new') }}">
                <span>НОВИНКИ</span>
            </a>
        </li>
        <li>
            <a href="{{ route('products.bestsellers') }}">
                <span>ХИТЫ ПРОДАЖ</span>
            </a>
        </li>
    </ul>
</nav>

