<x-app-layout>
    <div class="cleaner"></div>
    <div id="hornav" class="hornav_fon">
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
                        <a href="#">Моя корзина</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div id="korzina_2">
        <div  class="field">
            <table>
                <tr>
                    <td>
                        <table class="ofzakaz_lev">
                            <tr>
                                <td class="ofzakaz_alig">
                                    <div>
                                        <img src="images/lapa.png" alt="" />
                                        <p class="ofzakaz_zag">ВАШИ ДАННЫЕ</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="ofzakaz_lica">
                                    <div>
                                        <p>
                                            <a href="#" class="ofzakaz_activ">Юридическое лицо</a>
                                        </p>
                                        <p>
                                            <a href="#">Физическое лицо</a>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <form name="ofzakaz" action="#" method="post">
                                        <table class="ofzakaz_tab">
                                            <tr>
                                                <td>
                                                    <p class="ofzakaz_text">Организация</p>
                                                    <p>
                                                        <input type="text" name="name" required="required" placeholder="Органицация" />
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="ofzakaz_text">Имя</p>
                                                    <p>
                                                        <input type="text" name="name" required="required" placeholder="Имя" />
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="ofzakaz_text">Номер телефона</p>
                                                    <p>
                                                        <input type="tel" name="tel" pattern="[8]{1}[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}" required="required" placeholder="89999999999" />
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="ofzakaz_text">E-mail</p>
                                                    <p>
                                                        <input type="email" name="email" required="required" placeholder="E-mail" />
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td class="ofzakaz_alig">
                                    <div>
                                        <img src="images/lapa.png" alt="" />
                                        <p class="ofzakaz_zag">ДОСТАВКА</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <form name="ofzakaz_2" action="#" method="post">
                                        <table class="ofzakaz_tab">
                                            <tr>
                                                <td>
                                                    <p class="ofzakaz_text">Адрес доставки</p>
                                                    <p>
                                                        <input type="text" name="name" required="required" placeholder="Улица, Дом/Корпус, Офис/Квартира" />
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="ofzakaz_text">Комментарий</p>
                                                    <p>
                                                        <input type="text" name="name" required="required" />
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <livewire:cart-total />
                </tr>
            </table>
        </div>
    </div>
</x-app-layout>
