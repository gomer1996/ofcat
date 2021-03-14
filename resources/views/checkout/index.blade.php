@php
 $type = request()->get('type') === 'company' ? 'company' : 'person';
 $user = auth()->user();
@endphp
@section('title', 'Оформление заказа')
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
                        <a href="#">Моя корзина</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div id="korzina_2">
        <div  class="field">
            @if (session('status'))
                <div style="color: brown;">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="post" class="form" id="checkout-form">
            @csrf
            <table>
                <tr>
                    <td>
                        <table class="ofzakaz_lev">
                            <tr>
                                <td class="ofzakaz_alig">
                                    <div>
                                        <img src="images/lapa.png" alt="" />
                                        <p class="ofzakaz_zag">ВАШИ ДАННЫЕ</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="ofzakaz_lica">
                                    <div>
                                        <p>
                                            <a
                                                href="{{ route('checkout.index', ['type' => 'company']) }}"
                                                class="{{ $type === 'company' ? "ofzakaz_activ" : "" }}"
                                            >Юридическое лицо</a>
                                        </p>
                                        <p>
                                            <a
                                                href="{{ route('checkout.index', ['type' => 'person']) }}"
                                                class="{{ $type === 'person' ? "ofzakaz_activ" : "" }}"
                                            >Физическое лицо</a>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="ofzakaz_tab">
                                        @if($type === 'company')
                                            <tr>
                                                <td>
                                                    <p class="ofzakaz_text">Организация</p>
                                                    <p>
                                                        <input type="text"
                                                               class="@error('company') is-invalid-input @enderror"
                                                               name="company"
                                                               value="{{ old('company') ?? ($user ? $user->company_name : "") }}"
                                                               placeholder="Органицация" />
                                                    </p>
                                                    @error('company')
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
                                                           value="{{ old('name') ?? ($user ? $user->name : "") }}"
                                                           placeholder="Имя" />
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
                                                           value="{{ old('phone') ?? ($user ? $user->phone : "") }}"
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
                                                           name="email"
                                                           class="@error('email') is-invalid-input @enderror"
                                                           value="{{ old('email') ?? ($user ? $user->email : "") }}"
                                                           placeholder="E-mail" />
                                                </p>
                                                @error('email')
                                                    <p class="invalid-input-msg">
                                                        <small>{{ $message }}</small>
                                                    </p>
                                                @enderror
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="ofzakaz_alig">
                                    <div>
                                        <img src="images/lapa.png" alt="" />
                                        <p class="ofzakaz_zag">ДОСТАВКА</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="ofzakaz_tab">
                                        <tr>
                                            <td>
                                                <p class="ofzakaz_text">Адрес доставки</p>
                                                <p>

                                                        @if(auth()->user() && auth()->user()->addresses->count())
                                                        <select name="address" class="input-select @error('address') is-invalid-input @enderror" >
                                                            @foreach(auth()->user()->addresses as $address)
                                                                <option value="{{ $address->address }}">{{ $address->address }}</option>
                                                            @endforeach
                                                        </select>
                                                        @else
                                                            <input type="text"
                                                                   class="@error('address') is-invalid-input @enderror"
                                                                   name="address"
                                                                   value="{{ old('address') }}"
                                                                   placeholder="Улица, Дом/Корпус, Офис/Квартира" />
                                                        @endif
                                                </p>
                                                @error('address')
                                                    <p class="invalid-input-msg">
                                                        <small>{{ $message }}</small>
                                                    </p>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="ofzakaz_text">Комментарий</p>
                                                <p>
                                                    <input type="text" name="note"  value="{{ old('note') }}" />
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center;">
                                                <input type="radio"
                                                       name="delivery"
                                                       value="delivery"
                                                       class="@error('delivery') is-invalid-input @enderror"
                                                       @if(request()->get('delivery') === 'delivery') checked @endif>
                                                    Доставка
                                                <input type="radio"
                                                       name="delivery"
                                                       value="pickup"
                                                       class="@error('delivery') is-invalid-input @enderror"
                                                       @if(request()->get('delivery') === 'pickup') checked @endif>
                                                    Самовывоз
                                                @error('delivery')
                                                <p class="invalid-input-msg">
                                                    <small>{{ $message }}</small>
                                                </p>
                                                @enderror
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <livewire:cart-total />
                </tr>
            </table>
                <input type="hidden" name="user_type" value="{{ $type }}">
            </form>
        </div>
    </div>
</x-app-layout>
