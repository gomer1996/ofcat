<td style="width: 350px">
    <table>
        <tr>
            <td  class="title" colspan="2">
                @if($product->is_hit)
                    <p><span>ХИТ ПРОДАЖ</span></p>
                @endif
            </td>
        </tr>
        <tr>
            <td class="images" colspan="2">
{{--                <div style="max-width: 300px; overflow: hidden; margin: auto;">--}}
                <div>
                    <a href="{{ $product->getLink() }}">
                        @if($product->thumbnail)
                            <img src="{{ $product->thumbnail }}" alt="Товар" />
                        @else
                            <img src="/images/default-product.jpg" alt="Товар" />
                        @endif
                    </a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="tov" colspan="2">
                <p>
                    <a href="{{ $product->getLink() }}">**{{ $product->name }}</a>
                </p>
                <p class="kod">Код {{ $product->code }}</p>
            </td>
        </tr>
        <tr>
            <td class="price" colspan="2">
                <p><span>{{ $productCalculatedPrice }}</span> р.</p>
            </td>
        </tr>
        <tr>
            <td class="price">
                <div class="tovstepper tovstepper--style-2 js-spinner blokleft">
                    <input type="number" min="1" max="9999" wire:model="cartQty" class="tovstepper__input">
                    <div class="tovstepper__controls">
                        <button type="button" wire:click="increase" spinner-button="up">+</button>
                        <button type="button" wire:click="reduce" spinner-button="down">−</button>
                    </div>
                </div>
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
</td>
