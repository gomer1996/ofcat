<table>
    <tr>
        <td  class="title" colspan="2">
            <p><span>ХИТ ПРОДАЖ</span></p>
        </td>
    </tr>
    <tr>
        <td  class="images" colspan="2">
            <div style="min-width: 300px">
                @if($product->getMedia('product_media_collection')->first())
                    <a href="#">
                        <img src="{{ $product->getMedia('product_media_collection')->first()->getFullUrl() }}" alt="Товар" />
                    </a>
                @endif
            </div>
        </td>
    </tr>
    <tr>
        <td class="tov" colspan="2">
            <p>
                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
            </p>
        </td>
    </tr>
    <tr>
        <td class="price">
            <p><span>{{ $product->new_price }}</span> р.</p>
        </td>
        <td class="buy">
            <p>
                <a href="#" wire:click.prevent="addToCart({{ $product }})">
                    <span>КУПИТЬ</span>
                </a>
            </p>
        </td>
    </tr>
</table>
