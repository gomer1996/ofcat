<div id="news">
    <div class="field">
        <article>
            <table>
                <tr>
                    <td colspan="3">
                        <h2>НАШИ НОВОСТИ</h2>
                    </td>
                </tr>
                <tr>
                    @foreach($news as $single)
                    <td class="news_cent">
                        <a href="#" target="_blank">
                            <p class="news_title">{{ $single->title }}</p>
                            <p>{{ $single->intro_content }}</p>
                            <p><span>{{ $single->formattes_date }}</span></p>
                        </a>
                        @if($loop->last)
                            <a id="news_key" href="{{ route('news.index') }}">
                                <span>ВСЕ НОВОСТИ</span>
                            </a>
                        @endif
                    </td>
                    @endforeach
{{--                    <td  class="news_cent">--}}
{{--                        <a href="#" target="_blank">--}}
{{--                            <p class="news_title">Изменен график работы в праздничные дни</p>--}}
{{--                            <p>Режим работы интернет магазина в период с 30.12.2019 по 09.01.2020 года Режим работы интернет магазина в период с 30.12.2019 по 09.01.2020 года...</p>--}}
{{--                            <p><span>20.12.2019</span></p>--}}
{{--                        </a>--}}
{{--                        <a id="news_key" href="{{ route('news.index') }}">--}}
{{--                            <span>ВСЕ НОВОСТИ</span>--}}
{{--                        </a>--}}
{{--                    </td>--}}
                    <td  class="news_right subscr">
                        <p>ХОТИТЕ ПЛАТИТЬ<br />МЕНЬШЕ?</P>
                        <form name="subscription" action="#" method="post">
                            <p><input type="text" name="Name" placeholder="Ваше имя" /></p>
                            <p><input type="email" name="email" required="required" placeholder="Ваш e-mail" /></p>
                            <p><input type="submit" name="subscription" value="ПОДПИШУСЬ Я НА РАССЫЛКУ КОТА" /></p>
                        </form>
                    </td>
                </tr>
            </table>
        </article>
    </div>
</div>
