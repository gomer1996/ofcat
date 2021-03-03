<td class="korzvert">
    <div class="korzblok">
        <form action="{{ route('cart.index') }}" method="get">
            <div class="korztext">
                <p>Товары</p>
                <p>{{ $productsCount }} товара на <span>{{ $totalPriceWithoutDiscount }} руб.</span></p>
                <p>Доставка <span>350 руб.</span></p>
            </div>
            <div class="korzsk">
                <p>Ваша скидка <span>15%</span></p>
            </div>
            <div class="korzdos">
                <p>Доставка</p>
                <label class="korzcont">
                    <input type="radio" name="delivery">
                    Доставка
                </label>
                <label class="korzcont">
                    <input type="radio" name="delivery">
                    Самовывоз
                </label>
            </div>
            <div class="korzpromo">
                <form>
                    <p>Промокод</p>
                    <p class="blokleft">
                        <input class="korzin" wire:model="discount" type="text" required="required"/>
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
                    <a href="#">
                        <span>ОФОРМИТЬ ЗАКАЗ</span>
                    </a>
                </p>
            </div>
        </form>
    </div>
</td>
