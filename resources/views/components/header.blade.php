<header>
    <div class="field">
        <div class="blokleft">
            <nav>
                <ul class="top_menu">
                    @foreach($pages as $page)
                        <li>
                            <a href="{{ route('pages.show', $page) }}">
                                <span>{{ $page->title }}</span>
                            </a>
                        </li>
                    @endforeach
                    @auth
                        <li>
                            <a href="{{ route('profile.index') }}">Профиль</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    <span>Выход ({{ auth()->user()->name }})</span>
                                </a>
                            </form>
                        </li>
                    @endauth

                    @guest
                        <li>
                            <a href="{{ route('login') }}">
                                <span>Вход</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}">
                                <span>Регистрация</span>
                            </a>
                        </li>
                    @endguest
                </ul>
            </nav>
        </div>
        <div class="blocright">
            <div class="header_social blokleft">
                <a href="#">
                    <img src="/images/hed_vk.png" alt="Вконтакте" />
                </a>
                <a class="social_last" href="#">
                    <img src="/images/hed_insta.png" alt="Инстаграмм" />
                </a>
            </div>
            <livewire:cart-widget />
        </div>
    </div>
</header>
