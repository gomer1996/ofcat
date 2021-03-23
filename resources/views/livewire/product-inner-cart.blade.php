<tr>
    <td class="prod_price" colspan="2">
        <div class="blokleft">
            <p>{{ $product->price }} руб.</p>
        </div>
        <div class="stepper stepper--style-2 js-spinner blokleft">
            <input autofocus type="number" min="1" max="9999" wire:model="cartQty" class="stepper__input">
            <div class="stepper__controls">
                <button type="button" wire:click="increase" spinner-button="up">+</button>
                <button type="button" wire:click="reduce" spinner-button="down">−</button>
            </div>
        </div>

        <script src="js/stepper.min.js"></script>
        <div class="prod_but">
            <a href="#" wire:click.prevent="addToCart({{ $product }})">В КОРЗИНУ</a>
        </div>
    </td>
</tr>
