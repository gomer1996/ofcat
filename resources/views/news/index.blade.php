<x-app-layout>
    @section('title', 'Новости')
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
                </tr>
            </table>
        </div>
    </div>
    <div id="newspage">
        <div class="field">
            <article>
                <table>
                    <tr>
                        <td colspan="3">
                            <h2>НОВОСТИ</h2>
                        </td>
                    </tr>
                    @foreach($news->chunk(3) as $chunk)
                    <tr>
                        @foreach($chunk as $singleNews)
                            <td class="page_left">
                                <a href="{{ route('news.show', $singleNews) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$singleNews->img) }}" alt="Новость" />
                                    <p class="page_title">{{ $singleNews->title }}</p>
                                    <p>{{ $singleNews->intro_content }}</p>
                                    <p><span>{{ $singleNews->formatted_date }}</span></p>
                                </a>
                            </td>
                        @endforeach
                    </tr>
                    @if(!$loop->last)
                        <tr>
                            <td colspan="3" class="separate">
                            </td>
                        </tr>
                    @endif
                    @endforeach
                </table>
            </article>
        </div>
        {{ $news->links('pagination') }}
    </div>
</x-app-layout>
