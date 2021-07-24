<x-app-layout>
    @section('title', 'Хит продаж')
    <div id="hornav">
        <div class="field">
            <table>
                <tr>
                    <td>
                        <a href="#">Главная</a>
                    </td>
                    <td>
                        <p>/</p>
                    </td>
                    <td>
                        <a href="#">Новинки</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="field">
        <x-new-products />
    </div>
    <div class="otstyp"></div>
</x-app-layout>
