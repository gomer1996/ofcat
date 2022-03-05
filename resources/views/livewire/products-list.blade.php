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
                            <a href="#" wire:click.prevent="changeView('line')">
                                <img src="/images/Каталог-развернутый-список_05.png" alt="Построчно" />
                            </a>
                            <a class="disp_typelast" href="#" wire:click.prevent="changeView('block')">
                                <img src="/images/Каталог-развернутый-список_07.png" alt="Блочно" />
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="blokleft myfilter">
            <div class="myfilter_inner">
                <ul>
                    @if(count($brands))
                        <li class="myfilter_inner_title">Бренд:</li>
                        @foreach($brands as $brand)
                            <li>
                                <label>
                                    <input type="checkbox"
                                           value="{{ $brand }}"
                                           wire:model="selectedBrands" />
                                    {{ ucfirst($brand) }}
                                </label>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <ul>
                    <li class="myfilter_inner_title">Цены:</li>
                    <li>
                        <input type="text"
                               class="myfilter_inner_price_inputs"
                               wire:model.debounce.1000ms="priceFrom"
                               placeholder="от" />
                        <input type="text"
                               class="myfilter_inner_price_inputs"
                               wire:model.debounce.1000ms="priceTo"
                               placeholder="до" style="float: right" />
                    </li>
                </ul>
{{--                <button class="myfilter_inner_show">Показать</button>--}}
            </div>
        </div>
        <div class="tovcontent">
            @if($products->count())
                <table>
                    @foreach($products->chunk($chunkCount) as $chunk)
                        <tr>
                            @foreach($chunk as $product)
                                <livewire:product-intro
                                    :viewType="$viewType"
                                    :product="$product"
                                    :key="time().$product->id"
                                    :linkedCategory="$linkedCategory"
                                />
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
            @else
                <div style="text-align: center; margin-top: 100px">
                    Здесь пока товаров нет...
                </div>
            @endif

            {{ $products->links('livewire.pagination') }}

        </div>
    </div>
</div>
