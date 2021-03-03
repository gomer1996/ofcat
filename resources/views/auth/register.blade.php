{{--<x-guest-layout>--}}
{{--    <x-auth-card>--}}
{{--        <x-slot name="logo">--}}
{{--            <a href="/">--}}
{{--                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />--}}
{{--            </a>--}}
{{--        </x-slot>--}}

{{--        <!-- Validation Errors -->--}}
{{--        <x-auth-validation-errors class="mb-4" :errors="$errors" />--}}

{{--        <form method="POST" action="{{ route('register') }}">--}}
{{--            @csrf--}}

{{--            <!-- Name -->--}}
{{--            <div>--}}
{{--                <x-label for="name" :value="__('Name')" />--}}

{{--                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />--}}
{{--            </div>--}}

{{--            <!-- Email Address -->--}}
{{--            <div class="mt-4">--}}
{{--                <x-label for="email" :value="__('Email')" />--}}

{{--                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />--}}
{{--            </div>--}}

{{--            <!-- Password -->--}}
{{--            <div class="mt-4">--}}
{{--                <x-label for="password" :value="__('Password')" />--}}

{{--                <x-input id="password" class="block mt-1 w-full"--}}
{{--                                type="password"--}}
{{--                                name="password"--}}
{{--                                required autocomplete="new-password" />--}}
{{--            </div>--}}

{{--            <!-- Confirm Password -->--}}
{{--            <div class="mt-4">--}}
{{--                <x-label for="password_confirmation" :value="__('Confirm Password')" />--}}

{{--                <x-input id="password_confirmation" class="block mt-1 w-full"--}}
{{--                                type="password"--}}
{{--                                name="password_confirmation" required />--}}
{{--            </div>--}}

{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">--}}
{{--                    {{ __('Already registered?') }}--}}
{{--                </a>--}}

{{--                <x-button class="ml-4">--}}
{{--                    {{ __('Register') }}--}}
{{--                </x-button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </x-auth-card>--}}
{{--</x-guest-layout>--}}

@php
    $isCompany = request()->get('type') === 'company';
@endphp
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
                        <a href="#">Регистрация</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="cleaner"></div>
    <div id="registration" >
        <div class="field">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <table>
                    <tr>
                        <td>
                            <p class="registr_first">НОВЫЙ ПОКУПАТЕЛЬ</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="registration_lica">
                            <div>
                                <p>
                                    <a @if($isCompany) class="ofzakaz_activ" @endif
                                        href="{{ route('register', ['type' => 'company']) }}">Юридическое лицо</a>
                                </p>
                                <p>
                                    <a @if(!$isCompany) class="ofzakaz_activ" @endif
                                        href="{{ route('register') }}">Физическое лицо</a>
                                </p>
                            </div>
                        </td>
                    </tr>
                    @if($isCompany)
                        <tr>
                            <td>
                                <p class="registr_text">Организация</p>
                                <p>
                                    <input id="company_name"
                                           type="text"
                                           name="company_name"
                                           value="{{ old('company_name') }}"
                                           placeholder="Организация"
                                           required />
                                </p>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>
                            <p class="registr_text">Имя</p>
                            <p>
                                <input id="name"
                                       type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Имя"
                                       required autofocus />
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="registr_text">Номер телефона</p>
                            <p>
                                <input id="phone"
                                       type="tel"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       placeholder="89999999999"
                                       required autofocus />
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="registr_text">E-mail:</p>
                            <p>
                                <input id="email"
                                       type="email"
                                       name="email"
                                       placeholder="Email"
                                       value="{{ old('email') }}"
                                       required />
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="registr_text">Пароль:</p>
                            <p class="registr_text"><span>Не менее 8 символов, обязательно должен содержать: цифры, заглавные и строчные буквы</span></p>
                            <p>
                                <input id="password"
                                       placeholder="Пароль"
                                       type="password"
                                       name="password"
                                       required autocomplete="new-password" />
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="registr_text">Подтвердите пароль:</p>
                            <p>
                                <input id="password_confirmation"
                                       type="password"
                                       placeholder="Повторите пароль"
                                       name="password_confirmation"
                                       required />
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="ЗАРЕГИСТРИРОВАТЬСЯ" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</x-app-layout>
