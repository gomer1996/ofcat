<x-app-layout>
    @section('title', $category->name)
    <div class="cleaner"></div>
    <div id="hornav">
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
                        <a href="{{ route('categories.all') }}">Каталог</a>
                    </td>
                    <td>
                        <p>/</p>
                    </td>
                    @foreach($breadcrumbs as $cat)
                        @if($cat)
                            <td>
                                <a href="{{ route('categories.index', $cat) }}">{{ $cat->name }}</a>
                            </td>
                            @if(!$loop->last)
                                <td>
                                    <p>/</p>
                                </td>
                            @endif
                        @endif
                    @endforeach
                </tr>
            </table>
        </div>
    </div>
    <div id="kataloggroup" class="field">
        <div class="subkataloggroup">
            <h1>{{ $category->name }}</h1>

            @foreach($category->children as $category)
                <dl>
                        <dt>
                            <img src="{{ asset("storage/categories/{$category->img}") }}" width="50px" alt="картинка группы" />
                            <a href="{{ route('categories.index', $category) }}">{{ $category->name }}</a>
                        </dt>
                        @if($category->children->count())
                            <dd>
                                <ul>
                                    @foreach($category->children as $child)
                                        <li>
                                            <a href="{{ route('categories.index', $child) }}">{{ $child->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </dd>
                        @endif
                </dl>
            @endforeach


        </div>
    </div>
    <div class="otstyp">
    </div>
</x-app-layout>
