<div id="korzina">
    <div  class="field">
        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td colspan="4">
                                <p class="korzmy">МОЯ КОРЗИНА</p>
                            </td>
                        </tr>
                        @foreach($cartProducts as $index => $product)
                        <tr>
                            <td>
                                <label class="korzcont">
                                    <input type="checkbox"
                                           {{ $selected->contains($product->rowId) ? "checked" : "" }}
                                           wire:click="selectProduct('{{ $product->rowId }}')">
                                </label>
                            </td>
                            <td>
                                <div class="korzimg">
                                    <a href="#">
                                        @if($product->options["img"])
                                            <img src="{{ $product->options["img"] }}" alt="{{ $product->name }}" />
                                        @endif
                                    </a>
                                </div>
                            </td>
                            <td>
                                <p class="korztov">
                                    <a href="#">{{ $product->name }}</a>
                                </p>
                                <div  class="blokleft">
                                    <p class="korzb">{{ $product->price }} руб.</p>
                                </div>
                                <div class="korzstepper korzstepper--style-2 js-spinner blokleft">
                                    <input type="number" min="1" max="9999" value="{{ $product->qty }}" wire:change.prevent="update($event.target.value, '{{ $product->rowId }}')" class="korzstepper__input">
                                    <div class="korzstepper__controls">
                                        <button type="button" spinner-button="up" wire:click="increase('{{ $product->rowId }}')">+</button>
                                        <button type="button" spinner-button="down" wire:click="reduce('{{ $product->rowId }}')">−</button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="korzbas">
                                    <a href="#" wire:click.prevent="removeProduct('{{ $product->rowId }}')">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="korzbord">
                                <div></div>
                            </td>
                        </tr>
                        @endforeach

                    </table>
                </td>
                <livewire:cart-total :from="'cart-page'" />
            </tr>
            <tr>
                <td colspan="2">
                    <div class="korzmod">
                        <p>
                            <a href="#" wire:click.prevent="removeSelected">Удалить выбранные</a>
                        </p>
                        <p>
                            <a href="#" wire:click.prevent="clearCart">Удалить все</a>
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
