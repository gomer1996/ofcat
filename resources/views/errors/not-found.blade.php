<x-app-layout>
    @section('title', 'Страница не найдена')

    <div id="error" class="field">
        <table>
            <tr>
                <td rowspan="2">
                    <img src="/images/404_03.png" alt="Котэ" />
                </td>
                <td class="error_sp">
                    <p><span>404</span></p>
                </td>
                <td>
                    <a href="/">
                        <span>НА ГЛАВНУЮ</span>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="error_p" colspan="2">
                    <p>ИЗВИНИТЕ...КАЖЕТСЯ, Я ЕЕ СЪЕЛ</p>
                </td>
            </tr>
        </table>
    </div>

</x-app-layout>
