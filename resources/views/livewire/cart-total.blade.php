<td class="korzvert">
    <div class="korzblok">

            <div class="korztext">
                <p>Товары</p>
                <p>{{ $productsCount }} товара на <span>{{ $totalPriceWithoutDiscount }} руб.</span></p>
                <p>Доставка <span>350 руб.</span></p>
            </div>
            @if ($discountPercent)
                <div class="korzsk">
                    <p>Ваша скидка <span>{{ $discountPercent }}%</span></p>
                </div>
            @endif
            <div class="korzdos">
                <form action="{{ route('cart.index') }}" method="get" id="checkout-form">
                    <p>Доставка</p>
                    <label class="korzcont">
                        <input type="radio" name="delivery" value="delivery" required>
                        Доставка
                    </label>
                    <label class="korzcont">
                        <input type="radio" name="delivery" value="pickup" required>
                        Самовывоз
                    </label>
                </form>
            </div>
            <div class="korzpromo">
                <form>
                    <p>Промокод</p>
                    <p class="blokleft">
                        <input class="korzin" wire:model="userDiscount" type="text" required="required"/>
                    </p>
                    <p>
                        <input class="korzsub" wire:click.prevent="applyDiscount" type="submit" value="ПРИМЕНИТЬ" />
                    </p>
                </form>
            </div>
            <div class="korzitog">
                <p>Итого &nbsp; &nbsp; &nbsp; <span>{{ $totalPrice }} руб.</span></p>
            </div>
            <div>
                <p>
                    <button type="submit" onclick="event.preventDefault(); $('#checkout-form').submit();">
                        <span>ОФОРМИТЬ ЗАКАЗ</span>
                    </button>
                </p>
            </div>

    </div>
</td>
