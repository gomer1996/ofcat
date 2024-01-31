<x-app-layout>
    @section('title', $category->name)
    @php
        $breadcrumbs = isset($breadcrumbs) ? $breadcrumbs : [];
    @endphp
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
    <livewire:products-list
        :category="$category" />
    <div class="otstyp">
    </div>
</x-app-layout>
