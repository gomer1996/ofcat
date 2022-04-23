@section('title', 'Мои заказы')
<x-app-layout>
    <div class="cleaner"></div>
    <div id="hornav" class="hornav_fon">
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
                        <a href="#">Мой кабинет</a>
                    </td>
                    <td>
                        <p>/</p>
                    </td>
                    <td>
                        <a href="#">Мои заказы</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="kabinet">
        <div class="field">
            <table>
                @include('profile.navs')
                <tr>
                    <td colspan="4">
                        <table class="kabinet_2">
                            <tr>
                                <td>
                                    <p>Номер заказа</p>
                                </td>
                                <td>
                                    <p>Дата заказа</p>
                                </td>
                                <td>
                                    <p>Сумма заказа</p>
                                </td>
                                <td>
                                    <p>Статус</p>
                                </td>
                            </tr>
                            @foreach($orders as $order)
                                <tr class="kab2aktiv">
                                    <td>
                                        <p>№{{ $order->id }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $order->created_at->format('d.m.Y') }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $order->price }} руб.</p>
                                    </td>
                                    <td>
                                        <p>{{ $order->status }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</x-app-layout>
