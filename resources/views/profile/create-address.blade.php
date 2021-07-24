@section('title', 'Адреса доставок')
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
                        <p>/</p>
                    </td>
                    <td>
                        <a href="#">Мой кабинет</a>
                    </td>
                    <td>
                        <p>/</p>
                    </td>
                    <td>
                        <a href="#">Адреса доставки</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="kabinet">
        <div class="field">
            <table>
                <tr>
                    <td colspan="4">
                        <form name="redakt" action="{{ route('profile.store.addresses') }}" method="post">
                            @csrf
                            <table class="kabadres">
                                <tr>
                                    <td>
                                        <p class="ofzakaz_text">Адрес</p>
                                        <p>
                                            <input type="text" name="address" required="required" placeholder="Богдана Хмельницкого 52 к2 офис ООО Ромашка" />
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="submit" value="СОЗДАТЬ" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</x-app-layout>
