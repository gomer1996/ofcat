<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title')</title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Интернет-магазин товаров для офисов, предприятий и школ" />
    <meta name="keywords" content="Интернет магазин для офисов, интернет магазин комплексного снабжения, интернет магазин канцелярских товаров, интернет магазин бытовой химии, интернет магазин стульев и кресел, интернет магазин хозяйственных товаров" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link type="text/css" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/menu.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    @livewireStyles
</head>
<body>
<div id="container">

    <x-header />

    <div class="cleaner"></div>
    <div id="proba">
        <div class="field">
            <div  class="header_contact">
                <div class="blokleft">
                    <div class="header_logo blokleft">
                        <a class="demo" href="/">
                            <img class="raz" src="/images/logohover.png" alt="Логотип компании" />
                            <img class="dva" src="/images/logo.png" alt="Логотип компании" />
                        </a>
                    </div>
                    <div class="header_im">
                        <h1>Универсальный интернет-магазин<br />для дома и офиса</h1>
                    </div>
                </div>
            </div>
            <div class="blocright">
                <div class="header_mail">
                    <p>Напишите нам:</p>
                    <p><span>ofcat@gmail.com</span></P>
                </div>
                <div class="header_tel">
                    <p>Есть вопрос?</p>
                    <p><span>8-913-000-00-00</span></P>
                </div>
                <div class="contact_cent">
                    <a href="#">
                        <span>ОНЛАЙН-КОНСУЛЬТАНТ</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="cleaner"></div>
        <div class="field">
            <div class="blokleft">
                <x-menu />
            </div>
            <div class="blocright">
                <div id="header_search">
                    <form name="search" action="{{ route('products.search') }}" method="get">
                        <div class="search">
                            <div class="blokleft"><input type="text" name="q" value="{{ request()->get('q') }}"  placeholder="Поиск по каталогу" /></div>
                            <div class="blocright"><input type="submit" value="" /></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="cleaner"></div>

        {{ $slot }}

    <x-footer />
    @livewireScripts
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        Livewire.on('livewireNotify', (type, msg) => {
            toastr[type](msg);
        })
    </script>
    @stack('scripts')
</div>
</body>
</html>
