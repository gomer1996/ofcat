<tr>
    <td>
        <p>
            <a href="{{ route('profile.index') }}"
               class="{{ Request::url() === route('profile.index') ? 'kabactiv' : "" }}">Персональные данные</a>
        </p>
    </td>
    <td>
        <p>
            <a href="{{ route('profile.orders') }}"
               class="{{ Request::url() === route('profile.orders') ? 'kabactiv' : "" }}">Мои заказы</a>
        </p>
    </td>
    <td>
        <p>
            <a href="{{ route('profile.addresses') }}"
               class="{{ Request::url() === route('profile.addresses') ? 'kabactiv' : "" }}">Адреса доставки</a>
        </p>
    </td>
    <td>
        <p>
            <a href="{{ route('profile.subscriptions') }}"
               class="{{ Request::url() === route('profile.subscriptions') ? 'kabactiv' : "" }}">Управление рассылкой</a>
        </p>
    </td>
</tr>
