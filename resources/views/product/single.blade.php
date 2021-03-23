<x-app-layout>
    @section('title', $product->name)
    <div id="hornav">
        <div class="field">
            <table>
                <tr>
                    <td>
                        <a href="#">Главная</a>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <a href="#">Каталог</a>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <a href="{{ route('categories.index', $product->category) }}">{{ $product->category->name }}</a>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <a href="#">{{ $product->name }}</a>
                    </td>
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
                                <a href="{{ $product->getMedia('product_media_collection')->first()->getFullUrl() }}"  id="bigimage" class='fresco' data-fresco-group='example'>
                                    <img src="{{ $product->getMedia('product_media_collection')->first()->getFullUrl() }}" id="bigimageimg" alt="" />
                                </a>
                            </div>
                        @endif
                        <!-- Миниатюры -->
                        <div class="thumbs">
                            @foreach($product->getMedia('product_media_collection') as $media)
                            <!-- Миниатюра 1 -->
                            <div class="thumb">
                                <a href="{{ $media->getFullUrl() }}" class='sliderpr fresco' data-fresco-group='example'>
                                    {{ $media }}
                                    <div class="overlayit"></div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <script type="text/javascript" src="/assets/js/jquery.browser.min.js"></script>
                    <script type="text/javascript" src="/assets/js/fresco.js"></script>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('.sliderpr').click(function(e){					/*------ 			Обрабатываем событие "Клик по элементу" 				------*/
                                e.preventDefault();								/*------ 			Запрещаем запуск стандартного обработчика 				------*/
                                var source = $(this).find('img').attr('src');	/*------ 			Берем изображение из аттрибута alt 					------*/
                                $("#bigimage").attr('href',source);				/*------ 			Записываем изображение в большую картинку 				------*/
                                $("#bigimageimg").attr('src',source);			/*------ 			Записываем изображение в ссылку на большую картинку 	------*/
                                return false;									/*------ 			Возвращаем false 										------*/
                            });
                        });
                    </script>
                </td>
                <td>
                    <table class="articl">
                        <tr>
                            <td class="articl_left" colspan="2">
                                <ul>
                                    <li>
                                        <p>Код <span>{{ $product->code }}</span></p>
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
                        <a href="#">
                            <span>О товаре</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Расширенные характеристики</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
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
                <tr>
                    <td>
                        <p>{{ $product->info }}</p>
                    </td>
                    <td>
                        <ul>
                            <li>
                                <p>Цвет: черный</p>
                            </li>
                            <li>
                                <p>Высота доски: 60 см</p>
                            </li>
                            <li>
                                <p>Ширина доски: 90 см</p>
                            </li>
                            <li>
                                <p>Магнитная поверхность: да</p>
                            </li>
                            <li>
                                <p>Тип покрытия доски: маркерное</p>
                            </li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <x-similar-products />

    <div class="cleaner"></div>
    <div class="otstyp">
    </div>
</x-app-layout>
