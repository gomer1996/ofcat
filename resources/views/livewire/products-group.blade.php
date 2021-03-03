<div id="popular" class="field">
    <div class="category">
        <p>Самое популярное</p>
    </div>
    <table>
        @foreach($products->chunk(4) as $chunk)
            <tr>
                @foreach($chunk as $product)
                    <td>
                    <table>
                        <tr>
                            <td  class="title" colspan="2">
                                <p><span>ХИТ ПРОДАЖ</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td  class="images" colspan="2">
                                <div>
                                    <a href="#">
                                        <img src="/images/600163.jpg" alt="Товар" />
                                    </a>
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
                                <p><span>{{ $product->price }}</span> р.</p>
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
