<x-app-layout>
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
                        <a href="#">Хозтовары</a>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <a href="#">Гигиенические товары</a>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <a href="#">Диспенсеры и держатели для туалетной бумаги, полотенец и расходные материалы к ним</a>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <a href="#">Диспенсеры для полотенец</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="field"  id="product">
        <table>
            <tr>
                <td class="slid">
                    <div class="slidercontainer">
                        <!-- крупное изображение -->
                        <div class="img">
                            <a href="assets/img/236748.jpg"  id="bigimage" class='fresco' data-fresco-group='example'>
                                <img src="assets/img/236748.jpg" id="bigimageimg" alt="" />
                            </a>
                        </div>
                        <!-- Миниатюры -->
                        <div class="thumbs">
                            <!-- Миниатюра 1 -->
                            <div class="thumb">
                                <a href="assets/img/236748.jpg" class='sliderpr fresco' data-fresco-group='example'>
                                    <img src="assets/img/236748.jpg" alt="" />
                                    <div class="overlayit"></div>
                                </a>
                            </div>
                            <!-- Миниатюра 2 -->
                            <div class="thumb">
                                <a href="assets/img/236748_1.jpg" class='sliderpr fresco' data-fresco-group='example'>
                                    <img src="assets/img/236748_1.jpg" alt="" />
                                    <div class="overlayit"></div>
                                </a>
                            </div>
                            <!-- Миниатюра 3 -->
                            <div class="thumb">
                                <a href="assets/img/236748_2.jpg" class='sliderpr fresco' data-fresco-group='example'>
                                    <img src="assets/img/236748_2.jpg" alt="" />
                                    <div class="overlayit"></div>
                                </a>
                            </div>
                            <!-- Миниатюра 4 -->
                            <div class="thumb">
                                <a href="assets/img/236748_3.jpg" class='sliderpr fresco' data-fresco-group='example'>
                                    <img src="assets/img/236748_3.jpg" alt="" />
                                    <div class="overlayit"></div>
                                </a>
                            </div>
                            <!-- Миниатюра 5 -->
                            <div class="thumb">
                                <a href="assets/img/236748_4.jpg" class='sliderpr fresco' data-fresco-group='example'>
                                    <img src="assets/img/236748_4.jpg" alt="" />
                                    <div class="overlayit"></div>
                                </a>
                            </div>
                            <!-- Миниатюра 6 -->
                            <div class="thumb">
                                <a href="assets/img/236748_5.jpg" class='sliderpr fresco' data-fresco-group='example'>
                                    <img src="assets/img/236748_5.jpg" alt="" />
                                    <div class="overlayit"></div>
                                </a>
                            </div>
                            <!-- Миниатюра 7 -->
                            <div class="thumb">
                                <a href="assets/img/236748_6.jpg" class='sliderpr fresco' data-fresco-group='example'>
                                    <img src="assets/img/236748_6.jpg" alt="" />
                                    <div class="overlayit"></div>
                                </a>
                            </div>
                            <!-- Миниатюра 8 -->
                            <div class="thumb">
                                <a href="assets/img/236748_7.jpg" class='sliderpr fresco' data-fresco-group='example'>
                                    <img src="assets/img/236748_7.jpg" alt="" />
                                    <div class="overlayit"></div>
                                </a>
                            </div>
                            <!-- Миниатюра 9 -->
                            <div class="thumb">
                                <a href="assets/img/236748_8.jpg" class='sliderpr fresco' data-fresco-group='example'>
                                    <img src="assets/img/236748_8.jpg" alt="" />
                                    <div class="overlayit"></div>
                                </a>
                            </div>
                            <!-- Миниатюра 10 -->
                            <div class="thumb">
                                <a href="assets/img/236748_9.jpg" class='sliderpr fresco' data-fresco-group='example'>
                                    <img src="assets/img/236748_9.jpg" alt="" />
                                    <div class="overlayit"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                    <script type="text/javascript" src="assets/js/jquery.browser.min.js"></script>
                    <script type="text/javascript" src="assets/js/fresco.js"></script>
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
                        <tr>
                            <td class="prod_price" colspan="2">
                                <div class="blokleft">
                                    <p>{{ $product->price }} руб.</p>
                                </div>
                                <div class="stepper stepper--style-2 js-spinner blokleft">
                                    <input autofocus type="number" min="1" max="9999" step="1" value="1" class="stepper__input">
                                    <div class="stepper__controls">
                                        <button type="button" spinner-button="up">+</button>
                                        <button type="button" spinner-button="down">−</button>
                                    </div>
                                </div>

                                <script src="js/stepper.min.js"></script>
                                <div class="prod_but">
                                    <a href="#">В КОРЗИНУ</a>
                                </div>
                            </td>
                        </tr>
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
    <div id="concomitant" class="field">
        <div class="category">
            <p>Вместе с этим товаром покупают:</p>
        </div>
        <table>
            <tr>
                <td class="left">
                    <table>
                        <tr>
                            <td  class="title" colspan="2">
                                <p><span>ХИТ ПРОДАЖ</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td  class="images" colspan="2">
                                <div>
                                    <a href="#">
                                        <img src="images/600163.jpg" alt="Товар" />
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="tov" colspan="2">
                                <p>
                                    <a href="#">Диспенсер для полотенец TORK (Система H3) Elevation, mini, ZZ, белый, 55310</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="price">
                                <p><span>2996.77</span> р.</p>
                            </td>
                            <td class="buy">
                                <p>
                                    <a href="#">
                                        <span>КУПИТЬ</span>
                                    </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="center">
                    <table>
                        <tr>
                            <td  class="title" colspan="2">
                                <p><span>ХИТ ПРОДАЖ</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td  class="images" colspan="2">
                                <div>
                                    <a href="#">
                                        <img src="images/603061.jpg" alt="Товар" />
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="tov" colspan="2">
                                <p>
                                    <a href="#">Средство для уборки туалета 1 л, "Белизна-гель" с отбеливающим эффектом</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="price">
                                <p><span>106.88</span> р.</p>
                            </td>
                            <td class="buy">
                                <p>
                                    <a href="#">
                                        <span>КУПИТЬ</span>
                                    </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="center">
                    <table>
                        <tr>
                            <td  class="title" colspan="2">
                                <p><span>ХИТ ПРОДАЖ</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td  class="images" colspan="2">
                                <div>
                                    <a href="#">
                                        <img src="images/603527.jpg" alt="Товар" />
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td  class="tov" colspan="2">
                                <p>
                                    <a href="#">Чистящее средство для ванн и раковин 500 мл, SARMA (Сарма) "Свежесть", универсальное, гель, 8079</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="price">
                                <p><span>132.26</span> р.</p>
                            </td>
                            <td class="buy">
                                <p>
                                    <a href="#">
                                        <span>КУПИТЬ</span>
                                    </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="right">
                    <table>
                        <tr>
                            <td  class="title" colspan="2">
                                <p><span>ХИТ ПРОДАЖ</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td  class="images" colspan="2">
                                <div>
                                    <a href="#">
                                        <img src="images/601426.jpg" alt="Товар" />
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td  class="tov" colspan="2">
                                <p>
                                    <a href="#">Диспенсер для полотенец ЛАЙМА PROFESSIONAL (Система H3), ZZ (V), белый, ABS-пластик, 601426</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="price">
                                <p><span>2068.00</span> р.</p>
                            </td>
                            <td class="buy">
                                <p>
                                    <a href="#">
                                        <span>КУПИТЬ</span>
                                    </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="cleaner"></div>
    <div class="otstyp">
    </div>
</x-app-layout>
