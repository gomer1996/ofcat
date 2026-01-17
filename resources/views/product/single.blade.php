<x-app-layout>
    @section('title', $product->name)
    <div id="hornav">
        <div class="field">
            <table>
                <tr>
                    <td>
                        <a href="/">Главная</a>
                    </td>
                    <td>
                        <p>/</p>
                    </td>
                    <td>
                        <a href="{{ route('categories.all') }}">Каталог</a>
                    </td>
                    <td>
                        <p>/</p>
                    </td>
                    @foreach($breadcrumbs as $cat)
                        @if($cat)
                            <td>
                                <a href="{{ route('categories.index', $cat) }}">{{ $cat->name }}</a>
                            </td>
                            @if(!$loop->last)
                                <td>
                                    <p>/</p>
                                </td>
                            @endif
                        @endif
                    @endforeach
                </tr>
            </table>
        </div>
    </div>
    <div class="field"  id="product">
        <table>
            <tr>
                <td class="slid" style="width: 700px">
                    <div class="slidercontainer">
                        @if($product->getMedia('product_media_collection')->first())
                            <!-- крупное изображение -->
                            <div class="img">
                                <a href="{{ $product->getMedia('product_media_collection')->first()->getFullUrl() }}"  id="bigimage" data-fancybox="gallery-{{ $product->id }}">
                                    <img src="{{ $product->getMedia('product_media_collection')->first()->getFullUrl() }}" id="bigimageimg" alt="" />
                                </a>
                            </div>
                        @endif
                        <!-- Миниатюры -->
                        <div class="thumbs">
                            @foreach($product->getMedia('product_media_collection') as $media)
                            <!-- Миниатюра 1 -->
                            <div class="thumb">
                                <a href="{{ $media->getFullUrl() }}" data-fancybox="gallery-{{ $product->id }}">
                                    {{ $media }}
                                    <div class="overlayit"></div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </td>
                <td>
                    <table class="articl">
                        <tr>
                            <td class="articl_left" colspan="2">
                                <ul>
                                    <li>
                                        <p>Код <span>{{ $product->code }}</span></p>
                                    </li>
                                    <li style="margin-left: 50px">
                                        <p>{{ $product->stock > 0 ? $product->stock . ' шт. в наличии' : 'Под заказ' }}</p>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td id="articl_heig" colspan="2">
                                <h1>{{ $product->name }}</h1>
                            </td>
                        </tr>
                        <livewire:product-inner-cart :product="$product" />
                        <tr>
                            <td class="prod_info">
                                <img src="images/auxiliary_2.png" alt="" />
                            </td>
                            <td class="prod_info">
                                <p>Доставка по Новосибирску бесплатная при сумме заказа от 3000 руб.</p>
                                <p>300 руб. — при заказе до 3000 руб.</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="prod_info prod_kor">
                                <img src="images/auxiliary_3.png" alt="" />
                            </td>
                            <td class="prod_info">
                                <p>Самовывоз со склада в г.Новосибирск по адресу : ул. генерала Акулова, 136</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="cleaner"></div>
    <div class="specific_cont">
        <div class="field">
            <div  class="specific_nav">
                <ul>
                    <li>
                        <a href="#" class="product_tabs" id="product_info">
                            <span>О товаре</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="product_tabs" id="product_props">
                            <span>Расширенные характеристики</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="product_tabs" id="product_delivery">
                            <span>Оплата и доставка</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="cleaner"></div>
    <div class="field">
        <div class="specific_tov">
            <table>
                <tr id="product_info_tab">
                    <td>
                        <p>{{ $product->description }}</p>
                    </td>
                    <td>
                        <ul>
                            <li>
                                <p>Бренд: {{ $product->brand }}</p>
                            </li>
                            <li>
                                <p>Производитель: {{ $product->manufacturer }}</p>
                            </li>
                            <li>
                                <p>Вес: {{ $product->weight }}</p>
                            </li>
                            <li>
                                <p>Объем: {{ $product->volume }}</p>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr id="product_props_tab" style="display: none">
                    <td>
                        <table>
                            @if(count($product->properties_parsed))
                                <td>
                                    <ul>
                                        @foreach($product->properties_parsed as $key => $val)
                                            <li>
                                                <p>{{ $key }}: {{ $val }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            @endif
                        </table>
                    </td>
                </tr>
                <tr id="product_delivery_tab" style="display: none">
                    <td>
                        <p>{{ $delivery_text }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <x-similar-products />

    <div class="cleaner"></div>
    <div class="otstyp">
    </div>
    <script>
        const tabs = ['product_info', 'product_props', 'product_delivery'];

        $('.product_tabs').click(function(event){
            event.preventDefault();

            const selectedTabId = $(this).attr('id');
            tabs.forEach(tab => {
                console.log('->', `${tab}_tab`);
                if (tab !== selectedTabId) $(`#${tab}_tab`).css('display', 'none');
            });
            $(`#${selectedTabId}_tab`).css('display', 'block');
        });


    </script>
</x-app-layout>
