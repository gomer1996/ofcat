<footer>
    <div id="footer" class="field">
        <table>
            <tr>
                <td class="bord" colspan="5">
                </td>
            </tr>
            <tr>
                <td class="footer_logo">
                    <a class="demo" href="#">
                        <img class="raz" src="/images/logohover.png" alt="Логотип компании" />
                        <img class="dva" src="/images/logo.png" alt="Логотип компании" />
                    </a>
                    <p>Интернет-магазин товаров<br />для дома и офиса</p>
                    <div class="footer_social">
                        <a href="#">
                            <img src="/images/hed_vk.png" alt="Вконтакте" />
                        </a>
                        <a class="social_last" href="#">
                            <img src="/images/hed_insta.png" alt="Инстаграмм" />
                        </a>
                    </div>
                </td>
                @foreach($pages as $page)
                    <td class="foot_bot">
                        <div class="footer_menu">
                            <p>{{ $page->title }}</p>
                            @if($page->children)
                                <nav>
                                    @foreach($page->children as $child)
                                        <a href="{{ route('pages.show', $child) }}">
                                            <span>{{ $child->title }}</span>
                                        </a>
                                    @endforeach
                                </nav>
                            @endif
                        </div>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td class="bord" colspan="5">
                </td>
            </tr>
            <tr>
                <td class="copirait" colspan="5">
                    <p>{{ date('Y') }}г.  «ofcat.ru».  Все права защищены.</p>
                    <p>Копирование информации с сайта возможно только с указанием прямой ссылки на первоисточник.</p>
                </td>
            </tr>
        </table>
    </div>
</footer>
