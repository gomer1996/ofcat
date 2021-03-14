<x-app-layout>
    @section('title', $news->title)
    <div class="cleaner"></div>
    <div id="hornav">
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
                        <a href="#">Новости</a>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <a href="#">{{ $news->title }}</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="informtext field">
        <h3>НОВОСТИ КОМПАНИИ</h3>
        <h2>{{ $news->title }}</h2>
        <div>
            {!! $news->content !!}
        </div>

        <p>{{ $news->formatted_date }}</p>
    </div>
</x-app-layout>
