@section('title', 'Подписки')
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
                        <a href="#">Мой кабинет</a>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <a href="#">Управление рассылкой</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="kabinet">
        <div class="field">
            <table>
                @include('profile.navs')
                <form action="{{ route('profile.update.subscriptions') }}" class="form" method="post" >
                    <tr>
                        <td colspan="4">

                                @csrf
                                @method('PUT')
                                <table class="kabrass">
                                    <tr>
                                        <td>
                                            <label class="korzcont">
                                                <input type="checkbox"
                                                       name="is_subscriptions_enabled"
                                                       {{ auth()->user()->is_subscriptions_enabled ? "checked" : "" }}
                                                       value="true">
                                            </label>
                                        </td>
                                        <td>
                                            <p>Я желаю получать рассылки</p>
                                        </td>
                                    </tr>
                                </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <input type="submit" value="СОХРАНИТЬ"/>
                        </td>
                    </tr>
                </form>
            </table>
        </div>
    </div>
</x-app-layout>
