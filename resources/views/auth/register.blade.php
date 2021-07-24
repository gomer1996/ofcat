@php
    $isCompany = request()->get('type') === 'company';
@endphp
<x-app-layout>
    @section('title', 'Регистрация')
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
                        <a href="#">Регистрация</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="cleaner"></div>
    <div id="registration" >
        <div class="field">
            <form method="POST" action="{{ route('register') }}" class="form">
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
                                           class="@error('company_name') is-invalid-input @enderror"
                                           value="{{ old('company_name') }}"
                                           placeholder="Организация"
                                           required />
                                </p>
                                @error('company_name')
                                    <p class="invalid-input-msg">{{ $message }}</p>
                                @enderror
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
                                       class="@error('name') is-invalid-input @enderror"
                                       value="{{ old('name') }}"
                                       placeholder="Имя"
                                       required autofocus />
                            </p>
                            @error('name')
                                <p class="invalid-input-msg">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="registr_text">Номер телефона</p>
                            <p>
                                <input id="phone"
                                       type="tel"
                                       name="phone"
                                       class="@error('phone') is-invalid-input @enderror"
                                       value="{{ old('phone') }}"
                                       placeholder="89999999999"
                                       required autofocus />
                            </p>
                            @error('phone')
                                <p class="invalid-input-msg">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="registr_text">E-mail:</p>
                            <p>
                                <input id="email"
                                       type="email"
                                       name="email"
                                       class="@error('email') is-invalid-input @enderror"
                                       placeholder="Email"
                                       value="{{ old('email') }}"
                                       required />
                            </p>
                            @error('email')
                                <p class="invalid-input-msg">{{ $message }}</p>
                            @enderror
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
                                       class="@error('password') is-invalid-input @enderror"
                                       required autocomplete="new-password" />
                            </p>
                            @error('password')
                                <p class="invalid-input-msg">{{ $message }}</p>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="registr_text">Подтвердите пароль:</p>
                            <p>
                                <input id="password_confirmation"
                                       type="password"
                                       placeholder="Повторите пароль"
                                       class="@error('password_confirmation') is-invalid-input @enderror"
                                       name="password_confirmation"
                                       required />
                            </p>
                            @error('password_confirmation')
                                <p class="invalid-input-msg">{{ $message }}</p>
                            @enderror
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
