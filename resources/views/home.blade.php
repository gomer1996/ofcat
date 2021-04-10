<x-app-layout>
    @section('title', 'Интернет магазин Ofcat')
    <x-banners />

    <div id="benefit">
        <div class="field">
            <table>
                <tr>
                    <td class="benefit_left">
                        <p>Выгодные предложения</p>
                    </td>
                    <td class="benefit_first">
                        <a href="#">
                            <span>СПЕЦПРЕДЛОЖЕНИЯ</span>
                        </a>
                    </td>
                    <td>
                        <a href="#">
                            <span>ДЕЗИНФЕКЦИЯ И УБОРКА</span>
                        </a>
                    </td>
                    <td>
                        <a href="#">
                            <span>ХОЗТОВАРЫ</span>
                        </a>
                    </td>
                    <td>
                        <a href="#">
                            <span>КАНЦТОВАРЫ</span>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div id="profit" class="field">
        <table class="profit_menu">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td class="profit_left">
                                <img src="images/week.png" alt="Акционное предложение" />
                            </td>
                            <td>
                                <p>
                                    <a href="#">
                                        <span>ЦЕНА НЕДЕЛИ</span>
                                    </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td class="profit_left">
                                <img src="images/max.png" alt="Акционное предложение" />
                            </td>
                            <td>
                                <p>
                                    <a href="#">
                                        <span>ЦЕНА НЕДЕЛИ</span>
                                    </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td class="profit_left">
                                <img src="images/week.png" alt="Акционное предложение" />
                            </td>
                            <td>
                                <p>
                                    <a href="#">
                                        <span>ЦЕНА НЕДЕЛИ</span>
                                    </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td class="profit_left">
                                <img src="images/max.png" alt="Акционное предложение" />
                            </td>
                            <td>
                                <p>
                                    <a href="#">
                                        <span>ЦЕНА НЕДЕЛИ</span>
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
    <x-popular-products />
    <div class="cleaner"></div>
        <x-news />
    <div class="cleaner"></div>
</x-app-layout>
