{{--<x-guest-layout>--}}
{{--    <x-auth-card>--}}
{{--        <x-slot name="logo">--}}
{{--            <a href="/">--}}
{{--                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />--}}
{{--            </a>--}}
{{--        </x-slot>--}}

{{--        <!-- Session Status -->--}}
{{--        <x-auth-session-status class="mb-4" :status="session('status')" />--}}

{{--        <!-- Validation Errors -->--}}
{{--        <x-auth-validation-errors class="mb-4" :errors="$errors" />--}}

{{--        <form method="POST" action="{{ route('login') }}">--}}
{{--            @csrf--}}

{{--            <!-- Email Address -->--}}
{{--            <div>--}}
{{--                <x-label for="email" :value="__('Email')" />--}}

{{--                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />--}}
{{--            </div>--}}

{{--            <!-- Password -->--}}
{{--            <div class="mt-4">--}}
{{--                <x-label for="password" :value="__('Password')" />--}}

{{--                <x-input id="password" class="block mt-1 w-full"--}}
{{--                                type="password"--}}
{{--                                name="password"--}}
{{--                                required autocomplete="current-password" />--}}
{{--            </div>--}}

{{--            <!-- Remember Me -->--}}
{{--            <div class="block mt-4">--}}
{{--                <label for="remember_me" class="inline-flex items-center">--}}
{{--                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">--}}
{{--                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>--}}
{{--                </label>--}}
{{--            </div>--}}

{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                @if (Route::has('password.request'))--}}
{{--                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">--}}
{{--                        {{ __('Forgot your password?') }}--}}
{{--                    </a>--}}
{{--                @endif--}}

{{--                <x-button class="ml-3">--}}
{{--                    {{ __('Login') }}--}}
{{--                </x-button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </x-auth-card>--}}
{{--</x-guest-layout>--}}

<x-app-layout>
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

                                    <!-- Validation Errors -->
                                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                                    <form action="{{ route('login') }}" method="post">
                                        @csrf
                                        <p>
                                            <input type="email" name="email" required="required" autofocus="autofocus" placeholder="E-mail" />
                                        </p>
                                        <p>
                                            <input type="password" name="password" required="required" placeholder="Пароль" />
                                        </p>

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
                        <a href="#">
                            <span>ЗАРЕГИСТРИРОВАТЬСЯ</span>
                        </a>

                    </td>
                </tr>
            </table>
        </div>
    </div>
</x-app-layout>
