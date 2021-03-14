<x-app-layout>
    @section('title', 'Результаты поиска')
    <div id="popular" class="field" style="margin-bottom: 30px;">
        <div class="category">
            <p>Результаты поиска</p>
        </div>
        <table>
            @if($products->count())
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
            @else
                <small>По вашему запросу ничего не найдено...</small>
            @endif
        </table>
    </div>
</x-app-layout>
