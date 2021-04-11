<x-app-layout>
    @section('title', $category->name)
    <div id="hornav">
        <div class="field">
            <table>
                <tr>
                    <td>
                        <a href="/">Главная</a>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <a href="#">{{ $category->name }}</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="field">
        <div id="popular" class="field">
            <div class="category">
                <p>{{ $category->name }}</p>
            </div>
            <table>
                @foreach($products->chunk(4) as $chunk)
                    <tr>
                        @foreach($chunk as $product)
                            <td>
                                <livewire:product-single :product="$product" :key="$product->id" />
                            </td>
                        @endforeach
                    </tr>
                    @if(!$loop->last)
                        <tr>
                            <td class="elevation" colspan="3">
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>

    </div>
    <div class="otstyp"></div>
</x-app-layout>
