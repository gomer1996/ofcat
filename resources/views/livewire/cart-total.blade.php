<td class="korzvert">
    <div class="korzblok">

            <div class="korztext">
                <p>Товары</p>
                <p>{{ $productsCount }} товара на <span>{{ $totalPriceWithoutDiscount }} руб.</span></p>
                @if($this->deliveryPrice)
                    <p>Доставка <span>{{ $this->deliveryPrice }} руб.</span></p>
                @endif
            </div>
            @if ($discountPercent)
                <div class="korzsk">
                    <p>Ваша скидка <span>{{ $discountPercent }}%</span></p>
                </div>
            @endif
            @if($fromPage === 'cart-page')
                <div class="korzdos">
                    <form action="{{ route('checkout.index') }}" method="get" id="to-checkout-form">
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
            @endif
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
                <p>Итого &nbsp; &nbsp; &nbsp; <span>{{ number_format($totalPrice, 2, '.', ',') }} руб.</span></p>
            </div>
            <div>
                <p>
                    <button type="submit" id="cart-total-checkout-btn">
                        <span>ОФОРМИТЬ ЗАКАЗ</span>
                    </button>
                </p>
            </div>

    </div>
</td>

<script>
    $('#cart-total-checkout-btn').on('click', function (){
        const fromPage = '{{ $fromPage }}';
        if (fromPage === 'cart-page') $('#to-checkout-form').submit();
        else $('#checkout-form').submit();
    });
</script>
