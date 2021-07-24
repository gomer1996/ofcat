<x-app-layout>
    @section('title', 'Авторизация')
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
                        <a href="#">Вход</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="cleaner"></div>
    <div id="entranse">
        <div class="field">
            <table>
                <tr  class="registr_first">
                    <td>
                        <img src="images/lapa.png" alt="картинка" />
                        <p>ВХОД ДЛЯ ЗАРЕГИСТРИРОВАННЫХ ПОКУПАТЕЛЕЙ</p>
                    </td>
                    <td>
                        <p>ДЛЯ НОВЫХ ПОКУПАТЕЛЕЙ</P>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    <!-- Session Status -->
                                    <x-auth-session-status class="mb-4" :status="session('status')" />

                                    <form action="{{ route('login') }}" method="post" class="form">
                                        @csrf
                                        <p>
                                            <input type="email"
                                                   name="email"
                                                   required="required"
                                                   autofocus="autofocus"
                                                   class="@error('email') is-invalid-input @enderror"
                                                   placeholder="E-mail" />
                                        </p>
                                        @error('email')
                                            <p class="invalid-input-msg">{{ $message }}</p>
                                        @enderror
                                        <p>
                                            <input type="password"
                                                   name="password"
                                                   required="required"
                                                   class="@error('password') is-invalid-input @enderror"
                                                   placeholder="Пароль" />
                                        </p>
                                        @error('password')
                                            <p class="invalid-input-msg">{{ $message }}</p>
                                        @enderror
                                        <p class="registr_pass">
                                            <a href="{{ route('password.request') }}" >Забыли пароль?</a>
                                        </p>
                                        <p>
                                            <input type="submit" value="ВОЙТИ" />
                                        </p>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="registr_top">
                        <p>Просим Вас зарегистрироваться в нашем интернет-магазине, это не займет много времени.</p>
                        <p>Личные сведения, полученные при регистрации или каким-либо иным образом, будут использованы исключительно для исполнения Ваших заказов, и не будут передаваться третьим организациям и лицам, без Вашего согласия, за исключением ситуаций, когда этого требует закон или судебное решение.</p>
                        <a href="{{ route('register') }}">
                            <span>ЗАРЕГИСТРИРОВАТЬСЯ</span>
                        </a>

                    </td>
                </tr>
            </table>
        </div>
    </div>
</x-app-layout>
