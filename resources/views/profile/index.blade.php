@section('title', 'Профиль')
<x-app-layout>
    <div class="cleaner"></div>
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
                        <a href="#">Мой кабинет</a>
                    </td>
                    <td>
                        <p>/</p>
                    </td>
                    <td>
                        <a href="#">Персональные данные</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="kabinet">
        <div class="field">
            @if (session('status'))
                <div class="alert alert-{{ session('type') }}">
                    {{ session('status') }}
                </div>
            @endif
            <table>
                @include('profile.navs')
                <tr>
                    <td colspan="4">
                        <form name="redakt" action="{{ route('profile.update') }}" class="form" method="post">
                            @csrf
                            @method('PUT')
                            <table>
                                @if(auth()->user()->type === 'company')
                                    <tr>
                                        <td>
                                            <p class="ofzakaz_text">Организация</p>
                                            <p>
                                                <input type="text"
                                                       name="company_name"
                                                       required="required"
                                                       value="{{ auth()->user()->company_name }}"
                                                       class="@error('company') is-invalid-input @enderror"
                                                       placeholder="ООО Ромашка" />
                                            </p>
                                            @error('company_name')
                                                <p class="invalid-input-msg">
                                                    <small>{{ $message }}</small>
                                                </p>
                                            @enderror
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>
                                        <p class="ofzakaz_text">Имя</p>
                                        <p>
                                            <input type="text"
                                                   name="name"
                                                   class="@error('name') is-invalid-input @enderror"
                                                   required="required"
                                                   value="{{ auth()->user()->name }}"
                                                   placeholder="Андрей" />
                                        </p>
                                        @error('name')
                                            <p class="invalid-input-msg">
                                                <small>{{ $message }}</small>
                                            </p>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="ofzakaz_text">Номер телефона</p>
                                        <p>
                                            <input type="tel"
                                                   name="phone"
                                                   class="@error('phone') is-invalid-input @enderror"
                                                   pattern="[8]{1}[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}"
                                                   required="required"
                                                   value="{{ auth()->user()->phone }}"
                                                   placeholder="89999999999" />
                                        </p>
                                        @error('phone')
                                            <p class="invalid-input-msg">
                                                <small>{{ $message }}</small>
                                            </p>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="ofzakaz_text">E-mail</p>
                                        <p>
                                            <input type="email"
                                                   class="@error('email') is-invalid-input @enderror"
                                                   name="email"
                                                   required="required"
                                                   value="{{ auth()->user()->email }}"
                                                   placeholder="romashka@mail.ru" />
                                        </p>
                                        @error('email')
                                            <p class="invalid-input-msg">
                                                <small>{{ $message }}</small>
                                            </p>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="submit" value="СОХРАНИТЬ" />
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
