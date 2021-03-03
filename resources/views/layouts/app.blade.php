{{--<!DOCTYPE html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--    <head>--}}
{{--        <meta charset="utf-8">--}}
{{--        <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--        <meta name="csrf-token" content="{{ csrf_token() }}">--}}

{{--        <title>{{ config('app.name', 'Laravel') }}</title>--}}

{{--        <!-- Fonts -->--}}
{{--        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">--}}

{{--        <!-- Styles -->--}}
{{--        <link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}

{{--        <!-- Scripts -->--}}
{{--        <script src="{{ asset('js/app.js') }}" defer></script>--}}
{{--    </head>--}}
{{--    <body class="font-sans antialiased">--}}
{{--        <div class="min-h-screen bg-gray-100">--}}
{{--            @include('layouts.navigation')--}}

{{--            <!-- Page Heading -->--}}
{{--            <header class="bg-white shadow">--}}
{{--                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">--}}
{{--                    {{ $header }}--}}
{{--                </div>--}}
{{--            </header>--}}

{{--            <!-- Page Content -->--}}
{{--            <main>--}}
{{--                {{ $slot }}--}}
{{--            </main>--}}
{{--        </div>--}}
{{--    </body>--}}
{{--</html>--}}


    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Интернет-магазин</title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Интернет-магазин товаров для офисов, предприятий и школ" />
    <meta name="keywords" content="Интернет магазин для офисов, интернет магазин комплексного снабжения, интернет магазин канцелярских товаров, интернет магазин бытовой химии, интернет магазин стульев и кресел, интернет магазин хозяйственных товаров" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ asset('js/menu.js') }}"></script>
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
                            <img class="raz" src="images/logohover.png" alt="Логотип компании" />
                            <img class="dva" src="images/logo.png" alt="Логотип компании" />
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
                    <form name="search" action="#" method="get">
                        <div class="search">
                            <div class="blokleft"><input type="text" name="words"  placeholder="Поиск по каталогу" /></div>
                            <div class="blocright"><input type="submit" name="seatch" value="" /></div>
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
    <script>
        Livewire.on('productAddedToCart', () => {
            //alert('A post was added with the id of: ');
        })
    </script>
</div>
</body>
</html>
