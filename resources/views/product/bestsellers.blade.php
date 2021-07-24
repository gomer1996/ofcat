<x-app-layout>
    @section('title', 'Хиты продаж')
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
                        <a href="{{ route('products.bestsellers') }}">Хиты продаж</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="field">
        <x-popular-products />
    </div>
    <div class="otstyp"></div>
</x-app-layout>
