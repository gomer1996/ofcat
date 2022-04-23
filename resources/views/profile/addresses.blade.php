@section('title', 'Адреса доставок')
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
                        <a href="#">Адреса доставки</a>
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
                        <table class="kabinet_2">
                            <tr>
                                <td>
                                    <p>ID</p>
                                </td>
                                <td>
                                    <p>Адрес</p>
                                </td>
                                <td>
                                    <p>Дата создания</p>
                                </td>
                                <td>
                                    <p></p>
                                </td>
                            </tr>
                            @foreach($addresses as $address)
                                <tr class="kab2aktiv">
                                    <td>
                                        <p>№{{ $address->id }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $address->address }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $address->created_at->format('d.m.Y') }}</p>
                                    </td>
                                    <td style="text-align: center;">
                                        <form action="{{ route('profile.destroy.addresses', $address) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" style="color:brown;" onclick="event.preventDefault();
                                                this.closest('form').submit();"><small>Удалить</small></a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin: 30px 7px;" >
            <a href="{{ route('profile.create.addresses') }}" class="btn-primary">ДОБАВИТЬ</a>
        </div>
    </div>
</x-app-layout>
