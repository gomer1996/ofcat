<x-app-layout>
    @section('title', 'Заказ успешно оформлен')
    <div class="cleaner"></div>
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
                        <a href="{{ route('cart.index') }}">Моя корзина</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div id="confirmed">
        <div  class="field">
            <table>
                <tr>
                    <td>
                        <p>Спасибо за Ваш заказ!<br/>Мы свяжемся с Вами<br/> в ближайшее время.</p>
                    </td>
                    <td>
                        <a href="/">
                            <span>НА ГЛАВНУЮ</span>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</x-app-layout>
