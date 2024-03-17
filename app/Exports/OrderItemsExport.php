<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderItemsExport implements FromCollection
{
    protected $orderId;

    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $result = new Collection();
        $order = Order::find($this->orderId);

        $items = json_decode($order->cart, true);

        foreach ($items as $item) {
            $result->push([
                $item['options']['code'] ?? '',
                $item['options']['integration'] ?? '',
                $item['name'],
                $item['qty'],
                $item['price']
            ]);
        }

        $result->prepend(['Код', 'Поставщик', 'Наименование', 'Колч', 'Цена']);

        return $result;
    }
}
