<x-app-layout>
    @section('title', 'Корзина')
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
    <livewire:cart-page />
</x-app-layout>
