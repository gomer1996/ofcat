@if($products)
    <table id="custom-cart-products">
        <tr>
            <td>
                Код
            </td>
            <td>
                Поставщик
            </td>
            <td>
                Наименование
            </td>
            <td>
                Колч
            </td>
            <td>
                Цена
            </td>
        </tr>
    @foreach($products as $product)
        <tr>
            <td>
                {{ $product["options"]["code"] ?? '' }}
            </td>
            <td>
                {{ $product["options"]["integration"] ?? '' }}
            </td>
            <td>
                <a href="{{ url("/admin/resources/products/{$product['id']}") }}" target="_blank">
                    {{ $product["name"] ? substr($product["name"], 0, 70) : '' }} ...
                </a>
            </td>
            <td>
                {{ $product["qty"] }}
            </td>
            <td>
                {{ $product["price"] }}
            </td>
        </tr>
    @endforeach
    </table>
@endif

<style>
    #custom-cart-products td {
        padding: 10px;
    }
</style>
