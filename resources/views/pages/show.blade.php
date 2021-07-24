<x-app-layout>
    @section('title', $page->title)
    <div class="cleaner"></div>
    <div id="hornav">
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
                        <a href="#">{{ $page->title }}</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div id="vakansii" class="field">
        <div>
            <h1>{{ $page->title }}</h1>
        </div>
        <div>
            {!! $page->content !!}
        </div>
    </div>
</x-app-layout>
