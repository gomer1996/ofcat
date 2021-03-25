<div id="productgroup" class="field">
    <div class="subproductgroup">
        <h1>{{ $title }}</h1>
        <div class="pagination">
            <table>
                <tr>
                    <td class="pagwidth_1">
                    </td>
                    <td class="pagincolor_l">
                        <div>
                            <label>Сортировать: </label>
                            <select class="product_select" id="selectpag"  wire:change.prevent="sort($event.target.value)">
                                <option value="price_asc">По цене (сначала дешевле)</option>
                                <option value="price_desc">По цене (сначала дороже)</option>
                                <option value="name_asc">По названию (от А до Я)</option>
                                <option value="name_desc">По названию (от Я до А)</option>
                            </select>
                        </div>
                    </td>
                    <td class="pagincolor_r pagwidth_2">
                        <div class="disp_type">
                            <p>Вид: </p>
                            <a href="#">
                                <img src="images/Каталог-развернутый-список_05.png" alt="Построчно" />
                            </a>
                            <a class="disp_typelast" href="#">
                                <img src="images/Каталог-развернутый-список_07.png" alt="Блочно" />
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="blokleft myfilter">
            <p>ФИЛЬТР</p>
        </div>
        <div class="tovcontent">
            <table>
                @foreach($products->chunk(3) as $chunk)
                    <tr>
                        @foreach($chunk as $product)
                            <livewire:product-intro :product="$product" :key="$product->id" />
                        @endforeach
                    </tr>
                    @if(!$loop->last)
                        <tr>
                            <td class="elevation" colspan="3">
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>

            {{ $products->links('livewire.pagination') }}

        </div>
    </div>
</div>
