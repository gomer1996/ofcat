<td>
    <table>
        <tr>
            <td  class="titlegoz">
                @if($product->is_hit)
                    <p><span>ХИТ ПРОДАЖ</span></p>
                @endif
            </td>
            <td class="tovgoz" rowspan="2" style="width: 700px">
                <p>
                    <a href="#">{{ $product->name }}</a>
                </p>
                <p class="kod">Код {{ $product->code }}</p>
                <div>
                    <p>- Вид расходных материалов: листовой.</p>
                    <p>- Артикул: 553100.</p>
                    <p>- Серия: нет.</p>
                </div>
            </td>
            <td class="pricetop" rowspan="2">
                <div class="pricegoz">
                    <p><span>{{ $product->calculated_price }}</span> р.</p>
                </div>
                <div class="tovsteppergoz tovstepper--style-2 js-spinner blokleft">
                    <input type="number" min="1" max="9999" step="1" wire:model="cartQty" class="tovstepper__input">
                    <div class="tovstepper__controls">
                        <button type="button" wire:click="increase" spinner-button="up">+</button>
                        <button type="button" wire:click="reduce" spinner-button="down">−</button>
                    </div>
                </div>
                <p class="buygoz">
                    <a href="#" wire:click.prevent="addToCart({{ $product }})">
                        <span>КУПИТЬ</span>
                    </a>
                </p>
            </td>
        </tr>
        <tr>
            <td  class="imagesgoz" style="width: 130px">
                <div>
                    <a href="{{ route('products.show', $product->id) }}">
                        <img src="{{ $product->thumbnail }}" style="width: 100px; height: auto" alt="Товар" />
                    </a>
                </div>
            </td>
        </tr>
    </table>
</td>
