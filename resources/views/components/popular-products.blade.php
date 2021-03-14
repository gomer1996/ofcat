<div id="popular" class="field">
    <div class="category">
        <p>Самое популярное</p>
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
